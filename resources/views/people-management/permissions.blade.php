@extends('layouts.app')

@section('title', 'People • Permissions')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">People Management</h1>

        @include('parts._tabs', ['tabs' => [
            'users' => __('people-management.tabs.users'),
            'roles' => __('people-management.tabs.roles'),
            'permissions' => __('people-management.tabs.permissions')
        ]])

        <div class="row g-4 mb-5">
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Create Permission</h2>
                        <form method="POST" action="{{ route('create_permission') }}" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="perm_name">Name</label>
                                <input type="text" id="perm_name" name="perm_name"
                                       value="{{ old('perm_name') }}"
                                       class="form-control @error('perm_name') is-invalid @enderror"
                                       placeholder="edit_events / manage_workers" required>
                                @error('perm_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="perm_description">Description (optional)</label>
                                <input type="text" id="perm_description" name="description"
                                       value="{{ old('description') }}"
                                       class="form-control @error('description') is-invalid @enderror"
                                       placeholder="What this permission allows">
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <button class="btn btn-primary">Create Permission</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Permissions</h2>
                        <ul class="list-group">
                            @forelse($permissions as $permission)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <strong>{{ $permission->perm_name }}</strong>
                                        @if($permission->description)
                                            <span class="text-muted">— {{ $permission->description }}</span>
                                        @endif
                                    </div>

                                    <div class="btn-group" role="group" aria-label="Permission actions">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-success"
                                            data-bs-toggle="modal"
                                            data-bs-target="#assignPermModal-{{ $permission->id }}"
                                        >
                                            Assign
                                        </button>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editPermModal-{{ $permission->id }}"
                                        >
                                            Edit
                                        </button>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deletePermModal-{{ $permission->id }}"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </li>

                                <div class="modal fade" id="assignPermModal-{{ $permission->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('assign_permission') }}">
                                                @csrf
                                                <input type="hidden" name="permission_id" value="{{ $permission->id }}"/>

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Manage roles for: “{{ $permission->perm_name }}”</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <div class="small text-muted">Permission</div>
                                                        <div><strong>{{ $permission->perm_name }}</strong></div>
                                                        @if($permission->description)
                                                            <div class="text-muted">{{ $permission->description }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="mb-3">
                                                        <div class="small text-muted mb-1">Currently assigned to roles</div>
                                                        @php($selected = $permission->roles->pluck('id')->all())
                                                        @if(count($selected))
                                                            @foreach($permission->roles as $r)
                                                                <span class="badge bg-secondary me-1 mb-1">{{ $r->role_name }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">— none —</span>
                                                        @endif
                                                    </div>

                                                    <div class="mb-2">
                                                        <div class="form-label mb-2">Assign / unassign roles</div>

                                                        <div class="border rounded p-2" style="max-height: 260px; overflow: auto;">
                                                            @foreach($roles as $role)
                                                                @php($id = "perm-{$permission->id}-role-{$role->id}")
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

                                                        <div class="form-text">Tick to grant this permission to a role; untick to remove it.</div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-success">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade" id="editPermModal-{{ $permission->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('update_permission', $permission->id) }}">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Permission</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="perm-name-{{ $permission->id }}">Name</label>
                                                        <input
                                                            id="perm-name-{{ $permission->id }}"
                                                            type="text"
                                                            name="perm_name"
                                                            class="form-control"
                                                            value="{{ old('perm_name', $permission->perm_name) }}"
                                                            maxlength="255"
                                                            required
                                                        >
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="perm-desc-{{ $permission->id }}">Description</label>
                                                        <input
                                                            id="perm-desc-{{ $permission->id }}"
                                                            type="text"
                                                            name="description"
                                                            class="form-control"
                                                            value="{{ old('description', $permission->description) }}"
                                                            maxlength="255"
                                                        >
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="deletePermModal-{{ $permission->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('delete_permission', $permission->id) }}">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Permission</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <p class="mb-0">
                                                        Are you sure you want to delete
                                                        <strong>{{ $permission->perm_name }}</strong>?
                                                    </p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Delete permission</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <li class="list-group-item">No permissions yet.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
