<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thanh toán - BADMINTON PRO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f3f4f6;
            color: #1f2937;
            font-family: Arial, Helvetica, sans-serif;
        }
        .checkout-shell {
            max-width: 1400px;
            margin: 0 auto;
            padding: 16px 16px 40px;
        }
        .main-content {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 16px;
        }
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            padding: 0 0 8px;
            border-bottom: 1px solid #e5e7eb;
            grid-column: 1 / -1;
        }
        .back-link {
            color: #f08a2d;
            font-weight: 700;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: color 0.2s ease;
            text-decoration: none;
        }
        .back-link:hover {
            color: #e56a0b;
        }
        .brand {
            font-size: 18px;
            font-weight: 900;
            letter-spacing: -0.04em;
            color: #1f2937;
            text-transform: uppercase;
            text-align: center;
            flex: 1;
        }
        .left-column {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .right-column {
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: sticky;
            top: 16px;
            height: fit-content;
        }
        .main-panel {
            background: transparent;
            border: none;
            border-radius: 0;
            overflow: visible;
            box-shadow: none;
            position: relative;
            display: contents;
        }
        .main-panel::before,
        .main-panel::after {
            display: none;
        }
        .section-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 16px;
            margin: 0;
        }
        .shipping-methods {
            margin-top: 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .shipping-option-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 12px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #fff;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .shipping-option-item.active {
            border-color: #f59e0b;
            background: #fff7ed;
            box-shadow: 0 0 0 1px rgba(245, 158, 11, 0.15);
        }
        .shipping-option-main {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .shipping-radio {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid #d1d5db;
            position: relative;
            flex-shrink: 0;
        }
        .shipping-option-item.active .shipping-radio {
            border-color: #f59e0b;
        }
        .shipping-option-item.active .shipping-radio::after {
            content: "";
            position: absolute;
            inset: 3px;
            border-radius: 50%;
            background: #f59e0b;
        }
        .shipping-label {
            font-size: 15px;
            font-weight: 700;
            color: #1f2937;
        }
        .shipping-date {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
        }
        .shipping-price {
            font-size: 14px;
            font-weight: 800;
            color: #1f2937;
        }
        .payment-methods {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 12px;
        }
        .payment-option {
            min-width: 120px;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            background: #fff;
            border-radius: 8px;
            color: #374151;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
        }
        .payment-option.active {
            border-color: #f97316;
            background: #fff7ed;
            box-shadow: inset 0 0 0 1px rgba(249, 115, 22, 0.2);
            color: #f97316;
        }
        .payment-option .checkmark {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 18px;
            height: 18px;
            background: #f97316;
            border-radius: 50%;
            color: #fff;
            font-size: 11px;
            display: none;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        .payment-option.active .checkmark {
            display: flex;
        }
        .address-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 0 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .address-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #f07a1b;
            font-weight: 900;
            font-size: 17px;
            line-height: 1.2;
        }
        .address-title .pin {
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: linear-gradient(180deg, #ff8d3e, #f56b1f);
            display: inline-block;
            position: relative;
            box-shadow: 0 0 0 3px rgba(240,122,27,0.12);
        }
        .address-title .pin::after {
            content: "";
            position: absolute;
            width: 5px;
            height: 5px;
            background: white;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .change-link {
            color: #2b8fe9;
            font-weight: 700;
            font-size: 12px;
        }
        .address-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding-top: 10px;
            font-size: 14px;
        }
        .customer-info {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #1f2937;
            font-weight: 700;
        }
        .customer-info .phone {
            font-weight: 600;
            color: #3b3b3b;
        }
        .default-badge {
            display: inline-block;
            background: #e4f7f0;
            color: #0e8f6d;
            border: 1px solid #98dcc1;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 7px;
            margin-left: 8px;
            vertical-align: middle;
        }
        .product-list {
            padding: 0 0 8px;
            grid-column: auto;
        }
        .table-header,
        .product-row {
            display: grid;
            grid-template-columns: 1.9fr 0.7fr 0.7fr 0.7fr;
            align-items: center;
            gap: 10px;
        }
        .table-header {
            color: #444;
            font-weight: 700;
            font-size: 14px;
            padding: 12px 16px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .product-row {
            padding: 12px 16px;
            border-bottom: 1px solid #ece7e3;
            min-height: 86px;
        }
        .product-main {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
        }
        .thumb {
            width: 58px;
            height: 58px;
            border-radius: 8px;
            border: 1px solid #e8e3df;
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-weight: 700;
            font-size: 11px;
            box-shadow: inset 0 1px 1px rgba(255,255,255,0.7);
        }
        .product-name {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 2px;
        }
        .product-meta {
            color: #6b7280;
            font-size: 12px;
        }
        .price,
        .qty,
        .total {
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }
        .total {
            color: #f97316;
            font-weight: 800;
            text-align: right;
        }
        .promo-box {
            padding: 10px 10px 0;
        }
        .promo-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
            margin-top: 10px;
        }
        .promo-left {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #374151;
            font-weight: 600;
        }
        .coupon-tag {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #e5f1ff;
            color: #0d72d6;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
            border: 1px solid #9ec8ff;
        }
        .text-gray-subtle {
            color: #6b7280;
        }
        .voucher-row {
            display: flex;
            gap: 18px;
            align-items: stretch;
            padding: 10px 8px 8px;
            border-top: 1px solid #e5e7eb;
            margin-top: 10px;
        }
        .voucher-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            width: 100%;
            padding: 0 4px 12px;
            margin: 0 0 8px;
            border-top: none;
            border-bottom: 1px dashed #d1d5db;
            min-height: 52px;
        }
        .voucher-title {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #1f2937;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        .voucher-title .voucher-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            border-radius: 6px;
            color: #ef6b2c;
            font-size: 16px;
            background: #fff7ed;
            border: 1px solid #f9c7a2;
        }
        .voucher-panel {
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
            margin-top: 10px;
        }
        .voucher-box {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: white;
            padding: 6px 10px;
            min-height: 42px;
            width: 100%;
            box-sizing: border-box;
            overflow: hidden;
            flex: 1;
        }
        .voucher-box .label {
            font-size: 13px;
            color: #374151;
            font-weight: 700;
            flex-shrink: 0;
        }
        .note-input {
            width: 100%;
            min-width: 0;
            border: none;
            background: transparent;
            outline: none;
            color: #374151;
            font-size: 12px;
            resize: none;
            line-height: 1.4;
            padding: 0;
            min-height: 20px;
        }
        .note-input::placeholder {
            color: #9ca3af;
        }
        .voucher-button {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            width: 100%;
            background: #fff7ed;
            border: 1px solid #f7c49f;
            border-radius: 10px;
            color: #f26b1d;
            font-size: 15px;
            font-weight: 700;
            padding: 10px 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: right;
            margin-right: 4px;
            position: relative;
            min-width: 180px;
        }
        .voucher-button:hover {
            color: #d95d0d;
            border-color: #f29a58;
            box-shadow: 0 6px 12px rgba(242, 107, 29, 0.08);
        }
        .voucher-button strong {
            color: #1a73d1;
            font-size: 13px;
        }
        .voucher-dropdown {
            position: relative;
            display: flex;
            justify-content: flex-end;
            min-width: 200px;
        }
        .voucher-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 240px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
            padding: 10px;
            display: none;
            z-index: 30;
        }
        .voucher-dropdown:hover .voucher-menu,
        .voucher-dropdown:focus-within .voucher-menu,
        .voucher-dropdown.open .voucher-menu {
            display: block;
        }
        .voucher-option-label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 10px;
            border-radius: 10px;
            color: #1f2937;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: background 0.2s ease, color 0.2s ease;
            line-height: 1.4;
            cursor: pointer;
            user-select: none;
        }
        .voucher-option-label:hover {
            background: #fff7ed;
            color: #f97316;
        }
        .voucher-option-checkbox {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #f97316;
            flex-shrink: 0;
        }
        .voucher-option-text {
            flex: 1;
        }
        .selected-vouchers-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }
        .selected-voucher-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            background: #eefaf3;
            border: 1px solid #bfe8d0;
            color: #0e8b5d;
            font-weight: 600;
            font-size: 12px;
        }
        .selected-voucher-badge .remove-voucher {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: rgba(14, 139, 93, 0.2);
            color: #0e8b5d;
            transition: background 0.2s ease;
        }
        .selected-voucher-badge .remove-voucher:hover {
            background: rgba(14, 139, 93, 0.4);
        }
        .selected-voucher-tag {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 10px;
            background: #eefaf3;
            border: 1px solid #bfe8d0;
            color: #0e8b5d;
            font-weight: 700;
            font-size: 13px;
            margin-top: 8px;
        }
        .selected-voucher-tag .tag-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #d9f6e7;
            color: #0e8b5d;
            font-size: 11px;
        }
        .select-voucher {
            color: #1f8de0;
            font-weight: 700;
            font-size: 14px;
            white-space: nowrap;
        }
        .summary {
            padding: 8px 10px 2px;
            border-top: 1px solid #e5e7eb;
            margin-top: 12px;
        }
        .summary-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            color: #374151;
            margin-bottom: 8px;
            line-height: 1.4;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .summary-line strong {
            font-weight: 700;
        }
        .summary-total {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            font-weight: 800;
            line-height: 1.4;
        }
        .pay-box {
            margin-top: 0;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 16px;
            grid-column: auto;
        }
        .pay-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 15px;
            font-weight: 800;
            color: #1f2937;
            padding-bottom: 8px;
        }
        .pay-method {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            color: #374151;
            font-weight: 600;
            padding-top: 10px;
        }
        .radio {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid #f97316;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .radio::after {
            content: "";
            width: 8px;
            height: 8px;
            background: #f97316;
            border-radius: 50%;
            display: block;
        }
        .summary-right {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 16px;
        }
        .order-button-wrap {
            display: flex;
            justify-content: flex-end;
            margin-top: 26px;
            grid-column: 1 / -1;
        }
        .order-button {
            background: linear-gradient(180deg, #ff963d, #f46d19);
            border: none;
            color: white;
            font-weight: 800;
            font-size: 16px;
            letter-spacing: 0.03em;
            border-radius: 10px;
            padding: 12px 32px;
            min-width: 220px;
            box-shadow: 0 4px 0 rgba(230, 109, 25, 0.92);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }
        .order-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 0 rgba(230, 109, 25, 0.92);
        }
        @media (max-width: 1024px) {
            .main-content {
                grid-template-columns: 1fr;
            }
            .right-column {
                position: static;
            }
        }
        @media (max-width: 768px) {
            .brand { font-size: 26px; }
            .address-content { flex-direction: column; align-items: flex-start; }
            .table-header { display: none; }
            .product-row { grid-template-columns: 1fr; }
            .price, .qty, .total { text-align: left; }
            .order-button-wrap { justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="checkout-shell">
        <div class="topbar">
            <a href="{{ route('cart.index') }}" class="back-link">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Quay lại</span>
            </a>
            <div class="brand">BADMINTON PRO</div>
        </div>

        <div class="main-content">
            <div class="left-column">
                <div class="main-panel">
                    <div class="section-card">
                        <div class="address-header">
                            <div class="address-title">
                                <span class="pin"></span>
                                <span>Địa Chỉ Nhận Hàng</span>
                            </div>
                            <button type="button" id="open-address-modal" class="change-link" style="background:none;border:none;padding:0;cursor:pointer;">Thay đổi</button>
                        </div>

                        @if($address)
                            <div class="address-content" id="checkout-address-summary" data-address-id="{{ $address->id }}">
                                <div class="customer-info">
                                    <span id="selected-address-name">{{ $address->ten_nguoi_nhan }}</span>
                                    <span class="phone" id="selected-address-phone">(+84) {{ $address->so_dien_thoai }}</span>
                                    @if($address->is_default)
                                        <span class="default-badge">Mặc định</span>
                                    @endif
                                </div>
                                <div class="text-right text-gray-700" id="selected-address-text">
                                    {{ $address->tinh_thanh }}, {{ $address->phuong_xa }}, {{ $address->dia_chi_chi_tiet }}
                                </div>
                            </div>
                        @else
                            <div class="address-content">
                                <div class="text-gray-600">Chưa có địa chỉ giao hàng.</div>
                            </div>
                        @endif
                    </div>

                    <div class="section-card product-list">
                        <div class="table-header">
                            <div>Sản phẩm</div>
                            <div class="text-center">Đơn giá</div>
                            <div class="text-center">Số lượng</div>
                            <div class="text-right">Thành tiền</div>
                        </div>

                        @foreach($items as $item)
                            <div class="product-row">
                                <div class="product-main">
                                    <div class="thumb">
                                        <img src="{{ asset('images/' . ($item['anh'] ?? 'default.png')) }}" alt="{{ $item['ten'] }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <div class="product-name">{{ $item['ten'] }}</div>
                                        @if(!empty($item['size']))
                                            <div class="product-meta">Size: {{ $item['size'] }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="price">{{ number_format($item['gia'], 0, ',', '.') }}₫</div>
                                <div class="qty">{{ $item['so_luong'] }}</div>
                                <div class="total">{{ number_format($item['line_total'], 0, ',', '.') }}₫</div>
                            </div>
                        @endforeach

                        <div class="promo-box">
                            <div class="voucher-header-row">
                                <div class="voucher-title">
                                    <span class="voucher-icon"><i class="fa-solid fa-ticket"></i></span>
                                    <span>Voucher</span>
                                </div>
                                <div class="voucher-dropdown">
                                    <button type="button" class="voucher-button" aria-label="Chọn voucher">
                                        <span id="voucher-dropdown-label">Chọn Voucher</span>
                                    </button>
                                    <div class="voucher-menu">
                                        @foreach($voucherOptions as $code => $option)
                                            <label class="voucher-option-label">
                                                <input type="checkbox" class="voucher-option-checkbox" 
                                                       data-code="{{ $code }}"
                                                       data-label="{{ $option['label'] }}"
                                                       data-type="{{ $option['type'] }}"
                                                       data-value="{{ $option['value'] }}">
                                                <span class="voucher-option-text">
                                                    {{ $option['label'] }}
                                                    @if($option['type'] === 'shipping')
                                                        - Miễn phí ship
                                                    @else
                                                        - Giảm {{ $option['value'] }}%
                                                    @endif
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div id="selected-vouchers-display" class="mt-2">
                                <div class="text-gray-500">Chưa chọn voucher</div>
                            </div>

                            <div class="voucher-row">
                                <div class="voucher-box">
                                    <div class="label">Lời nhắn:</div>
                                    <textarea class="note-input" rows="1" placeholder="Lưu ý cho người bán..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-card">
                        <div class="address-header" style="padding-bottom: 12px;">
                            <div class="address-title" style="font-size: 15px;">
                                <span class="pin"></span>
                                <span>Phương thức vận chuyển</span>
                            </div>
                        </div>

                        <div class="shipping-methods">
                            <div class="shipping-option-item" data-extra="30000" data-name="Nhanh">
                                <div class="shipping-option-main">
                                    <span class="shipping-radio"></span>
                                    <div>
                                        <div class="shipping-label">Nhanh</div>
                                        <div class="shipping-date">2 Thg 9 - 4 Thg 9</div>
                                    </div>
                                </div>
                                <div class="shipping-price">{{ number_format($shippingFee + 30000, 0, ',', '.') }}₫</div>
                            </div>

                            <div class="shipping-option-item active" data-extra="0" data-name="Tiết kiệm">
                                <div class="shipping-option-main">
                                    <span class="shipping-radio"></span>
                                    <div>
                                        <div class="shipping-label">Tiết kiệm</div>
                                        <div class="shipping-date">5 Thg 9 - 7 Thg 9</div>
                                    </div>
                                </div>
                                <div class="shipping-price">{{ number_format($shippingFee, 0, ',', '.') }}₫</div>
                            </div>
                        </div>
                    </div>

                    <div class="section-card">
                        <div class="address-header" style="padding-bottom: 12px;">
                            <div class="address-title" style="font-size: 15px;">
                                <span class="pin"></span>
                                <span>Phương thức thanh toán</span>
                            </div>
                        </div>

                        <div class="payment-methods">
                            <div class="payment-option active" data-method="VietQR">
                                <span>VietQR</span>
                                <span class="checkmark">✓</span>
                            </div>
                            <div class="payment-option" data-method="CashOnDelivery">
                                <span>Thanh toán khi nhận hàng</span>
                                <span class="checkmark">✓</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="right-column">
                <div class="summary-right">
                    <div style="font-size: 15px; font-weight: 800; color: #1f2937; margin-bottom: 12px;">Tóm tắt đơn hàng</div>
                    
                    <div class="summary">
                        <div class="summary-line">
                            <div>Tổng tiền hàng</div>
                            <strong>{{ number_format($subtotal, 0, ',', '.') }}₫</strong>
                        </div>
                        <div class="summary-line">
                            <div>Phí vận chuyển:</div>
                            <strong id="shipping-fee" data-shipping="{{ $shippingFee }}" data-base-region="{{ $shippingFee }}">{{ number_format($shippingFee, 0, ',', '.') }}₫</strong>
                        </div>
                        @if($distanceKm > 0)
                            <div class="summary-line" style="font-size: 12px; color: #4b5563;">
                                <div>Khoảng cách ước tính</div>
                                <strong>{{ number_format($distanceKm, 1, ',', '.') }} km</strong>
                            </div>
                        @endif
                        <div class="summary-line">
                            <div>Voucher giảm giá</div>
                            <strong id="voucher-discount" data-discount="{{ $voucher }}" class="text-blue-600">-{{ number_format($voucher, 0, ',', '.') }}₫</strong>
                        </div>
                        <div class="summary-total">
                            <div>Tổng thanh toán</div>
                            <div id="final-total" data-total="{{ $finalTotal }}" class="text-orange-500">{{ number_format($finalTotal, 0, ',', '.') }}₫</div>
                        </div>
                    </div>
                </div>

                <div class="order-button-wrap" style="grid-column: auto; margin-top: 18px;">
                    <button type="button" class="order-button" id="place-order-button">ĐẶT HÀNG</button>
                </div>
            </div>
        </div>
    </div>

    <div id="checkout-address-modal" class="fixed inset-0 z-50 hidden bg-black/30 backdrop-blur-[1px]">
        <div class="absolute inset-0" data-close-address-modal="true"></div>
        <div class="relative mx-auto mt-16 w-[92%] max-w-[720px] rounded-xl bg-white shadow-2xl border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
                <h3 class="text-lg font-bold text-slate-800">Địa Chỉ Của Tôi</h3>
                <button type="button" id="close-address-modal" class="text-2xl leading-none text-gray-500 hover:text-gray-700">&times;</button>
            </div>

            <div class="max-h-[420px] overflow-y-auto p-4">
                @if($addresses && $addresses->count())
                    @foreach($addresses as $item)
                        <label class="mb-3 flex cursor-pointer items-start gap-3 rounded-xl border {{ ($address && $address->id == $item->id) ? 'border-orange-400 bg-orange-50' : 'border-gray-200 bg-white' }} p-3 transition hover:border-orange-300">
                            <input type="radio" name="checkout_address_choice" value="{{ $item->id }}" {{ ($address && $address->id == $item->id) ? 'checked' : '' }} class="mt-1 h-4 w-4 accent-orange-500">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-base font-bold text-slate-800">{{ $item->ten_nguoi_nhan }}</span>
                                    <span class="text-sm text-slate-600">(+84) {{ $item->so_dien_thoai }}</span>
                                    @if($item->is_default)
                                        <span class="rounded bg-orange-100 px-2 py-0.5 text-[10px] font-bold uppercase text-orange-600">Mặc định</span>
                                    @endif
                                </div>
                                <div class="mt-1 text-sm text-slate-600">
                                    {{ $item->dia_chi_chi_tiet }}, {{ $item->phuong_xa }}, {{ $item->tinh_thanh }}
                                </div>
                            </div>
                            <a href="{{ route('checkout.address.edit', ['items' => request()->query('items'), 'address_id' => $item->id]) }}" class="whitespace-nowrap text-sm font-semibold text-blue-600 hover:text-blue-700">Thay đổi địa chỉ</a>
                        </label>
                    @endforeach
                @else
                    <div class="rounded-lg border border-dashed border-gray-300 p-6 text-center text-sm text-gray-500">
                        Bạn chưa có địa chỉ nào.
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-between border-t border-gray-200 bg-slate-50 px-5 py-4">
                <a href="{{ route('checkout.address', ['items' => request()->query('items'), 'return_to_checkout' => 1]) }}" class="rounded-lg bg-orange-500 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-orange-600">+ Thêm địa chỉ mới</a>
                <button type="button" id="confirm-address-modal" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-bold text-white hover:bg-slate-700">Xác nhận</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const subtotalValue = {{ (float) $subtotal }};
            const shippingFeeEl = document.getElementById('shipping-fee');
            const voucherDiscountEl = document.getElementById('voucher-discount');
            const finalTotalEl = document.getElementById('final-total');
            const selectedVouchersDisplayEl = document.getElementById('selected-vouchers-display');
            const voucherDropdownLabelEl = document.getElementById('voucher-dropdown-label');
            const voucherDropdown = document.querySelector('.voucher-dropdown');
            const voucherCheckboxes = document.querySelectorAll('.voucher-option-checkbox');
            const shippingOptions = document.querySelectorAll('.shipping-option-item');
            const paymentOptions = document.querySelectorAll('.payment-option');
            const addressModal = document.getElementById('checkout-address-modal');
            const openAddressModalBtn = document.getElementById('open-address-modal');
            const closeAddressModalBtn = document.getElementById('close-address-modal');
            const confirmAddressModalBtn = document.getElementById('confirm-address-modal');
            const selectedAddressSummary = document.getElementById('checkout-address-summary');
            const selectedAddressName = document.getElementById('selected-address-name');
            const selectedAddressPhone = document.getElementById('selected-address-phone');
            const selectedAddressText = document.getElementById('selected-address-text');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const placeOrderButton = document.getElementById('place-order-button');

            function openAddressModal() {
                if (addressModal) addressModal.classList.remove('hidden');
            }

            function closeAddressModal() {
                if (addressModal) addressModal.classList.add('hidden');
            }

            if (openAddressModalBtn) {
                openAddressModalBtn.addEventListener('click', openAddressModal);
            }

            if (closeAddressModalBtn) {
                closeAddressModalBtn.addEventListener('click', closeAddressModal);
            }

            document.querySelectorAll('[data-close-address-modal="true"]').forEach(item => {
                item.addEventListener('click', closeAddressModal);
            });

            // Add event listeners to radio buttons to update styling
            const addressRadios = document.querySelectorAll('input[name="checkout_address_choice"]');
            addressRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Update all labels styling
                    document.querySelectorAll('input[name="checkout_address_choice"]').forEach(r => {
                        const label = r.closest('label');
                        if (label) {
                            if (r.checked) {
                                label.classList.remove('border-gray-200', 'bg-white');
                                label.classList.add('border-orange-400', 'bg-orange-50');
                            } else {
                                label.classList.remove('border-orange-400', 'bg-orange-50');
                                label.classList.add('border-gray-200', 'bg-white');
                            }
                        }
                    });
                });
            });

            if (confirmAddressModalBtn) {
                confirmAddressModalBtn.addEventListener('click', async function () {
                    const selectedAddressRadio = document.querySelector('input[name="checkout_address_choice"]:checked');
                    if (!selectedAddressRadio) {
                        return;
                    }

                    const selectedId = selectedAddressRadio.value;
                    confirmAddressModalBtn.disabled = true;
                    confirmAddressModalBtn.textContent = 'Đang lưu...';

                    try {
                        const response = await fetch('/tai-khoan/dia-chi/mac-dinh/' + selectedId, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({}),
                            credentials: 'same-origin'
                        });

                        // Reload regardless of response, to refresh the page with new default address
                        await new Promise(resolve => setTimeout(resolve, 300));
                        const checkoutUrl = new URL(window.location.href);
                        checkoutUrl.searchParams.set('address_id', selectedId);
                        window.location.href = checkoutUrl.toString();
                    } catch (error) {
                        console.error('Error:', error);
                        confirmAddressModalBtn.disabled = false;
                        confirmAddressModalBtn.textContent = 'Xác nhận';
                        // Still reload to refresh, even if request failed
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                });
            }

            let selectedVouchers = {};
            const regionBaseFee = Number(shippingFeeEl.dataset.baseRegion || shippingFeeEl.dataset.shipping || 0);
            let selectedShippingFee = regionBaseFee;

            const defaultSavingsOption = document.querySelector('.shipping-option-item[data-name="Tiết kiệm"]');
            if (defaultSavingsOption) {
                defaultSavingsOption.classList.add('active');
                shippingOptions.forEach(item => {
                    if (item !== defaultSavingsOption) item.classList.remove('active');
                });
                selectedShippingFee = regionBaseFee;
                shippingFeeEl.dataset.shipping = String(selectedShippingFee);
                shippingFeeEl.textContent = formatMoney(selectedShippingFee);
                calculateTotals();
            }

            paymentOptions.forEach(option => {
                option.addEventListener('click', function () {
                    paymentOptions.forEach(item => item.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            shippingOptions.forEach(option => {
                option.addEventListener('click', function () {
                    shippingOptions.forEach(item => item.classList.remove('active'));
                    this.classList.add('active');

                    const extraFee = Number(this.dataset.extra || 0);
                    selectedShippingFee = regionBaseFee + extraFee;
                    shippingFeeEl.dataset.shipping = String(selectedShippingFee);
                    shippingFeeEl.textContent = formatMoney(selectedShippingFee);

                    calculateTotals();
                });
            });

            function formatMoney(value) {
                return new Intl.NumberFormat('vi-VN').format(Math.max(0, Math.round(value))) + '₫';
            }

            function updateVoucherDisplay() {
                const selectedCodes = Object.keys(selectedVouchers);
                
                if (selectedCodes.length === 0) {
                    selectedVouchersDisplayEl.innerHTML = '<div class="text-gray-500">Chưa chọn voucher</div>';
                    voucherDropdownLabelEl.textContent = 'Chọn Voucher';
                } else {
                    let displayHTML = '<div class="selected-vouchers-container">';
                    selectedCodes.forEach(code => {
                        const voucher = selectedVouchers[code];
                        displayHTML += `
                            <div class="selected-voucher-badge">
                                <i class="fa-solid fa-check"></i>
                                <span>${voucher.label}</span>
                                <span class="remove-voucher" data-code="${code}">
                                    <i class="fa-solid fa-times" style="font-size: 10px;"></i>
                                </span>
                            </div>
                        `;
                    });
                    displayHTML += '</div>';
                    selectedVouchersDisplayEl.innerHTML = displayHTML;
                    voucherDropdownLabelEl.textContent = `Đã chọn ${selectedCodes.length} voucher`;

                    document.querySelectorAll('.remove-voucher').forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            const code = this.dataset.code;
                            const checkbox = document.querySelector(`input[data-code="${code}"]`);
                            if (checkbox) {
                                checkbox.checked = false;
                                checkbox.dispatchEvent(new Event('change'));
                            }
                        });
                    });
                }
            }

            function calculateTotals() {
                let shippingFee = selectedShippingFee;
                let totalDiscount = 0;
                let hasShippingFree = false;

                Object.values(selectedVouchers).forEach(voucher => {
                    if (voucher.type === 'shipping') {
                        hasShippingFree = true;
                    } else if (voucher.type === 'percent') {
                        totalDiscount += subtotalValue * (Number(voucher.value) / 100);
                    }
                });

                if (hasShippingFree) {
                    shippingFee = 0;
                }

                const finalTotal = Math.max(0, subtotalValue + shippingFee - totalDiscount);

                shippingFeeEl.textContent = formatMoney(shippingFee);
                voucherDiscountEl.textContent = '-' + formatMoney(totalDiscount);
                finalTotalEl.textContent = formatMoney(finalTotal);

                shippingFeeEl.dataset.shipping = String(shippingFee);
                voucherDiscountEl.dataset.discount = String(totalDiscount);
                finalTotalEl.dataset.total = String(finalTotal);
            }

            voucherCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const code = this.dataset.code;
                    
                    if (this.checked) {
                        selectedVouchers[code] = {
                            code: code,
                            label: this.dataset.label,
                            type: this.dataset.type,
                            value: this.dataset.value
                        };
                    } else {
                        delete selectedVouchers[code];
                    }

                    updateVoucherDisplay();
                    calculateTotals();
                });
            });

            updateVoucherDisplay();

            if (placeOrderButton) {
                placeOrderButton.addEventListener('click', async function () {
                    const addressId = selectedAddressSummary?.dataset.addressId;
                    const paymentMethod = document.querySelector('.payment-option.active')?.dataset.method;
                    const itemIds = @json(request()->query('items'));

                    if (!addressId || !paymentMethod) {
                        alert('Vui lòng kiểm tra địa chỉ và phương thức thanh toán.');
                        return;
                    }

                    placeOrderButton.disabled = true;
                    placeOrderButton.textContent = 'ĐANG XỬ LÝ...';

                    try {
                        const response = await fetch('{{ route('checkout.place-order') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken || '',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                items: itemIds,
                                address_id: addressId,
                                payment_method: paymentMethod,
                                shipping_fee: shippingFeeEl.dataset.shipping,
                                voucher_code: Object.keys(selectedVouchers)[0] || null
                            }),
                            credentials: 'same-origin'
                        });

                        const result = await response.json();
                        if (!response.ok) {
                            throw new Error(result.message || 'Không thể tạo đơn hàng.');
                        }

                        window.location.href = result.redirect;
                    } catch (error) {
                        alert(error.message);
                        placeOrderButton.disabled = false;
                        placeOrderButton.textContent = 'ĐẶT HÀNG';
                    }
                });
            }
        });
    </script>
</body>
</html>
