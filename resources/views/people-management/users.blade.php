@extends('layouts.app')

@section('title', 'People • Users')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">{{ __('users.headers.people-management') }}</h1>

        @include('parts._tabs', ['tabs' => [
            'users' => __('tabs.users'),
            'roles' => __('tabs.roles'),
            'permissions' => __('tabs.permissions')
        ]])
        
        <div class="row g-4">
            <div class="col-12 col-lg-12">
                <div class="card shadow-sm">
                    <!-- GREGORIK, later delete -->
                    <div class="card-body">
                        <h2 class="h5 mb-3">Create New User</h2>

                        <form method="POST" action="{{ route('create_user') }}" novalidate>
                            @csrf

                            {{-- 1. Užívateľské Meno (USERNAME) --}}
                            <div class="mb-3">
                                <label class="form-label" for="username">Užívateľské Meno</label>
                                <input type="text" id="username" name="username"
                                       value="{{ old('username') }}"
                                       class="form-control @error('username') is-invalid @enderror"
                                       required>
                                @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- 2. Celé Meno (FULL_NAME) --}}
                            <div class="mb-3">
                                <label class="form-label" for="full_name">Celé Meno</label>
                                <input type="text" id="full_name" name="full_name"
                                       value="{{ old('full_name') }}"
                                       class="form-control @error('full_name') is-invalid @enderror"
                                       required>
                                @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- 3. E-mail (EMAIL) --}}
                            <div class="mb-3">
                                <label class="form-label" for="email">E-mail</label>
                                <input type="email" id="email" name="email"
                                       value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- 4. Heslo (PASSWORD) --}}
                            <div class="mb-3">
                                <label class="form-label" for="password">Heslo</label>
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- 5. Potvrdenie Hesla (PASSWORD_CONFIRMATION) --}}
                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">Potvrdenie Hesla</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="form-control"
                                       required>
                            </div>

                            <button class="btn btn-primary">Create User</button>
                        </form>
                    </div>
                    <!-- GREGORIK, later delete -->

                    <div class="card-body">
                        <h2 class="h4 mb-3">{{ __('users.headers.users') }}</h2>

                        <ul class="list-group">
                            @forelse($users as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $user->full_name ?? $user->name ?? $user->username ?? $user->email }}</strong>
                                        <span class="text-muted small">— {{ $user->email }}</span>
                                        <div class="small text-muted">
                                            Roles: {{ $user->roles->pluck('role_name')->join(', ') ?: '—' }}
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#assignUserRolesModal-{{ $user->id }}">
                                        {{ __('buttons.assign') }}
                                    </button>
                                </li>

                                <div class="modal fade" id="assignUserRolesModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('assign_roles') }}">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Assign roles to {{ $user->full_name ?? $user->name ?? $user->username ?? $user->email }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <div class="form-label mb-1">{{ __('users.currently-assigned') }}</div>
                                                        @php($selected = $user->roles->pluck('id')->all())
                                                        @if(count($selected))
                                                            @foreach($user->roles as $r)
                                                                <span class="badge bg-secondary me-1 mb-1">{{ $r->role_name }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">— none —</span>
                                                        @endif
                                                    </div>

                                                    <div class="mb-2">
                                                        <div class="form-label mb-2">{{ __('users.assign-roles') }}</div>

                                                        <div class="border rounded p-2" style="max-height: 260px; overflow: auto;">
                                                            @foreach($roles as $role)
                                                                @php($id = "role-{$user->id}-{$role->id}")
                                                                <div class="form-check">
                                                                    <input
                                                                        class="form-check-input"
                                                                        type="checkbox"
                                                                        name="role_ids[]"
                                                                        value="{{ $role->id }}"
                                                                        id="{{ $id }}"
                                                                        @checked(in_array($role->id, $selected))
                                                                    >
                                                                    <label class="form-check-label" for="{{ $id }}">
                                                                        {{ $role->role_name }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <div class="form-text">Tick roles to keep/assign; untick to remove.</div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">{{ __('buttons.cancel') }}</button>
                                                    <button type="submit" class="btn btn-success">{{ __('buttons.save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <li class="list-group-item">No users found.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
