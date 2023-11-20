@extends('layouts.app')

@section('title')
    Create Brand
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Brands</h1>
            <div class="section-header-breadcrumb breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.home.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.brands.index') }}">Brands</a></div>
                <div class="breadcrumb-item">Create Brand</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Create Brand</h2>
            <p class="section-lead mb-5">On this page you can create brand for your products.</p>

            <form method="post"
                  action="{{ route('admin.brands.store') }}">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <p class="section-lead">Add basic information about the brand.</p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">

                            <div class="card-header">
                                <h4>Brand details</h4>
                            </div>

                            <div class="card-body">
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
                                            class="btn btn-primary btn-lg">Create Brand</button>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </form>
        </div>
    </section>
@endsection
