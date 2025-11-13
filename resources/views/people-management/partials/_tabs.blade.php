@php($current = $current ?? 'roles')

<ul class="nav nav-pills nav-fill mb-4 border-bottom-0">
        <li class="nav-item">
            <a class="nav-link @if($current === 'roles') active @endif" href="{{ route('roles') }}">Roles</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($current === 'permissions') active @endif" href="{{ route('permissions') }}">Permissions</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($current === 'users') active @endif" href="{{ route('users') }}">Users</a>
        </li>
</ul>
