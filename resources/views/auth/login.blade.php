@extends('layouts.auth')

@section('content')
    <section class="">
        <div class="d-flex flex-wrap align-items-center">
            <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                <div class="p-4 m-3 mt-md-5 py-md-5">
                    <h4 class="text-dark font-weight-normal">Welcome to <span class="fw-bold">Ecommerce</span></h4>
                    <p class="text-muted">
                        Before you get started, you must login or register if you don't already have an
                        account.
                    </p>

                    <form method="POST"
                          action="{{ route('login') }}"
                          class="needs-validation"
                          novalidate="">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email"
                                   type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   tabindex="1"
                                   required
                                   autofocus>
                            @error('email')
                            <div class="invalid-feedback">
                                Please fill in your email
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="d-block">
                                <label for="password"
                                       class="control-label">Password</label>
                            </div>
                            <input id="password"
                                   type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   tabindex="2"
                                   required>
                            @error('password')
                            <div class="invalid-feedback">
                                please fill in your password
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       name="remember"
                                       class="custom-control-input @error('remember') is-invalid @enderror"
                                       tabindex="3"
                                       id="remember-me">
                                <label class="custom-control-label"
                                       for="remember-me">Remember Me</label>

                            </div>
                        </div>

                        <div class="form-group text-end">
                            <a href="{{ route('password.request') }}"
                               class="float-start mt-3">
                                Forgot Password?
                            </a>
                            <button type="submit"
                                    class="btn btn-primary btn-lg btn-icon icon-right"
                                    tabindex="4">
                                Login
                            </button>
                        </div>

                        <div class="mt-5 text-center">
                            Don't have an account? <a href="{{ route('register') }}">Create new one</a>
                        </div>
                    </form>


                    <div class="text-center mt-5 text-small">
                        Copyright {{ date('Y') }} Ecommerce. All rights reserved.
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom"
                 style="background-image: url('https://images.unsplash.com/photo-1672862817339-51ef2610a5d0?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2109&q=80'); background-size: cover">
                <div class="absolute-bottom-left index-2">
                    <div class="text-light p-5 pb-2">
                        <div class="mb-5 pb-3">
                            <h1 class="mb-2 display-4 font-weight-bold">Good Morning</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
