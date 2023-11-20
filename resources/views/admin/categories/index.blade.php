@extends('layouts.app')

@section('title')
    All Categories
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Categories</h1>
            <div class="section-header-button">
                <a href="{{ route('admin.categories.create') }}"
                   class="btn btn-primary">Create Category</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/administration">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></div>
                <div class="breadcrumb-item">All Categories</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Categories</h2>
            <p class="section-lead">
                You can manage all categories, such as editing, deleting and more.
            </p>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Categories</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-end">
                                <form>
                                    <div class="d-flex">
                                        <input type="text"
                                               class="form-control w-full"
                                               placeholder="Search"
                                            {{ stimulus_controller('filter', [
                                                'route' => 'admin.categories.index',
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
                                            <th>Parent Category</th>
                                            <th>Created At</th>
                                        </tr>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td
                                                    {{ stimulus_controller('obliterate', ['url' => route('admin.categories.destroy', $category)]) }}>
                                                    {{ Str::title($category->name) }}
                                                    <div class="table-links">
                                                        <a class="btn btn-link"
                                                           href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                                                        <div class="bullet"></div>
                                                        <button {{ stimulus_action('obliterate', 'handle') }}
                                                                class="btn btn-link text-danger">Trash</button>
                                                        <form {{ stimulus_target('obliterate', 'form') }}
                                                              method="POST"
                                                              action="{{ route('admin.categories.destroy', $category) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>
                                                    {!! Str::limit($category->description, 90) !!}
                                                </td>
                                                <td>
                                                    {{ $category?->parent?->name }}
                                                </td>
                                                <td>{{ $category->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    <nav>
                                        {{ $categories->links('vendor.pagination.bootstrap-5') }}
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
