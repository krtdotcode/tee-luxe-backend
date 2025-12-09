<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TeeLuxe Admin') - Admin Panel</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif !important;
        }

        body {
            background-color: #f8f9fa;
        }

        .admin-header {
            background: white;
            border-bottom: 1px solid #f0f0f0;
            padding: 1rem 0;
        }

        .admin-sidebar {
            background: white;
            min-height: calc(100vh - 76px);
            border-right: 1px solid #f0f0f0;
        }

        .admin-content {
            padding: 2rem;
        }

        .btn-admin {
            border-radius: 0 !important;
            font-family: 'Inter', sans-serif !important;
            font-weight: 600 !important;
        }

        .card-admin {
            border-radius: 0 !important;
            border: none !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
        }

        .table-admin th, .table-admin td {
            border: none !important;
            border-bottom: 1px solid #f0f0f0 !important;
        }

        .sidebar-link {
            color: #6c757d !important;
            text-decoration: none !important;
            transition: all 0.3s ease;
        }

        .sidebar-link:hover, .sidebar-link.active {
            color: #000 !important;
            background-color: #f8f9fa !important;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Admin Header -->
    <nav class="navbar navbar-expand-lg admin-header">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold text-dark mb-0 h1">
                <i class="fas fa-tshirt me-2"></i>
                TeeLuxe Admin
            </span>

            <div class="d-flex">
                <span class="navbar-text me-3">
                    Welcome, {{ Auth::user()->name }}!
                </span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-dark btn-sm btn-admin">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 admin-sidebar py-3">
                <nav class="nav flex-column">
                    <a class="nav-link sidebar-link py-3 {{ request()->is('admin/dashboard*') ? 'active' : '' }}" href="{{ route('admin.dashboard.view') }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a class="nav-link sidebar-link py-3 {{ request()->is('admin/products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                        <i class="fas fa-box me-2"></i> Products
                    </a>
                    <a class="nav-link sidebar-link py-3 {{ request()->is('admin/orders*') ? 'active' : '' }}" href="#" onclick="alert('Orders management coming soon')">
                        <i class="fas fa-shopping-cart me-2"></i> Orders
                    </a>
                    <a class="nav-link sidebar-link py-3 {{ request()->is('admin/users*') ? 'active' : '' }}" href="#" onclick="alert('Users management coming soon')">
                        <i class="fas fa-users me-2"></i> Users
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 admin-content">
                <!-- Breadcrumbs -->
                @hasSection('breadcrumb')
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4" style="border-radius: 0;">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.view') }}">Dashboard</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                @endif

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
