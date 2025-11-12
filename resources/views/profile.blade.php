@extends('layouts.app')

@section('title', __('profile.title'))

@section('content')
    <div class="container py-5">
        <h1>{{ __('profile.heading.view') }}</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered w-auto">
            <tr>
                <th>{{ __('profile.form.email') }}</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>{{ __('profile.form.username') }}</th>
                <td>{{ $user->username }}</td>
            </tr>
            <tr>
                <th>{{ __('profile.form.full_name') }}</th>
                <td>{{ $user->full_name }}</td>
            </tr>
        </table>

        <a href="{{ route('edit_profile') }}" class="btn btn-primary mt-3">
            {{ __('profile.form.edit') }}
        </a>
    </div>
@endsection
