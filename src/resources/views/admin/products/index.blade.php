@extends('admin.layout')

@section('title', 'Products')

@section('breadcrumb')
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="display-6 fw-bold text-dark mb-0">
                    <i class="fas fa-box me-2"></i> Products
                </h1>
                <p class="text-muted mt-1">Manage your product catalog</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="btn btn-dark btn-admin">
                <i class="fas fa-plus me-2"></i> Add New Product
            </a>
        </div>
    </div>
</div>

<div class="card card-admin">
    <div class="card-body p-0">
        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-bold">Image</th>
                            <th class="fw-bold">Name</th>
                            <th class="fw-bold">Category</th>
                            <th class="fw-bold">Price</th>
                            <th class="fw-bold">Stock</th>
                            <th class="fw-bold">Status</th>
                            <th class="fw-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'No category' }}</td>
                            <td class="fw-semibold">₱{{ number_format($product->price, 2) }}</td>
                            <td>
                                @if($product->stock_quantity !== null)
                                    {{ $product->stock_quantity }}
                                @else
                                    <span class="text-muted">Unlimited</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }} rounded-0">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-primary btn-admin" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-warning btn-admin" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-admin" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this product?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="card-footer border-0 bg-transparent">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-box text-muted fa-4x mb-3"></i>
                <h4 class="text-muted mb-2">No products yet</h4>
                <p class="text-muted mb-4">Start building your catalog by adding your first product.</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-dark btn-admin">
                    <i class="fas fa-plus me-2"></i> Add First Product
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
