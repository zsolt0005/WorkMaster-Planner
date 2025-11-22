@php
    use App\Models\User;

    /** @var User $user */
@endphp

@extends('layouts.app')

@section('title', __('profile.title'))

@section('content')
    <div class="container py-5">
        <h1>{{ __('profile.heading.view') }}</h1>

        <div class="mb-3">
            <div class="small text-muted">{{ __('profile.form.email') }}</div>
            <div><strong>{{ $user->email }}</strong></div>
        </div>

        <div class="mb-3">
            <div class="small text-muted">{{ __('profile.form.username') }}</div>
            <div><strong>{{ $user->username }}</strong></div>
        </div>

        <div class="mb-3">
            <div class="small text-muted">{{ __('profile.form.full_name') }}</div>
            <div><strong>{{ $user->full_name }}</strong></div>
        </div>

        <div class="mb-3">
            <div class="small text-muted mb-1">{{ __('profile.form.roles') }}</div>
            @php($roles = $user->roles)
            @if(count($roles))
                @foreach($roles as $role)
                    <span class="badge bg-secondary me-1 mb-1">{{ $role->role_name }}</span>
                @endforeach
            @else
                <span class="text-muted">— none —</span>
            @endif
        </div>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
            {{ __('profile.form.edit') }}
        </button>

        <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('profile__edit', $user->id) }}">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('profile.heading.edit') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <div class="small text-muted">{{ __('profile.form.profile_data_title') }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">{{ __('profile.form.email') }}</label>
                                <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" @cannot('edit_profile_data') disabled @endcannot>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="username">{{ __('profile.form.username') }}</label>
                                <input id="username" type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" @cannot('edit_profile_data') disabled @endcannot>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="full_name">{{ __('profile.form.full_name') }}</label>
                                <input id="full_name" type="text" name="full_name" class="form-control" value="{{ old('full_name', $user->full_name) }}" @cannot('edit_profile_data') disabled @endcannot>
                            </div>

                            <div class="mb-3 mt-5">
                                <div class="small text-muted">{{ __('profile.form.change_password_title') }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="current_password">{{ __('profile.form.current_password') }}</label>
                                <input id="current_password" type="text" name="current_password" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="password">{{ __('profile.form.password') }}</label>
                                <input id="password" type="text" name="password" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">{{ __('profile.form.password_confirmation') }}</label>
                                <input id="password_confirmation" type="text" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal">{{ __('profile.form.cancel') }}</button>
                            <button type="submit" class="btn btn-success">{{ __('profile.form.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
