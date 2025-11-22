@php
    use App\Models\EventType;

    /** @var EventType[] $eventTypes */
@endphp

@extends('layouts.app')

@section('Calendar settings', 'Dashboard')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Calendar settings</h1>

        @include('parts._tabs', ['tabs' => [
            'calendar_settings' => __('calendar_settings.tabs.event_types')
        ]])

        <div class="row g-4 mb-5">
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-3">{{ __('calendar_settings.create.create') }}</h2>
                        <form method="POST" action="{{ route('calendar_settings__event_type__create') }}" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="role_name">{{ __('calendar_settings.create.identifier') }}</label>
                                <input type="text" id="identifier" name="identifier"
                                       value="{{ old('identifier') }}"
                                       class="form-control @error('identifier') is-invalid @enderror"
                                       placeholder="{{ __('calendar_settings.create.identifier_example') }}" required>
                                @error('identifier') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="role_description">{{ __('calendar_settings.create.description') }}</label>
                                <input type="text" id="role_description" name="description"
                                       value="{{ old('description') }}"
                                       class="form-control @error('description') is-invalid @enderror"
                                       placeholder="{{ __('calendar_settings.create.description_placeholder') }}">
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3 row">
                                <div class="col">
                                    <label class="form-label" for="background_color">{{ __('calendar_settings.create.bg_color') }}</label>
                                    <input type="color" class="form-control form-control-color" name="background_color" id="background_color" value="{{ old('background_color') ?? '#563d7c' }}" title="Choose your color">
                                    @error('background_color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col">
                                    <label class="form-label" for="text_color">{{ __('calendar_settings.create.text_color') }}</label>
                                    <input type="color" class="form-control form-control-color" name="text_color" id="text_color" value="{{ old('text_color') ?? '#FFFFFF' }}" title="Choose your color">
                                    @error('text_color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <button class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="h4 mb-3">{{ __('calendar_settings.list.title') }}</h3>

                        <ul class="list-group">
                            @forelse($eventTypes as $eventType)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="me-3 col">
                                        <strong>{{ $eventType->identifier }}</strong>
                                        @if($eventType->description)
                                            <span class="text-muted"> — {{ $eventType->description }}</span>
                                        @endif
                                        <div class="small text-muted row">
                                            <div class="col">
                                                {{ __('calendar_settings.list.bg_color') }}:
                                                <span class="d-inline-block rounded border"
                                                      style="width: 1.25rem; height: 1.25rem; background-color: {{ $eventType->background_color }};">
                                                </span>
                                                <span class="ms-1">{{ $eventType->background_color }}</span>
                                            </div>

                                            <div class="col">
                                                {{ __('calendar_settings.list.text_color') }}:
                                                <span class="d-inline-block rounded border"
                                                      style="width: 1.25rem; height: 1.25rem; background-color: {{ $eventType->text_color }};">
                                            </span>
                                                <span class="ms-1">{{ $eventType->text_color }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="btn-group" role="group" aria-label="Role actions">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal-{{ $eventType->identifier }}">
                                            {{ __('calendar_settings.list.edit') }}
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $eventType->identifier }}">
                                            {{ __('calendar_settings.list.delete') }}
                                        </button>
                                    </div>

                                    <div class="modal fade" id="editModal-{{ $eventType->identifier }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('calendar_settings__event_type__update', $eventType->identifier) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{!! __('calendar_settings.update.title', ['id' => $eventType->identifier]) !!}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="role_description">{{ __('calendar_settings.create.description') }}</label>
                                                            <input type="text" id="role_description" name="description"
                                                                   value="{{ old('description') ?? $eventType->description }}"
                                                                   class="form-control @error('description') is-invalid @enderror"
                                                                   placeholder="{{ __('calendar_settings.create.description_placeholder') }}">
                                                        </div>

                                                        <div class="mb-3 row">
                                                            <div class="col">
                                                                <label class="form-label" for="background_color">{{ __('calendar_settings.create.bg_color') }}</label>
                                                                <input type="color" class="form-control form-control-color" name="background_color" id="background_color" value="{{ old('background_color') ?? $eventType->background_color }}" title="Choose your color">
                                                            </div>

                                                            <div class="col">
                                                                <label class="form-label" for="text_color">{{ __('calendar_settings.create.text_color') }}</label>
                                                                <input type="color" class="form-control form-control-color" name="text_color" id="text_color" value="{{ old('text_color') ?? $eventType->text_color }}" title="Choose your color">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-link" data-bs-dismiss="modal" type="button">{{ __('calendar_settings.update.cancel') }}</button>
                                                        <button class="btn btn-primary" type="submit">{{ __('calendar_settings.update.save') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="deleteModal-{{ $eventType->identifier }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" action="{{ route('calendar_settings__event_type__delete', $eventType->identifier) }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ __('calendar_settings.delete.title') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! __('calendar_settings.delete.prompt', ['id' => $eventType->identifier]) !!}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-link" data-bs-dismiss="modal" type="button">{{ __('calendar_settings.delete.cancel') }}</button>
                                                        <button class="btn btn-danger" type="submit">{{ __('calendar_settings.delete.delete') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item">{{ __('calendar_settings.list.empty') }}</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
