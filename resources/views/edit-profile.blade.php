@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container py-5">
        <h1>Upraviť profil</h1>

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

        <form method="POST" action="{{ url('/edit-profile') }}">
            @csrf
            <table class="table">
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" name="email" value="{{ old('email', $user->email) }}" required></td>
                </tr>

                <tr>
                    <td><label for="username">Username:</label></td>
                    <td><input type="text" name="username" value="{{ old('username', $user->username) }}" required></td>
                </tr>

                <tr>
                    <td><label for="full_name">Full name:</label></td>
                    <td><input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" required></td>
                </tr>

                <tr>
                    <td><label for="current_password">Staré heslo:</label></td>
                    <td><input type="password" name="current_password"></td>
                </tr>
                <tr>
                    <td><label for="password">Nové heslo:</label></td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr>
                    <td><label for="password_confirmation">Potvrdiť heslo:</label></td>
                    <td><input type="password" name="password_confirmation"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <button type="submit" class="btn btn-primary">Uložiť</button>
                        <a href="{{ url('/profile') }}" class="btn btn-secondary ms-2">Späť na profil</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
@endsection
