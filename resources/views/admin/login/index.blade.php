<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Login | Tech Blog</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="/admin/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="/admin/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Admin Theme -->
    <link href="/admin/dist/css/sb-admin-2.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: "Segoe UI", system-ui, sans-serif;

            /* TECH IMAGE BACKGROUND */
            background:
                linear-gradient(
                    rgba(2, 6, 23, 0.75),
                    rgba(2, 6, 23, 0.85)
                ),
                url("https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            margin: 90px auto 0; /* PUSH UP */
        }

        .login-panel {
            background: rgba(255,255,255,0.96);
            border-radius: 18px;
            padding: 36px 40px;
            box-shadow: 0 40px 80px rgba(2,6,23,.6);
            border: none;
        }

        .login-title {
            text-align: center;
            margin-bottom: 28px;
        }

        .login-title h3 {
            font-weight: 700;
            margin-bottom: 6px;
            color: #0f172a;
        }

        .login-title p {
            color: #64748b;
            font-size: 14px;
        }

        .form-control {
            height: 46px;
            border-radius: 12px;
            font-size: 14px;
            border: 1px solid #c7d2fe;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37,99,235,.2);
        }

        .btn-login {
            height: 46px;
            border-radius: 999px;
            font-weight: 600;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            border: none;
            color: #fff;
            transition: all .3s ease;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e3a8a);
            transform: translateY(-1px);
        }

        .alert {
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .login-footer {
            text-align: center;
            margin-top: 22px;
            font-size: 12px;
            color: #94a3b8;
        }

        /* subtle tech glow */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background:
                radial-gradient(circle at 30% 20%, rgba(37,99,235,.25), transparent 45%),
                radial-gradient(circle at 70% 80%, rgba(14,165,233,.2), transparent 45%);
            pointer-events: none;
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <div class="login-panel">

        <!-- TITLE -->
        <div class="login-title">
            <h3>
                <i class="fa fa-lock"></i> Admin Panel
            </h3>
            <p>Tech Blog Administration</p>
        </div>

        <!-- ERROR -->
        @if (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('admin.auth.check-login') }}" method="POST">
            @csrf

            <div class="form-group">
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Email address"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-login btn-block">
                <i class="fa fa-sign-in"></i> Login
            </button>
        </form>

        <div class="login-footer">
            © {{ date('Y') }} Tech Blog Admin
        </div>

    </div>

</div>

<!-- JS -->
<script src="/admin/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>
