@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container py-5">
        <h1>Profil</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered w-auto">
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Meno (username)</th>
                <td>{{ $user->username }}</td>
            </tr>
            <tr>
                <th>Full name</th>
                <td>{{ $user->full_name }}</td>
            </tr>
        </table>

        <a href="{{ url('/edit-profile') }}" class="btn btn-primary mt-3">
            Upraviť profil
        </a>
    </div>
@endsection
