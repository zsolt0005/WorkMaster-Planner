@extends('layouts.app')

@section('title', 'People • Roles')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">People Management</h1>

        @include('people-management.partials._tabs', ['current' => 'roles'])

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="row g-4 mb-5">
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Create Role</h2>
                        <form method="POST" action="{{ route('create_role') }}" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="role_name">Name</label>
                                <input type="text" id="role_name" name="role_name"
                                       value="{{ old('role_name') }}"
                                       class="form-control @error('role_name') is-invalid @enderror"
                                       placeholder="manager / worker" required>
                                @error('role_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="role_description">Description (optional)</label>
                                <input type="text" id="role_description" name="description"
                                       value="{{ old('description') }}"
                                       class="form-control @error('description') is-invalid @enderror"
                                       placeholder="Role purpose">
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <button class="btn btn-primary">Create Role</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="h4 mb-3">Existing Roles</h3>
                        <ul class="list-group">
                            @forelse($roles as $role)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <strong>{{ $role->role_name }}</strong>
                                        @if($role->description)
                                            <span class="text-muted">— {{ $role->description }}</span>
                                        @endif
                                        <div class="small text-muted">
                                            Permissions: {{ $role->permissions->pluck('perm_name')->join(', ') ?: '—' }}
                                        </div>
                                    </div>

                                    <div class="btn-group" role="group" aria-label="Role actions">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editRoleModal-{{ $role->id }}">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteRoleModal-{{ $role->id }}">
                                            Delete
                                        </button>
                                    </div>
                                </li>

                                <div class="modal fade" id="editRoleModal-{{ $role->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('update_role', $role->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Role</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="role-name-{{ $role->id }}">Name</label>
                                                        <input type="text" name="role_name" id="role-name-{{ $role->id }}"
                                                               class="form-control" value="{{ old('role_name', $role->role_name) }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="role-description-{{ $role->id }}">Description</label>
                                                        <input type="text" name="description" id="role-description-{{ $role->id }}"
                                                               class="form-control" value="{{ old('description', $role->description) }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-link" data-bs-dismiss="modal" type="button">Cancel</button>
                                                    <button class="btn btn-primary" type="submit">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="deleteRoleModal-{{ $role->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('delete_role', $role->id) }}">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Role</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete <strong>{{ $role->role_name }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-link" data-bs-dismiss="modal" type="button">Cancel</button>
                                                    <button class="btn btn-danger" type="submit">Delete role</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <li class="list-group-item">No roles yet.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
