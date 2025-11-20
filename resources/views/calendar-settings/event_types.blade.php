@extends('layouts.app')

@section('Calendar settings', 'Dashboard')

@section('content')
    <div class="container py-5">
        @include('parts._tabs', ['tabs' => [
            'calendar_settings' => __('calendar_settings.tabs.event_types')
        ]])
    </div>
@endsection
