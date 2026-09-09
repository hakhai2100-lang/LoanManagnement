<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mini Loan Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .login-card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
        }
        .login-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
            border-bottom: none;
            padding: 2rem 1.5rem !important;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.50rem;
            border: 1px solid #cbd5e1;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border: none;
            padding: 0.75rem;
            border-radius: 0.50rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        .form-check-input:checked {
            background-color: #2563eb;
            border-color: #2563eb;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">

    <div class="card login-card" style="width: 100%; max-width: 420px;">
        <div class="card-header login-header text-white text-center">
            <div class="mb-2">
              
                <i class="bi bi-wallet2 fs-1 text-primary bg-white bg-opacity-10 p-3 rounded-circle d-inline-flex"></i>
            </div>
            <h4 class="mb-1 fw-bold tracking-wide">Mini Loan Management</h4>
            <p class="text-white-50 small mb-0">Sign in to manage your dashboard</p>
        </div>
        
        <div class="card-body p-4 p-md-5 bg-white">
            <form action="{{ route('authenticate') }}" method="POST" novalidate autocomplete="off">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold text-secondary small text-uppercase">Email Address</label>
                    <div class="input-group">
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control"
                               value="{{ old('email') }}"
                               placeholder="name@example.com"
                               required>
                    </div>
                    @error('email')
                        <span class="text-danger small mt-1 d-block"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold text-secondary small text-uppercase">Password</label>
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control"
                           placeholder="••••••••"
                           required>
                    @error('password')
                        <span class="text-danger small mt-1 d-block"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input type="checkbox"
                               name="remember"
                               id="remember"
                               class="form-check-input">
                        <label class="form-check-label text-muted small" for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3 shadow-sm">
                    Login to Dashboard <i class="bi bi-arrow-right ms-1"></i>
                </button>

                <div class="text-center pt-2 border-top">
                    <span class="text-muted small">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-primary ms-1 small">
                        Register here
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>