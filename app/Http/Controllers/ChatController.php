<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function userMessages()
    {
        $messages = ChatMessage::where('nguoi_dung_id', auth()->id())
            ->orderBy('id')
            ->get(['id', 'sender_role', 'message', 'created_at']);

        ChatMessage::where('nguoi_dung_id', auth()->id())
            ->where('sender_role', 'nhan_vien')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json($messages);
    }

    public function userSend(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $message = ChatMessage::create([
            'nguoi_dung_id' => auth()->id(),
            'sender_id' => auth()->id(),
            'sender_role' => 'khach_hang',
            'message' => $validated['message'],
        ]);

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function employeeSend(Request $request, $userId)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $user = User::findOrFail($userId);
        $message = ChatMessage::create([
            'nguoi_dung_id' => $user->id,
            'sender_id' => auth()->id(),
            'sender_role' => 'nhan_vien',
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Đã gửi phản hồi cho ' . $user->ho_ten . '.');
    }
}