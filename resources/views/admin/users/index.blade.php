<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Danh sách người dùng</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Tên người dùng</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Hoạt động cuối</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="border p-2 text-center">{{ $user->id }}</td>
                        
                        {{-- Hiển thị tên dựa trên các khả năng tên cột có thể có trong CSDL --}}
                        <td class="border p-2">
                            {{ $user->ho_ten ?? $user->ten ?? $user->name ?? $user->username ?? $user->fullname ?? 'N/A' }}
                        </td>

                        <td class="border p-2">{{ $user->email ?? 'N/A' }}</td>
                        
                        {{-- Hiển thị thời gian hoạt động cuối linh hoạt và format chuẩn --}}
                        <td class="border p-2 text-center">
                            @php
                                $lastActive = $user->last_activity ?? $user->hoat_dong_cuoi ?? $user->thoi_gian_hoat_dong ?? $user->updated_at ?? null;
                            @endphp

                            @if($lastActive)
                                {{ \Carbon\Carbon::parse($lastActive)->format('d/m/Y H:i:s') }}
                            @else
                                <span class="text-gray-400">Chưa có</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border p-4 text-center text-gray-500">Chưa có người dùng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</body>
</html>