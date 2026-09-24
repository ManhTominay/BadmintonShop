<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hỗ trợ khách hàng - BADMINTON PRO SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800 flex h-screen overflow-hidden">
    <aside class="w-64 bg-[#0f172a] text-white flex flex-col justify-between shrink-0">
        <div>
            <div class="p-5 border-b border-gray-800">
                <h1 class="text-lg font-bold tracking-wider">BADMINTON</h1>
                <p class="text-xs text-gray-400">Employee Panel</p>
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('employee.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white text-sm font-medium">
                    <i class="fa-solid fa-clipboard-list w-5"></i> Quản lý đơn hàng
                </a>
                <a href="{{ route('employee.support.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-orange-600 text-white text-sm font-medium shadow-lg">
                    <i class="fa-solid fa-headset w-5"></i> Hỗ trợ khách hàng
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-gray-800 space-y-3">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-xs text-gray-400 hover:text-white">
                <i class="fa-solid fa-globe"></i> Về giao diện user
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 bg-red-900/40 text-red-400 rounded hover:bg-red-900/60 text-xs font-medium">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
            <div class="text-sm font-semibold text-gray-700">Hỗ trợ khách hàng</div>
            <div class="flex items-center gap-3 text-sm">
                <span class="text-gray-500">Nhân viên: <strong class="text-gray-900">{{ Auth::user()->ho_ten }}</strong></span>
                <div class="w-9 h-9 bg-orange-600 text-white rounded-full flex items-center justify-center font-bold text-sm">NV</div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-gray-50">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Hỗ trợ khách hàng</h1>
                <p class="text-sm text-gray-500 mt-1">Tin nhắn từ người dùng được tập trung tại đây.</p>
            </div>

            @if(session('success'))
                <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif

            <div class="space-y-3">
                @forelse($conversations as $userId => $messages)
                    @php
                        $customer = $messages->first()->user;
                        $latestMessage = $messages->last();
                        $chatData = $messages->map(fn ($message) => [
                            'message' => $message->message,
                            'sender_role' => $message->sender_role,
                            'created_at' => $message->created_at?->format('d/m/Y H:i'),
                        ])->values();
                    @endphp
                    <button type="button" class="support-notification w-full bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-left hover:border-orange-400 hover:shadow transition flex items-center gap-4" data-user-id="{{ $userId }}" data-customer-name="{{ $customer->ho_ten ?? 'Khách hàng' }}" data-customer-email="{{ $customer->email ?? '' }}" data-messages='@json($chatData)'>
                        <span class="w-10 h-10 shrink-0 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center"><i class="fa-solid fa-user"></i></span>
                        <span class="min-w-0 flex-1">
                            <span class="flex items-center justify-between gap-3">
                                <strong class="truncate text-gray-900 flex items-center gap-2">
                                    {{ $customer->ho_ten ?? 'Khách hàng' }}
                                    @if(in_array($userId, $unreadUserIds, true))
                                        <span class="w-2.5 h-2.5 rounded-full bg-red-500" title="Tin nhắn chưa đọc" aria-label="Tin nhắn chưa đọc"></span>
                                    @endif
                                </strong>
                                <span class="shrink-0 text-xs text-gray-400">{{ $messages->count() }} tin nhắn</span>
                            </span>
                            <span class="block truncate text-sm text-gray-500 mt-1">{{ $latestMessage->message }}</span>
                        </span>
                        <i class="fa-solid fa-chevron-right text-gray-400"></i>
                    </button>
                @empty
                    <div class="rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center text-sm text-gray-500">Chưa có tin nhắn hỗ trợ từ khách hàng.</div>
                @endforelse
            </div>
        </main>
    </div>

    <div id="supportChatModal" class="hidden fixed inset-0 z-40 bg-slate-900/30">
        <section class="absolute right-6 bottom-6 w-[min(420px,calc(100vw-2rem))] bg-white rounded-xl border border-gray-200 shadow-2xl overflow-hidden">
            <div class="bg-[#0f172a] text-white px-4 py-3 flex items-center justify-between">
                <div><h2 id="chatCustomerName" class="font-semibold text-sm">Khách hàng</h2><p id="chatCustomerEmail" class="text-xs text-gray-300"></p></div>
                <button id="closeSupportChat" type="button" aria-label="Đóng hộp chat" class="text-gray-300 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div id="supportChatMessages" class="h-80 overflow-y-auto bg-gray-50 p-3 space-y-3"></div>
            <form id="supportChatForm" method="POST" class="p-3 border-t border-gray-200 flex gap-2">
                @csrf
                <input type="text" name="message" maxlength="1000" required placeholder="Nhập phản hồi cho khách hàng..." class="min-w-0 flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500">
                <button type="submit" class="shrink-0 rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700"><i class="fa-solid fa-paper-plane mr-1"></i>Gửi</button>
            </form>
        </section>
    </div>

    <script>
        (() => {
            const modal = document.getElementById('supportChatModal');
            const messages = document.getElementById('supportChatMessages');
            const form = document.getElementById('supportChatForm');
            const renderMessages = (items) => {
                messages.innerHTML = '';
                items.forEach((item) => {
                    const wrapper = document.createElement('div');
                    const employeeMessage = item.sender_role === 'nhan_vien';
                    wrapper.className = employeeMessage ? 'flex justify-end' : 'flex justify-start';
                    const bubble = document.createElement('div');
                    bubble.className = `max-w-[80%] rounded-lg px-3 py-2 text-sm ${employeeMessage ? 'bg-orange-600 text-white rounded-tr-none' : 'bg-white border border-gray-200 text-gray-700 rounded-tl-none'}`;
                    bubble.textContent = item.message;
                    const time = document.createElement('div');
                    time.className = 'mt-1 text-[10px] opacity-60';
                    time.textContent = item.created_at || '';
                    bubble.appendChild(time);
                    wrapper.appendChild(bubble);
                    messages.appendChild(wrapper);
                });
                messages.scrollTop = messages.scrollHeight;
            };
            document.querySelectorAll('.support-notification').forEach((notification) => {
                notification.addEventListener('click', () => {
                    document.getElementById('chatCustomerName').textContent = notification.dataset.customerName;
                    document.getElementById('chatCustomerEmail').textContent = notification.dataset.customerEmail;
                    form.action = `{{ url('/nhan-vien/ho-tro') }}/${notification.dataset.userId}`;
                    renderMessages(JSON.parse(notification.dataset.messages));
                    modal.classList.remove('hidden');
                    form.querySelector('input[name="message"]').focus();
                });
            });
            document.getElementById('closeSupportChat').addEventListener('click', () => modal.classList.add('hidden'));
            modal.addEventListener('click', (event) => { if (event.target === modal) modal.classList.add('hidden'); });
        })();
    </script>
</body>
</html>
