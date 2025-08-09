<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Not found</title>
</head>
<body>
    <!-- not found uchun sahifa -->
    <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:80vh;">
        <img src="https://cdn-icons-png.flaticon.com/512/2748/2748558.png" alt="404" style="width:120px;margin-bottom:24px;">
        <h1 style="font-size:2.5rem;color:#e74c3c;margin-bottom:12px;">404 - Sahifa topilmadi</h1>
        <p style="font-size:1.2rem;color:#555;margin-bottom:24px;">Uzr, siz so‘ragan sahifa mavjud emas yoki o‘chirilgan.</p>
        <div>
            <a href="{{ route('welcome') }}" style="padding:10px 24px;background:#3498db;color:#fff;text-decoration:none;border-radius:6px;margin-right:10px;">Bosh sahifa</a>
            <a href="{{ route('login') }}" style="padding:10px 24px;background:#2ecc71;color:#fff;text-decoration:none;border-radius:6px;">Kirish</a>
        </div>
    </div>
</body>
</html>