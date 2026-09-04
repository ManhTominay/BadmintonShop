<script>
    document.addEventListener('submit', async function (event) {
        const form = event.target.closest('form[action*="/gio-hang/them/"]');
        if (!form) return;

        event.preventDefault();
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton ? submitButton.innerHTML : '';

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = 'Đang thêm...';
        }

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (response.redirected) {
                window.location.href = response.url;
                return;
            }

            const data = await response.json();
            if (response.status === 401) {
                window.location.href = @json(route('login'));
                return;
            }

            if (!response.ok) {
                throw new Error(data.message || 'Không thể thêm sản phẩm vào giỏ hàng.');
            }

            document.querySelectorAll('[data-cart-count]').forEach(function (badge) {
                badge.textContent = data.cartCount;
            });

            if (submitButton) {
                submitButton.innerHTML = 'Đã thêm vào giỏ';
                setTimeout(function () {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }, 1200);
            }
        } catch (error) {
            alert(error.message);
            if (submitButton) {
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }
        }
    });
</script>
