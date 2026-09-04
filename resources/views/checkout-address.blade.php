<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập địa chỉ giao hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.9rem center;
            background-size: 12px;
            padding-right: 2.25rem;
        }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen px-4 py-8">
    <div class="bg-white p-8 rounded-2xl shadow-sm max-w-xl w-full border border-gray-100">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-xl font-bold text-slate-900 uppercase">
                {{ $isEdit ? 'Thay đổi địa chỉ' : 'Thông tin giao hàng' }}
            </h2>
            <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-orange-500 hover:text-orange-600">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại
            </a>
        </div>
        <p class="text-xs text-gray-500 mb-6">
            {{ $isEdit ? 'Cập nhật địa chỉ nhận hàng của bạn.' : 'Vui lòng điền địa chỉ nhận hàng cho lần mua đầu tiên của bạn.' }}
        </p>

        <form action="{{ $isEdit ? route('checkout.address.update', ['items' => $selectedItems ?? request()->query('items')]) : route('checkout.address.store', ['items' => $selectedItems ?? request()->query('items')]) }}" method="POST" class="space-y-4 text-xs">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif
            <input type="hidden" name="items" value="{{ $selectedItems ?? request()->query('items') }}">
            @if($isEdit)
                <input type="hidden" name="address_id" value="{{ $address->id }}">
            @endif
            <div>
                <label class="block font-bold text-gray-700 mb-1">Họ tên người nhận</label>
                <input type="text" name="ten_nguoi_nhan" value="{{ old('ten_nguoi_nhan', $address->ten_nguoi_nhan ?? '') }}" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:border-orange-500">
            </div>
            <div>
                <label class="block font-bold text-gray-700 mb-1">Số điện thoại</label>
                <input type="text" name="so_dien_thoai" value="{{ old('so_dien_thoai', $address->so_dien_thoai ?? '') }}" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:border-orange-500">
            </div>

            <div>
                <label class="block font-bold text-gray-700 mb-1">Vị trí giao hàng trên bản đồ</label>
                <div id="map" class="mt-2 w-full rounded-xl border border-gray-300" style="height: 260px;"></div>
                <p id="map-status" class="mt-2 text-[11px] text-gray-500">Chọn địa chỉ để bản đồ tự định vị, hoặc nhấp trực tiếp trên bản đồ để tinh chỉnh.</p>
                <input type="hidden" name="lat" id="lat" value="{{ old('lat', $address->lat ?? '') }}">
                <input type="hidden" name="lng" id="lng" value="{{ old('lng', $address->lng ?? '') }}">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Tỉnh / Thành phố</label>
                    <select id="tinhThanh" name="tinh_thanh" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:border-orange-500 text-gray-700 bg-white">
                        <option value="">-- Chọn tỉnh/thành --</option>
                        <option value="An Giang" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'An Giang' ? 'selected' : '' }}>An Giang</option>
                        <option value="Bà Rịa - Vũng Tàu" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Bà Rịa - Vũng Tàu' ? 'selected' : '' }}>Bà Rịa - Vũng Tàu</option>
                        <option value="Bắc Giang" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Bắc Giang' ? 'selected' : '' }}>Bắc Giang</option>
                        <option value="Bắc Kạn" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Bắc Kạn' ? 'selected' : '' }}>Bắc Kạn</option>
                        <option value="Bạc Liêu" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Bạc Liêu' ? 'selected' : '' }}>Bạc Liêu</option>
                        <option value="Bắc Ninh" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Bắc Ninh' ? 'selected' : '' }}>Bắc Ninh</option>
                        <option value="Bến Tre" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Bến Tre' ? 'selected' : '' }}>Bến Tre</option>
                        <option value="Bình Định" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Bình Định' ? 'selected' : '' }}>Bình Định</option>
                        <option value="Bình Dương" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Bình Dương' ? 'selected' : '' }}>Bình Dương</option>
                        <option value="Bình Phước" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Bình Phước' ? 'selected' : '' }}>Bình Phước</option>
                        <option value="Bình Thuận" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Bình Thuận' ? 'selected' : '' }}>Bình Thuận</option>
                        <option value="Cà Mau" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Cà Mau' ? 'selected' : '' }}>Cà Mau</option>
                        <option value="Cần Thơ" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Cần Thơ' ? 'selected' : '' }}>Cần Thơ</option>
                        <option value="Cao Bằng" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Cao Bằng' ? 'selected' : '' }}>Cao Bằng</option>
                        <option value="Đà Nẵng" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                        <option value="Đắk Lắk" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Đắk Lắk' ? 'selected' : '' }}>Đắk Lắk</option>
                        <option value="Đắk Nông" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Đắk Nông' ? 'selected' : '' }}>Đắk Nông</option>
                        <option value="Điện Biên" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Điện Biên' ? 'selected' : '' }}>Điện Biên</option>
                        <option value="Đồng Nai" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Đồng Nai' ? 'selected' : '' }}>Đồng Nai</option>
                        <option value="Đồng Tháp" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Đồng Tháp' ? 'selected' : '' }}>Đồng Tháp</option>
                        <option value="Gia Lai" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Gia Lai' ? 'selected' : '' }}>Gia Lai</option>
                        <option value="Hà Giang" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Hà Giang' ? 'selected' : '' }}>Hà Giang</option>
                        <option value="Hà Nam" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Hà Nam' ? 'selected' : '' }}>Hà Nam</option>
                        <option value="Hà Nội" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                        <option value="Hà Tĩnh" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Hà Tĩnh' ? 'selected' : '' }}>Hà Tĩnh</option>
                        <option value="Hải Dương" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Hải Dương' ? 'selected' : '' }}>Hải Dương</option>
                        <option value="Hải Phòng" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Hải Phòng' ? 'selected' : '' }}>Hải Phòng</option>
                        <option value="Hậu Giang" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Hậu Giang' ? 'selected' : '' }}>Hậu Giang</option>
                        <option value="Hòa Bình" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Hòa Bình' ? 'selected' : '' }}>Hòa Bình</option>
                        <option value="Hưng Yên" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Hưng Yên' ? 'selected' : '' }}>Hưng Yên</option>
                        <option value="Khánh Hòa" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Khánh Hòa' ? 'selected' : '' }}>Khánh Hòa</option>
                        <option value="Kiên Giang" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Kiên Giang' ? 'selected' : '' }}>Kiên Giang</option>
                        <option value="Kon Tum" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Kon Tum' ? 'selected' : '' }}>Kon Tum</option>
                        <option value="Lai Châu" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Lai Châu' ? 'selected' : '' }}>Lai Châu</option>
                        <option value="Lâm Đồng" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Lâm Đồng' ? 'selected' : '' }}>Lâm Đồng</option>
                        <option value="Lạng Sơn" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Lạng Sơn' ? 'selected' : '' }}>Lạng Sơn</option>
                        <option value="Lào Cai" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Lào Cai' ? 'selected' : '' }}>Lào Cai</option>
                        <option value="Long An" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Long An' ? 'selected' : '' }}>Long An</option>
                        <option value="Nam Định" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Nam Định' ? 'selected' : '' }}>Nam Định</option>
                        <option value="Nghệ An" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Nghệ An' ? 'selected' : '' }}>Nghệ An</option>
                        <option value="Ninh Bình" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Ninh Bình' ? 'selected' : '' }}>Ninh Bình</option>
                        <option value="Ninh Thuận" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Ninh Thuận' ? 'selected' : '' }}>Ninh Thuận</option>
                        <option value="Phú Thọ" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Phú Thọ' ? 'selected' : '' }}>Phú Thọ</option>
                        <option value="Phú Yên" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Phú Yên' ? 'selected' : '' }}>Phú Yên</option>
                        <option value="Quảng Bình" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Quảng Bình' ? 'selected' : '' }}>Quảng Bình</option>
                        <option value="Quảng Nam" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Quảng Nam' ? 'selected' : '' }}>Quảng Nam</option>
                        <option value="Quảng Ngãi" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Quảng Ngãi' ? 'selected' : '' }}>Quảng Ngãi</option>
                        <option value="Quảng Ninh" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Quảng Ninh' ? 'selected' : '' }}>Quảng Ninh</option>
                        <option value="Quảng Trị" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Quảng Trị' ? 'selected' : '' }}>Quảng Trị</option>
                        <option value="Sóc Trăng" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Sóc Trăng' ? 'selected' : '' }}>Sóc Trăng</option>
                        <option value="Sơn La" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Sơn La' ? 'selected' : '' }}>Sơn La</option>
                        <option value="Tây Ninh" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Tây Ninh' ? 'selected' : '' }}>Tây Ninh</option>
                        <option value="Thái Bình" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Thái Bình' ? 'selected' : '' }}>Thái Bình</option>
                        <option value="Thái Nguyên" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Thái Nguyên' ? 'selected' : '' }}>Thái Nguyên</option>
                        <option value="Thanh Hóa" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Thanh Hóa' ? 'selected' : '' }}>Thanh Hóa</option>
                        <option value="Thừa Thiên Huế" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Thừa Thiên Huế' ? 'selected' : '' }}>Thừa Thiên Huế</option>
                        <option value="Tiền Giang" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Tiền Giang' ? 'selected' : '' }}>Tiền Giang</option>
                        <option value="TP. Hồ Chí Minh" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'TP. Hồ Chí Minh' ? 'selected' : '' }}>TP. Hồ Chí Minh</option>
                        <option value="Trà Vinh" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Trà Vinh' ? 'selected' : '' }}>Trà Vinh</option>
                        <option value="Tuyên Quang" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Tuyên Quang' ? 'selected' : '' }}>Tuyên Quang</option>
                        <option value="Vĩnh Long" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Vĩnh Long' ? 'selected' : '' }}>Vĩnh Long</option>
                        <option value="Vĩnh Phúc" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Vĩnh Phúc' ? 'selected' : '' }}>Vĩnh Phúc</option>
                        <option value="Yên Bái" {{ old('tinh_thanh', $address->tinh_thanh ?? '') == 'Yên Bái' ? 'selected' : '' }}>Yên Bái</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Phường / Xã</label>
                    <select id="phuongXa" name="phuong_xa" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:border-orange-500 text-gray-700 bg-white">
                        <option value="">-- Chọn phường/xã --</option>
                        @if(!empty($address->phuong_xa))
                            <option value="{{ $address->phuong_xa }}" selected>{{ $address->phuong_xa }}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div>
                <label class="block font-bold text-gray-700 mb-1">Địa chỉ chi tiết (Số nhà, tên đường...)</label>
                <input type="text" name="dia_chi_chi_tiet" value="{{ old('dia_chi_chi_tiet', $address->dia_chi_chi_tiet ?? '') }}" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:border-orange-500" placeholder="Ví dụ: 123 Lê Lợi, phường A">
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-700 font-medium">
                <input type="checkbox" name="is_default" value="1" {{ old('is_default', $address->is_default ?? false) ? 'checked' : '' }} class="h-4 w-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                Đặt làm địa chỉ mặc định
            </label>

            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl transition shadow-md uppercase">
                {{ $isEdit ? 'Lưu thay đổi' : 'Lưu và tiếp tục thanh toán' }}
            </button>
        </form>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const shopCoords = [21.0461067, 105.7620995];
        const latInput = document.getElementById('lat');
        const lngInput = document.getElementById('lng');
        const initialLat = Number(latInput.value || shopCoords[0]);
        const initialLng = Number(lngInput.value || shopCoords[1]);

        const map = L.map('map').setView([initialLat, initialLng], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker(shopCoords).addTo(map).bindPopup('Cửa hàng BADMINTON PRO');

        let userMarker = null;
        const mapStatus = document.getElementById('map-status');

        function setUserLocation(lat, lng, zoom = 16) {
            latInput.value = lat;
            lngInput.value = lng;
            map.setView([lat, lng], zoom);

            if (userMarker) {
                map.removeLayer(userMarker);
            }

            userMarker = L.marker([lat, lng]).addTo(map).bindPopup('Địa chỉ nhận hàng').openPopup();
        }

        async function geocodeLocation(query) {
            if (!query || query.trim().length < 3) return;

            if (mapStatus) mapStatus.textContent = 'Đang tìm vị trí trên bản đồ...';

            try {
                const response = await fetch('https://nominatim.openstreetmap.org/search?format=jsonv2&limit=1&countrycodes=vn&q=' + encodeURIComponent(query));
                const results = await response.json();

                if (results.length > 0) {
                    setUserLocation(Number(results[0].lat), Number(results[0].lon));
                    if (mapStatus) mapStatus.textContent = 'Đã tự chọn vị trí. Bạn có thể nhấp bản đồ để chỉnh chính xác hơn.';
                } else if (mapStatus) {
                    mapStatus.textContent = 'Không tìm thấy vị trí tự động. Hãy nhấp trực tiếp trên bản đồ.';
                }
            } catch (error) {
                if (mapStatus) mapStatus.textContent = 'Không thể tìm vị trí tự động. Hãy nhấp trực tiếp trên bản đồ.';
            }
        }

        if (latInput.value && lngInput.value) {
            userMarker = L.marker([Number(latInput.value), Number(lngInput.value)]).addTo(map).bindPopup('Địa chỉ nhận hàng');
        }

        map.on('click', function (event) {
            const { lat, lng } = event.latlng;
            setUserLocation(lat, lng);
            if (mapStatus) mapStatus.textContent = 'Đã chọn vị trí giao hàng trên bản đồ.';
        });

        const wardsByProvince = {
            'An Giang': ['Long Xuyên', 'Châu Đốc', 'Tân Châu', 'Tri Tôn', 'Phú Tân'],
            'Bà Rịa - Vũng Tàu': ['Long Điền', 'Xuyên Mộc', 'Bà Rịa', 'Vũng Tàu', 'Đất Đỏ'],
            'Bắc Giang': ['Bắc Giang', 'Lạng Giang', 'Yên Dũng', 'Hiệp Hòa', 'Tân Yên'],
            'Bắc Kạn': ['Bắc Kạn', 'Ngân Sơn', 'Pác Nặm', 'Chợ Mới', 'Ba Bể'],
            'Bạc Liêu': ['Bạc Liêu', 'Hồng Dân', 'Giá Rai', 'Hòa Bình', 'Phước Long'],
            'Bắc Ninh': ['Bắc Ninh', 'Từ Sơn', 'Yên Phong', 'Gia Bình', 'Tiên Du'],
            'Bến Tre': ['Bến Tre', 'Châu Thành', 'Mỏ Cày', 'Giồng Trôm', 'Thạnh Phú'],
            'Bình Định': ['Quy Nhơn', 'An Nhơn', 'Tuy Phước', 'Phù Cát', 'Hoài Nhơn'],
            'Bình Dương': ['Thủ Dầu Một', 'Dĩ An', 'Thuận An', 'Bến Cát', 'Tân Uyên'],
            'Bình Phước': ['Đồng Xoài', 'Bình Long', 'Phước Long', 'Chơn Thành', 'Lộc Ninh'],
            'Bình Thuận': ['Phan Thiết', 'La Gi', 'Tuy Phong', 'Hàm Thuận Bắc', 'Hàm Thuận Nam'],
            'Cà Mau': ['Cà Mau', 'Năm Căn', 'Thới Bình', 'U Minh', 'Trần Văn Thời'],
            'Cần Thơ': ['Ninh Kiều', 'Cái Răng', 'Bình Thủy', 'Ô Môn', 'Thốt Nốt'],
            'Cao Bằng': ['Cao Bằng', 'Bảo Lâm', 'Trùng Khánh', 'Hạ Lang', 'Nguyên Bình'],
            'Đà Nẵng': ['Hải Châu', 'Thanh Khê', 'Sơn Trà', 'Ngũ Hành Sơn', 'Liên Chiểu'],
            'Đắk Lắk': ['Buôn Ma Thuột', 'Ea Hleo', 'Krông Pắc', 'Krông Búk', 'Ea Súp'],
            'Đắk Nông': ['Gia Nghĩa', 'Cư Jút', 'Đắk Mil', 'Krông Nô', 'Đắk Song'],
            'Điện Biên': ['Điện Biên Phủ', 'Mường Lay', 'Tuần Giáo', 'Mường Ảng', 'Tủa Chùa'],
            'Đồng Nai': ['Biên Hòa', 'Long Khánh', 'Nhơn Trạch', 'Trảng Bom', 'Vĩnh Cửu'],
            'Đồng Tháp': ['Cao Lãnh', 'Sa Đéc', 'Lai Vung', 'Tam Nông', 'Tháp Mười'],
            'Gia Lai': ['Pleiku', 'An Khê', 'Ayun Pa', 'Đức Cơ', 'Mang Yang'],
            'Hà Giang': ['Hà Giang', 'Đồng Văn', 'Mèo Vạc', 'Yên Minh', 'Bắc Mê'],
            'Hà Nam': ['Phủ Lý', 'Duy Tiên', 'Kim Bảng', 'Lý Nhân', 'Thanh Liêm'],
            'Hà Nội': ['Ba Đình', 'Hoàn Kiếm', 'Hai Bà Trưng', 'Cầu Giấy', 'Đống Đa'],
            'Hà Tĩnh': ['Hà Tĩnh', 'Hồng Lĩnh', 'Kỳ Anh', 'Thạch Hà', 'Cẩm Xuyên'],
            'Hải Dương': ['Hải Dương', 'Chí Linh', 'Nam Sách', 'Kinh Môn', 'Gia Lộc'],
            'Hải Phòng': ['Hồng Bàng', 'Ngô Quyền', 'Lê Chân', 'Kiến An', 'Đồ Sơn'],
            'Hậu Giang': ['Vị Thanh', 'Long Mỹ', 'Châu Thành', 'Ngã Bảy', 'Phụng Hiệp'],
            'Hòa Bình': ['Hòa Bình', 'Yên Thủy', 'Lạc Sơn', 'Kim Bôi', 'Mai Châu'],
            'Hưng Yên': ['Hưng Yên', 'Mỹ Hào', 'Khoái Châu', 'Ân Thi', 'Yên Mỹ'],
            'Khánh Hòa': ['Nha Trang', 'Cam Ranh', 'Vạn Ninh', 'Ninh Hòa', 'Diên Khánh'],
            'Kiên Giang': ['Rạch Giá', 'Hà Tiên', 'An Biên', 'Giồng Riềng', 'Châu Thành'],
            'Kon Tum': ['Kon Tum', 'Đắk Glei', 'Sa Thầy', 'Ngọc Hồi', 'Tu Mơ Rông'],
            'Lai Châu': ['Lai Châu', 'Sìn Hồ', 'Mường Tè', 'Tam Đường', 'Phong Thổ'],
            'Lâm Đồng': ['Đà Lạt', 'Bảo Lộc', 'Lạc Dương', 'Đơn Dương', 'Di Linh'],
            'Lạng Sơn': ['Lạng Sơn', 'Cao Lộc', 'Mạo Khê', 'Văn Lãng', 'Tràng Định'],
            'Lào Cai': ['Lào Cai', 'Bát Xát', 'Sa Pa', 'Bắc Hà', 'Mường Khương'],
            'Long An': ['Tân An', 'Kiến Tường', 'Bến Lức', 'Cần Giuộc', 'Tân Hưng'],
            'Nam Định': ['Nam Định', 'Trực Ninh', 'Xuân Trường', 'Giao Thủy', 'Nghĩa Hưng'],
            'Nghệ An': ['Vinh', 'Cửa Lò', 'Thái Hòa', 'Quỳ Châu', 'Con Cuông'],
            'Ninh Bình': ['Ninh Bình', 'Tam Điệp', 'Hoa Lư', 'Yên Mô', 'Gia Viễn'],
            'Ninh Thuận': ['Phan Rang - Tháp Chàm', 'Bác Ái', 'Ninh Hải', 'Ninh Sơn', 'Thuận Bắc'],
            'Phú Thọ': ['Việt Trì', 'Phú Thọ', 'Hạ Hoà', 'Thanh Ba', 'Tam Nông'],
            'Phú Yên': ['Tuy Hòa', 'Sông Cầu', 'Đồng Xuân', 'Tuy An', 'Sơn Hòa'],
            'Quảng Bình': ['Đồng Hới', 'Ba Đồn', 'Bố Trạch', 'Quảng Ninh', 'Lệ Thủy'],
            'Quảng Nam': ['Tam Kỳ', 'Hội An', 'Điện Bàn', 'Duy Xuyên', 'Nam Giang'],
            'Quảng Ngãi': ['Quảng Ngãi', 'Sơn Tịnh', 'Lý Sơn', 'Tư Nghĩa', 'Ba Tơ'],
            'Quảng Ninh': ['Hạ Long', 'Cẩm Phả', 'Móng Cái', 'Uông Bí', 'Vân Đồn'],
            'Quảng Trị': ['Đông Hà', 'Quảng Trị', 'Gio Linh', 'Hải Lăng', 'Vĩnh Linh'],
            'Sóc Trăng': ['Sóc Trăng', 'Vĩnh Châu', 'Long Phú', 'Mỹ Tú', 'Ngã Năm'],
            'Sơn La': ['Sơn La', 'Mộc Châu', 'Yên Châu', 'Quỳnh Nhai', 'Mai Sơn'],
            'Tây Ninh': ['Tây Ninh', 'Trảng Bàng', 'Gò Dầu', 'Hòa Thành', 'Bến Cầu'],
            'Thái Bình': ['Thái Bình', 'Hưng Hà', 'Tiền Hải', 'Đông Hưng', 'Vũ Thư'],
            'Thái Nguyên': ['Thái Nguyên', 'Sông Công', 'Phổ Yên', 'Đại Từ', 'Phú Lương'],
            'Thanh Hóa': ['Thanh Hóa', 'Bỉm Sơn', 'Sầm Sơn', 'Nghi Sơn', 'Hậu Lộc'],
            'Thừa Thiên Huế': ['Huế', 'Hương Thủy', 'Hương Trà', 'Phong Điền', 'A Lưới'],
            'Tiền Giang': ['Mỹ Tho', 'Gò Công', 'Cai Lậy', 'Châu Thành', 'Tân Phước'],
            'TP. Hồ Chí Minh': ['Quận 1', 'Quận 3', 'Quận 7', 'Thủ Đức', 'Bình Thạnh'],
            'Trà Vinh': ['Trà Vinh', 'Duyên Hải', 'Càng Long', 'Tiểu Cần', 'Châu Thành'],
            'Tuyên Quang': ['Tuyên Quang', 'Chiêm Hóa', 'Na Hang', 'Lâm Bình', 'Yên Sơn'],
            'Vĩnh Long': ['Vĩnh Long', 'Bình Minh', 'Long Hồ', 'Mang Thít', 'Tam Bình'],
            'Vĩnh Phúc': ['Vĩnh Yên', 'Phúc Yên', 'Bình Xuyên', 'Lập Thạch', 'Sông Lô'],
            'Yên Bái': ['Yên Bái', 'Lục Yên', 'Trạm Tấu', 'Văn Chấn', 'Mù Cang Chải']
        };

        const tinhThanh = document.getElementById('tinhThanh');
        const phuongXa = document.getElementById('phuongXa');
        const addressForm = document.querySelector('form');
        const detailAddressInput = document.querySelector('input[name="dia_chi_chi_tiet"]');

        function clearSavedCoordinates() {
            latInput.value = '';
            lngInput.value = '';
        }

        tinhThanh.addEventListener('change', clearSavedCoordinates);
        phuongXa.addEventListener('change', clearSavedCoordinates);
        detailAddressInput.addEventListener('input', clearSavedCoordinates);

        addressForm.addEventListener('submit', function (event) {
            if (!latInput.value || !lngInput.value) {
                event.preventDefault();
                alert('Vui lòng nhấp vào bản đồ để chọn vị trí giao hàng.');
            }
        });

        tinhThanh.addEventListener('change', function () {
            const value = this.value;
            const options = wardsByProvince[value] || ['Không có xã/phường'];

            phuongXa.innerHTML = '<option value="">-- Chọn phường/xã --</option>' +
                options.map(item => `<option value="${item}">${item}</option>`).join('');

            geocodeLocation(`${value}, Việt Nam`);
        });

        phuongXa.addEventListener('change', function () {
            geocodeLocation(`${this.value}, ${tinhThanh.value}, Việt Nam`);
        });

        detailAddressInput.addEventListener('blur', function () {
            const query = `${this.value}, ${phuongXa.value}, ${tinhThanh.value}, Việt Nam`;
            geocodeLocation(query);
        });
    </script>
</body>
</html>