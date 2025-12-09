@extends('admin.layout')

@section('title', 'Edit Product')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
    <li class="breadcrumb-item active">Edit: {{ $product->name }}</li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="display-6 fw-bold text-dark mb-4">
            <i class="fas fa-edit me-2"></i> Edit Product
        </h1>
        <p class="text-muted">Update product information</p>
    </div>
</div>

<div class="card card-admin">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <!-- Product Name -->
                <div class="col-md-12">
                    <label for="name" class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                           value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category -->
                <div class="col-md-6">
                    <label for="category_id" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Price -->
                <div class="col-md-6">
                    <label for="price" class="form-label fw-semibold">Price (₱) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror"
                           id="price" name="price" value="{{ old('price', $product->price) }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="col-md-12">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                              rows="4">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Stock Quantity -->
                <div class="col-md-6">
                    <label for="stock_quantity" class="form-label fw-semibold">Stock Quantity</label>
                    <input type="number" min="0" class="form-control @error('stock_quantity') is-invalid @enderror"
                           id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" placeholder="Leave empty for unlimited">
                    @error('stock_quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Leave empty if stock is unlimited</div>
                </div>

                <!-- Active Status -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active (visible to customers)
                        </label>
                    </div>
                </div>

                <!-- Current Product Image -->
                <div class="col-md-12">
                    @if($product->image)
                        <label class="form-label fw-semibold">Current Image</label>
                        <div class="mb-3">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-height: 150px; max-width: 150px;">
                        </div>
                        <p class="text-muted mb-2">Leave the image field below empty to keep the current image, or upload a new one to replace it.</p>
                    @endif
                </div>

                <!-- Product Image -->
                <div class="col-md-12">
                    <label for="image" class="form-label fw-semibold">Product Image {{ !$product->image ? '(Required if not uploaded before)' : '(Optional - upload new image)' }}</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-dark btn-admin">
                    <i class="fas fa-save me-2"></i> Update Product
                </button>
                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-primary btn-admin">
                    <i class="fas fa-eye me-2"></i> View Product
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-admin">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
