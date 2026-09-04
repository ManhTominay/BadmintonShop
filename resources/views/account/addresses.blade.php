<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Địa Chỉ Của Tôi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f3f4f6;
            font-family: Arial, sans-serif;
        }

        .address-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0;
            padding: 18px 20px 0;
            max-width: 980px;
            margin: 0 auto;
            box-shadow: none;
        }

        .address-item {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            padding: 16px 0 18px;
            border-bottom: 1px solid #ececec;
        }

        .address-item:last-child {
            border-bottom: none;
        }

        .address-main {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            flex: 1;
        }

        .address-radio {
            width: 18px;
            height: 18px;
            border: 2px solid #b9bec5;
            border-radius: 50%;
            position: relative;
            flex-shrink: 0;
            margin-top: 4px;
        }

        .address-item.active .address-radio {
            border-color: #f97316;
        }

        .address-item.active .address-radio::after {
            content: "";
            position: absolute;
            inset: 3px;
            background: #f97316;
            border-radius: 50%;
        }

        .address-text {
            flex: 1;
            font-size: 15px;
        }

        .name-phone {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
            flex-wrap: wrap;
        }

        .name-phone strong {
            font-size: 18px;
            color: #111827;
            font-weight: 700;
        }

        .phone {
            font-size: 16px;
            color: #111827;
        }

        .address-detail {
            color: #4b5563;
            font-size: 15px;
            line-height: 1.6;
        }

        .default-badge {
            display: inline-block;
            font-size: 12px;
            color: #fff;
            background: #f97316;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 700;
            margin-left: 8px;
            vertical-align: middle;
        }

        .address-action {
            color: #1d4ed8;
            font-size: 16px;
            font-weight: 600;
            white-space: nowrap;
            padding-top: 4px;
            text-decoration: none;
        }

        .add-address-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            background: linear-gradient(180deg, #ff7a38, #ee5b2a);
            color: white;
            font-weight: 700;
            border-radius: 8px;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            font-size: 18px;
            margin-top: 22px;
        }

        .top-bar {
            max-width: 980px;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            background: #fff;
            border: 1px solid #e5e7eb;
            padding: 18px 20px;
        }

        .top-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }

        .close-btn {
            font-size: 26px;
            color: #6b7280;
            text-decoration: none;
            line-height: 1;
        }

        @media (max-width: 640px) {
            .address-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .address-action {
                padding-top: 0;
            }
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="top-title">Địa Chỉ Của Tôi</div>
        <a href="{{ route('account.profile') }}" class="close-btn" aria-label="Đóng">&times;</a>
    </div>

    <div class="address-card">
        @if(session('success'))
            <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @forelse($addresses as $address)
            <div class="address-item {{ $address->is_default ? 'active' : '' }}">
                <div class="address-main">
                    <div class="address-radio" aria-hidden="true"></div>
                    <div class="address-text">
                        <div class="name-phone">
                            <strong>{{ $address->ten_nguoi_nhan }}</strong>
                            <span class="phone">| ({{ substr(str_replace([' ', '-', '.'], '', $address->so_dien_thoai), 0, 2) == '84' ? '+'.substr(str_replace([' ', '-', '.'], '', $address->so_dien_thoai), 0, 2) : '+84' }}) {{ preg_replace('/^0/', '', $address->so_dien_thoai) }}</span>
                            @if($address->is_default)
                                <span class="default-badge">Mặc định</span>
                            @endif
                        </div>
                        <div class="address-detail">
                            {{ $address->dia_chi_chi_tiet }},<br>
                            {{ $address->phuong_xa }}, {{ $address->tinh_thanh }}
                        </div>
                    </div>
                </div>

                <div>
                    @if(!$address->is_default)
                        <form method="POST" action="{{ route('account.addresses.default', $address->id) }}">
                            @csrf
                            <button type="submit" class="address-action bg-transparent border-0 p-0">Cập nhật</button>
                        </form>
                    @else
                        <span class="address-action text-blue-600 cursor-default">Mặc định</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-8 text-center text-gray-500">Bạn chưa có địa chỉ nào.</div>
        @endforelse

        <button type="button" class="add-address-btn">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm Địa Chỉ Mới</span>
        </button>
    </div>
</body>
</html>
