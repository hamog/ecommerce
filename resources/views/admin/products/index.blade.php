@extends('layouts.app')

@section('title')
    Products
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Products</h1>
            <div class="section-header-button">
                <a href="{{ route('admin.products.create') }}"
                   class="btn btn-primary">Add New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.home.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></div>
                <div class="breadcrumb-item">All Posts</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Products</h2>
            <p class="section-lead">
                You can manage all products, such as editing, deleting and more.
            </p>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Products</h4>
                            <div class="card-header-form">
                                <form>
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control"
                                               placeholder="Search"
                                            {{ stimulus_controller('filter', [
                                               'route' => 'admin.products.index',
                                               'filter' => 'search',
                                            ]) }}
                                            {{ stimulus_action('filter', 'change', 'input') }}>

                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">

                            <turbo-frame class='w-full'
                                         id='categories'
                                         target="_top"
                                {{ stimulus_controller('reload') }}
                                {{ stimulus_actions([
                                    [
                                        'reload' => ['filterChange', 'filter:change@document'],
                                    ],
                                    [
                                        'reload' => ['sortChange', 'sort:change@document'],
                                    ],
                                ]) }}>

                                <div class="table-responsive">
                                    <table class="table table-borderless table-invoice rounded">
                                        <tr>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Quantity</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                        </tr>

                                        @foreach ($products as $product)
                                            <tr>
                                                <td data-controller="obliterate"
                                                    data-obliterate-url-value="{{ route('admin.products.destroy', $product) }}">
                                                    {{ $product->name }}
                                                </td>
                                                <td>
                                                    {{ $product->category->name }}
                                                </td>
                                                <td>
                                                    {{ $product->quantity ?? 0 }} left
                                                </td>
                                                <td>{{ $product->created_at->diffForHumans() }}</td>
                                                <td>
                                                    @if ($product->status == 'active')
                                                        <div class="badge badge-primary">Active</div>
                                                    @else
                                                        <div class="badge badge-danger">Draft</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>
                                                        <a href='{{ route('admin.products.edit', $product) }}'
                                                           class='btn btn-primary'>Edit</a>
                                                        <a data-turbo-method='delete'
                                                           href='{{ route('admin.products.destroy', $product) }}'
                                                           class='btn btn-danger'>Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $products->links('vendor.pagination.bootstrap-5') }}
                                </div>

                            </turbo-frame>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

