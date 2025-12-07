@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="display-6 fw-bold text-dark mb-4">
            <i class="fas fa-tachometer-alt me-2"></i> Admin Dashboard
        </h1>
        <p class="text-muted">Welcome to your admin panel. Manage your TeeLuxe products and orders from here.</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="card card-admin h-100">
            <div class="card-body text-center p-4">
                <div class="text-primary mb-3">
                    <i class="fas fa-box fa-3x"></i>
                </div>
                <h2 class="fw-bold mb-2">{{ number_format($stats['total_products']) }}</h2>
                <p class="text-muted mb-0 fw-semibold">Total Products</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-admin h-100">
            <div class="card-body text-center p-4">
                <div class="text-success mb-3">
                    <i class="fas fa-users fa-3x"></i>
                </div>
                <h2 class="fw-bold mb-2">{{ number_format($stats['total_users']) }}</h2>
                <p class="text-muted mb-0 fw-semibold">Total Users</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-admin h-100">
            <div class="card-body text-center p-4">
                <div class="text-warning mb-3">
                    <i class="fas fa-shopping-cart fa-3x"></i>
                </div>
                <h2 class="fw-bold mb-2">{{ number_format($stats['total_orders']) }}</h2>
                <p class="text-muted mb-0 fw-semibold">Total Orders</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-admin h-100">
            <div class="card-body text-center p-4">
                <div class="text-danger mb-3">
                    <i class="fas fa-clock fa-3x"></i>
                </div>
                <h2 class="fw-bold mb-2">{{ number_format($stats['pending_orders']) }}</h2>
                <p class="text-muted mb-0 fw-semibold">Pending Orders</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row">
    <div class="col-12">
        <div class="card card-admin">
            <div class="card-header border-0 pb-0">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fas fa-shopping-cart me-2"></i> Recent Orders
                </h5>
            </div>
            <div class="card-body">
                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-admin mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-bold">Order #</th>
                                    <th class="fw-bold">Customer</th>
                                    <th class="fw-bold">Total</th>
                                    <th class="fw-bold">Status</th>
                                    <th class="fw-bold">Date</th>
                                    <th class="fw-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td class="fw-semibold">{{ $order->order_number }}</td>
                                    <td>{{ $order->user->name ?? 'Unknown' }}</td>
                                    <td class="fw-semibold">₱{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $order->status === 'pending' ? 'bg-warning' :
                                                       ($order->status === 'processing' ? 'bg-info' :
                                                       ($order->status === 'shipped' ? 'bg-primary' :
                                                       ($order->status === 'delivered' ? 'bg-success' : 'bg-secondary'))) }} rounded-0">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="#" class="btn btn-outline-dark btn-sm btn-admin">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="#" onclick="alert('Orders management coming soon')" class="btn btn-dark btn-admin">
                            <i class="fas fa-arrow-right me-2"></i> View All Orders
                        </a>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart text-muted fa-4x mb-3"></i>
                        <h4 class="text-muted mb-2">No orders yet</h4>
                        <p class="text-muted mb-0">When customers place orders, they'll appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card card-admin">
            <div class="card-body text-center">
                <h5 class="fw-bold text-dark mb-4">Quick Actions</h5>
                <div class="row g-3 justify-content-center">
                    <div class="col-auto">
                        <a href="{{ route('admin.admin.products.create') }}" class="btn btn-dark btn-admin px-4">
                            <i class="fas fa-plus me-2"></i>
                            Add Product
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.admin.products.index') }}" class="btn btn-outline-dark btn-admin px-4">
                            <i class="fas fa-list me-2"></i>
                            View Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
