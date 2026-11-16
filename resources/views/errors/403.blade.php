<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 1rem;
        }
        .container {
            max-width: 28rem;
            width: 100%;
            background: #ffffff;
            border-radius: 0.75rem;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .icon {
            font-size: 3.5rem;
            margin-bottom: 0.75rem;
        }
        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #dc2626;
            margin: 0 0 0.5rem;
        }
        p {
            color: #4b5563;
            font-size: 0.95rem;
            line-height: 1.5;
            margin: 0 0 1.5rem;
        }
        .btn {
            display: inline-block;
            background-color: #1f2937;
            color: #ffffff;
            padding: 0.625rem 1.25rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background-color 0.15s ease-in-out;
        }
        .btn:hover {
            background-color: #374151;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">🚫</div>
        <h1>403 - Akses Ditolak</h1>
        <p>Anda tidak memiliki izin (hak akses) untuk mengakses halaman atau fitur ini sesuai ketentuan Role & Permission sistem perpustakaan.</p>
        <a href="{{ url('/dashboard') }}" class="btn">Kembali ke Dashboard</a>
    </div>
</body>
</html>

