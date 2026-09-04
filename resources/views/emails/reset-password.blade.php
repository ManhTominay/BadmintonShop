<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f4f6; font-family:Arial, sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4f6; padding:40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #e5e7eb;">
                    <tr>
                        <td style="background:#f97316; padding:20px 30px; text-align:center; color:#ffffff; font-size:24px; font-weight:bold;">
                            BADMINTON PRO SHOP
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;">
                            <h2 style="margin:0 0 16px; font-size:28px; color:#111827;">Đặt lại mật khẩu</h2>
                            <p style="margin:0 0 20px; font-size:16px; line-height:1.6;">
                                Xin chào,<br>
                                Bạn vừa yêu cầu đặt lại mật khẩu cho tài khoản <strong>{{ $email }}</strong>.
                            </p>
                            <p style="margin:0 0 24px; font-size:16px; line-height:1.6;">
                                Nhấn vào nút bên dưới để tiếp tục:
                            </p>
                            <p style="margin:0 0 24px; text-align:center;">
                                <a href="{{ $resetUrl }}" style="display:inline-block; background:#f97316; color:#ffffff; text-decoration:none; padding:14px 28px; border-radius:8px; font-weight:bold;">
                                    Đặt lại mật khẩu
                                </a>
                            </p>
                            <p style="margin:0 0 8px; font-size:14px; color:#6b7280; line-height:1.6;">
                                Nếu nút không hoạt động, hãy sao chép liên kết sau vào trình duyệt:
                            </p>
                            <p style="margin:0; word-break:break-all; font-size:13px; color:#374151;">
                                {{ $resetUrl }}
                            </p>
                            <p style="margin-top:24px; font-size:14px; color:#6b7280; line-height:1.6;">
                                Nếu bạn không yêu cầu đặt lại mật khẩu, hãy bỏ qua email này.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 30px 30px; text-align:center; font-size:12px; color:#9ca3af;">
                            © 2026 BADMINTON PRO SHOP
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
