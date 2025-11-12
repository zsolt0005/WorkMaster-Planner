@extends('layouts.app')

@section('title', __('profile.title'))

@section('content')
    <div class="container py-5">
        <h1>{{ __('profile.heading.edit') }}</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('edit_profile') }}">
            @csrf
            <table class="table">
                <tr>
                    <td><label for="email">{{ __('profile.form.email') }}</label></td>
                    <td><input type="email" name="email" value="{{ old('email', $user->email) }}" required></td>
                </tr>

                <tr>
                    <td><label for="username">{{ __('profile.form.username') }}</label></td>
                    <td><input type="text" name="username" value="{{ old('username', $user->username) }}" required></td>
                </tr>

                <tr>
                    <td><label for="full_name">{{ __('profile.form.full_name') }}</label></td>
                    <td><input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" required></td>
                </tr>

                <tr>
                    <td><label for="current_password">{{ __('profile.form.current_password') }}</label></td>
                    <td><input type="password" name="current_password"></td>
                </tr>
                <tr>
                    <td><label for="password">{{ __('profile.form.password') }}</label></td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr>
                    <td><label for="password_confirmation">{{ __('profile.form.password_confirmation') }}</label></td>
                    <td><input type="password" name="password_confirmation"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <button type="submit" class="btn btn-primary">{{ __('profile.form.save') }}</button>
                        <a href="{{ route('profile') }}" class="btn btn-secondary ms-2">{{ __('profile.form.back') }}</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
@endsection
