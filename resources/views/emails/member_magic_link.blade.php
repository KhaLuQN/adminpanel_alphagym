<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Magic Link Đăng Nhập</title>
</head>

<body>
    <h2>Xin chào {{ $member->full_name }},</h2>
    <p>Bạn vừa yêu cầu đăng nhập vào hệ thống GymTech.</p>
    <p>Vui lòng nhấn vào nút bên dưới để đăng nhập:</p>

    <p style="margin: 20px 0;">
        <a href="{{ $magicLink }}"
            style="display:inline-block;padding:10px 20px;background-color:#dc2626;color:#fff;text-decoration:none;border-radius:5px;">
            Đăng nhập ngay
        </a>
    </p>

    <p>Liên kết này sẽ hết hạn sau {{ $expireMinutes }} phút.</p>

    <p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.</p>

    <p>Trân trọng,<br>GymTech Team</p>
</body>

</html>
