@extends('layouts.clean')

@section('title', 'Login')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h4 mb-4 text-center">Login</h1>

                        <form method="POST" action="{{ route('login') }}" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="login" class="form-label">{{ __('login.form.login') }}</label>
                                <input
                                    type="text"
                                    class="form-control @error('login') is-invalid @enderror"
                                    id="login"
                                    name="login"
                                    value="{{ old('login') }}"
                                    placeholder="you@example.com / example"
                                    required
                                    autocomplete="username"
                                >
                                @error('login')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('login.form.password') }}</label>
                                <div class="input-group">
                                    <input
                                        type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        id="password"
                                        name="password"
                                        placeholder="••••••••"
                                        required
                                        autocomplete="current-password"
                                    >
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword" aria-label="Show password">
                                        <span class="bi bi-eye" aria-hidden="true"></span>
                                    </button>
                                    @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('login.form.submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/pages/login.js'])
@endsection
