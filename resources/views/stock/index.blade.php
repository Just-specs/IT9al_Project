<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock In</title>
    <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Stock In</h1>
        <div class="card shadow mt-4">
            <div class="card-body">
                @include('stock.partials.form')
            </div>
        </div>
        <div class="card shadow mt-4">
            <div class="card-body">
                @include('stock.partials.table')
            </div>
        </div>
    </div>
    <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>