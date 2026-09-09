@extends('layouts.app')

@section('main')
<style>
    /* Hide sidebar, top header, navbar, and footer, and expand content wrapper */
    aside, .sidebar, .main-sidebar, nav.sidebar, header, .main-header, .navbar, footer, .main-footer {
        display: none !important;
    }
    .content-wrapper {
        margin-left: 0 !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        width: 100% !important;
        padding-left: 0 !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
    body {
        background-color: #f8fafc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .register-card {
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        border-radius: 16px;
        overflow: hidden;
        background: #ffffff;
    }
    .register-header {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
        border: none;
    }
    .form-control {
        padding: 12px 14px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 0.95rem;
        transition: all 0.2s ease-in-out;
    }
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    .form-label {
        font-weight: 600;
        color: #334155;
        font-size: 0.875rem;
        margin-bottom: 6px;
    }
    .btn-primary-custom {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border: none;
        padding: 12px;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.3px;
        transition: all 0.2s ease-in-out;
    }
    .btn-primary-custom:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
</style>

<div class="content-wrapper d-flex align-items-center justify-content-center py-5 w-100 min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card register-card">
                    <div class="register-header text-white text-center py-4 px-3">
                        <h4 class="mb-1 fw-bold">Mini Loan Management</h4>
                        <span class="text-white-55 small">Create a new student account</span>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('create') }}" method="POST" novalidate autocomplete="off">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}"
                                       placeholder="Enter your name"
                                       required autofocus>
                                @error('name')
                                    <div class="invalid-feedback small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}"
                                       placeholder="name@example.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="*********"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       placeholder="*********"
                                       required>
                                @error('password_confirmation')
                                    <div class="invalid-feedback small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-primary-custom w-100 mb-3 text-white shadow-sm">
                                Register Account
                            </button>

                            <div class="text-center text-muted small">
                                <span>Already have an account?</span>
                                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-primary ms-1">
                                    Login here
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection