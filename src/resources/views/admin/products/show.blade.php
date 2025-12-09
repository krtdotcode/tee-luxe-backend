@extends('admin.layout')

@section('title', 'Product Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
    <li class="breadcrumb-item active">{{ $product->name }}</li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="display-6 fw-bold text-dark mb-0">
                    <i class="fas fa-eye me-2"></i> Product Details
                </h1>
                <p class="text-muted mt-1">View product information</p>
            </div>
            <div>
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-admin me-2">
                    <i class="fas fa-edit me-2"></i> Edit Product
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-admin">
                    <i class="fas fa-arrow-left me-2"></i> Back to Products
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Product Image & Basic Info -->
    <div class="col-lg-4">
        <div class="card card-admin h-100">
            <div class="card-header">
                <h5 class="fw-bold mb-0">Product Image</h5>
            </div>
            <div class="card-body text-center">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: contain;">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 300px;">
                        <i class="fas fa-image text-muted fa-4x"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Product Details -->
    <div class="col-lg-8">
        <div class="card card-admin h-100">
            <div class="card-header">
                <h5 class="fw-bold mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4 fw-semibold">Product Name:</dt>
                    <dd class="col-sm-8">{{ $product->name }}</dd>

                    <dt class="col-sm-4 fw-semibold">Category:</dt>
                    <dd class="col-sm-8">{{ $product->category->name ?? 'No category' }}</dd>

                    <dt class="col-sm-4 fw-semibold">Price:</dt>
                    <dd class="col-sm-8 fw-bold text-primary">₱{{ number_format($product->price, 2) }}</dd>

                    @if($product->stock_quantity !== null)
                        <dt class="col-sm-4 fw-semibold">Stock Quantity:</dt>
                        <dd class="col-sm-8">{{ $product->stock_quantity }}</dd>
                    @else
                        <dt class="col-sm-4 fw-semibold">Stock Quantity:</dt>
                        <dd class="col-sm-8">Unlimited</dd>
                    @endif

                    <dt class="col-sm-4 fw-semibold">Status:</dt>
                    <dd class="col-sm-8">
                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }} rounded-0">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </dd>

                    <dt class="col-sm-4 fw-semibold">Description:</dt>
                    <dd class="col-sm-8">{{ $product->description ?? 'No description provided' }}</dd>

                    @if($product->created_at)
                        <dt class="col-sm-4 fw-semibold">Created At:</dt>
                        <dd class="col-sm-8">{{ $product->created_at->format('M d, Y \a\t h:i A') }}</dd>
                    @endif

                    @if($product->updated_at)
                        <dt class="col-sm-4 fw-semibold">Last Updated:</dt>
                        <dd class="col-sm-8">{{ $product->updated_at->format('M d, Y \a\t h:i A') }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Order Details (if applicable) -->
@if($product->orderDetails->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card card-admin">
            <div class="card-header">
                <h5 class="fw-bold mb-0">Order History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-admin mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-bold">Order #</th>
                                <th class="fw-bold">Customer</th>
                                <th class="fw-bold">Quantity</th>
                                <th class="fw-bold">Price</th>
                                <th class="fw-bold">Total</th>
                                <th class="fw-bold">Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->orderDetails as $orderDetail)
                            <tr>
                                <td class="fw-semibold">{{ $orderDetail->order->order_number ?? '#' . $orderDetail->order_id }}</td>
                                <td>{{ $orderDetail->order->user->name ?? 'Unknown' }}</td>
                                <td>{{ $orderDetail->quantity }}</td>
                                <td>₱{{ number_format($orderDetail->price, 2) }}</td>
                                <td class="fw-semibold">₱{{ number_format($orderDetail->quantity * $orderDetail->price, 2) }}</td>
                                <td>{{ $orderDetail->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <strong>Total Ordered: {{ $product->orderDetails->sum('quantity') }} units</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
