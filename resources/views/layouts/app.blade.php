<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'BBU Mini Loan') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,300..700;1,300..700&family=Battambang:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0/dist/css/adminlte.min.css" />

    <style>
        body, button, input, select, textarea, h1, h2, h3, h4, h5, h6, .brand-text {
            font-family: 'Kantumruy Pro', 'Battambang', sans-serif !important;
        }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        
        @include('layouts.includes.menubar')

        @include('layouts.includes.sidebar')

        <main class="app-main">
            <div class="app-content-header py-2">
                <div class="container-fluid"></div>
            </div>
            
            <div class="app-content">
                <div class="container-fluid">
                    @yield('main')
                </div>
            </div>
        </main>


        @include('layouts.includes.footer')

    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0/dist/js/adminlte.min.js"></script>
</body>
</html>