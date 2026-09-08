<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SepayWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $expectedKey = (string) config('services.sepay.webhook_api_key');
        $authorization = (string) $request->header('Authorization');
        $providedKey = Str::startsWith($authorization, 'Apikey ')
            ? trim(Str::after($authorization, 'Apikey '))
            : trim($request->header('X-API-Key', ''));

        if ($expectedKey === '' || !hash_equals($expectedKey, $providedKey)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $payload = $request->json()->all();
        $transactionId = (string) ($payload['id'] ?? $payload['referenceCode'] ?? '');
        $transferType = strtolower((string) ($payload['transferType'] ?? 'in'));
        $amount = (float) ($payload['transferAmount'] ?? $payload['amount'] ?? 0);
        $content = trim(implode(' ', array_filter([
            $payload['code'] ?? null,
            $payload['content'] ?? null,
            $payload['description'] ?? null,
        ])));

        if ($transferType === 'out' || $amount <= 0 || $content === '') {
            logger()->info('SePay webhook ignored: invalid incoming transfer.', [
                'transfer_type' => $transferType,
                'amount' => $amount,
                'has_content' => $content !== '',
            ]);
            return response()->json(['success' => true]);
        }

        $order = DonHang::where('phuong_thuc_thanh_toan', 'VietQR')
            ->where(function ($query) use ($content) {
                $query->where('ma_don_hang', $content)
                    ->orWhereRaw('? LIKE CONCAT("%", ma_don_hang, "%")', [$content]);
            })
            ->first();

        if (!$order) {
            logger()->warning('SePay webhook ignored: order code was not found.', [
                'content' => $content,
            ]);

            return response()->json(['success' => true]);
        }

        $expectedAmount = (float) $order->tong_thanh_toan;
        if (abs($expectedAmount - $amount) > 0.01) {
            logger()->warning('SePay webhook ignored: amount mismatch.', [
                'order_id' => $order->id,
                'expected_amount' => $expectedAmount,
                'received_amount' => $amount,
            ]);

            return response()->json(['success' => true]);
        }

        if ($order->qr_expires_at && $order->qr_expires_at->isPast()) {
            logger()->warning('SePay webhook ignored: QR code expired.', [
                'order_id' => $order->id,
                'expired_at' => $order->qr_expires_at->toDateTimeString(),
            ]);

            return response()->json(['success' => true]);
        }

        DB::transaction(function () use ($order, $transactionId) {
            $lockedOrder = DonHang::whereKey($order->id)->lockForUpdate()->first();

            if ($lockedOrder->trang_thai_thanh_toan === 'da_thanh_toan') {
                return;
            }

            $lockedOrder->update([
                'trang_thai_thanh_toan' => 'da_thanh_toan',
                'sepay_transaction_id' => $transactionId ?: null,
                'thoi_diem_thanh_toan' => now(),
            ]);
        });

        return response()->json(['success' => true]);
    }
}