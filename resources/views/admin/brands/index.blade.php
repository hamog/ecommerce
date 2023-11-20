@extends('layouts.app')

@section('title')
    Brands
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Brands</h1>
            <div class="section-header-button">
                <a href="{{ route('admin.brands.create') }}"
                   class="btn btn-primary">Create Brand</a>
            </div>
            <div class="section-header-breadcrumb breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.home.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.brands.index') }}">Brands</a></div>
                <div class="breadcrumb-item active">All Brands</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Brand</h2>
            <p class="section-lead">
                You can manage brands, such as editing, deleting and more.
            </p>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Brands</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-end">
                                <form>
                                    <div class="d-flex">
                                        <input type="text"
                                               class="form-control w-full"
                                               placeholder="Search"
                                            {{ stimulus_controller('filter', [
                                                'route' => 'admin.brands.index',
                                                'filter' => 'search',
                                            ]) }}
                                            {{ stimulus_action('filter', 'change', 'input') }}>
                                    </div>
                                </form>
                            </div>

                            <div class="clearfix mb-3"></div>

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
                                    <table class="table table-borderless">
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Created At</th>
                                        </tr>
                                        @foreach ($brands as $brand)
                                            <tr>
                                                <td
                                                    {{ stimulus_controller('obliterate', ['url' => route('admin.brands.destroy', $brand)]) }}>
                                                    {{ Str::title($brand->name) }}
                                                    <div class="table-links">
                                                        <a class="btn btn-link"
                                                           href="{{ route('admin.brands.edit', $brand) }}">Edit</a>
                                                        <div class="bullet"></div>
                                                        <button {{ stimulus_action('obliterate', 'handle') }}
                                                                class="btn btn-link text-danger">Trash</button>
                                                        <form {{ stimulus_target('obliterate', 'form') }}
                                                              method="POST"
                                                              action="{{ route('admin.brands.destroy', $brand) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>
                                                    {!! Str::limit($brand->description, 90) !!}
                                                </td>
                                                <td>{{ $brand->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>

                                <div class="float-right">
                                    <nav>
                                        {{ $brands->links('vendor.pagination.bootstrap-5') }}
                                    </nav>
                                </div>
                            </turbo-frame>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
