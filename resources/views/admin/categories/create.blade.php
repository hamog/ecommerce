@extends('layouts.app')

@section('title')
    Create Category
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Categories</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Categories</a></div>
                <div class="breadcrumb-item">Create Category</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Create Category</h2>
            <p class="section-lead mb-5">On this page you can create categories or departments for your products.</p>

            <form method="post"
                  action="{{ route('admin.categories.store') }}">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <p class="section-lead">Add basic information about the category or department.</p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">

                            <div class="card-header">
                                <h4>Category details</h4>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="parent_id">Parent</label>
                                    <select id="parent_id"
                                            class="form-select custom-control custom-select @error('parent_id') is-invalid @enderror"
                                            name="parent_id">
                                        @foreach ($categories as $category)
                                            @if ($category->id === 0)
                                                <option selected
                                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                            @else
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @error('parent_id')
                                    <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}">

                                    @error('name')
                                    <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description"
                                              id="description"
                                              rows="8"
                                              class="form-control @error('description') is-invalid @enderror ">{{ old('description') }}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group text-right">
                                    <button type="submit"
                                            class="btn btn-dark btn-lg">Create Category</button>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </form>
        </div>
    </section>
@endsection
