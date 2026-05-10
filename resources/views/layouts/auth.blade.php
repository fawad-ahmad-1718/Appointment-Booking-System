<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AppointBook') – AppointBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
:root {
    --primary: #4f46e5;
    --primary-dark: #3730a3;
    --primary-light: #818cf8;
    --secondary: #0ea5e9;
    --danger: #ef4444;
    --body-bg: #f1f5f9;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Inter', sans-serif; }
.auth-body {
    background: linear-gradient(135deg, #1a1f36 0%, #2d3561 50%, #1a1f36 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.auth-wrapper { width: 100%; max-width: 440px; padding: 20px; }
.auth-card {
    background: rgba(255,255,255,0.97);
    border-radius: 24px;
    padding: 40px 36px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.3);
}
.auth-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--primary);
}
.auth-logo i { font-size: 2rem; }
.auth-title { font-size: 1.4rem; font-weight: 800; color: #0f172a; text-align: center; }
.auth-subtitle { color: #64748b; font-size: 0.85rem; text-align: center; }
.form-label { font-weight: 600; font-size: 0.85rem; color: #374151; margin-bottom: 6px; }
.form-control, .form-select {
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 0.9rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-control:focus, .form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
}
.form-control.is-invalid { border-color: var(--danger); }
.btn-gradient {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 10px;
    padding: 10px 20px;
}
.btn-gradient:hover { opacity: 0.9; color: #fff; }
    </style>
</head>
<body class="auth-body">
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo mb-4">
                <i class="bi bi-calendar-check-fill"></i>
                <span>AppointBook</span>
            </div>
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>
</html>
 