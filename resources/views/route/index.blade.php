@extends('layouts._app')

@section('title') Home @endsection

@section('css')
@endsection

@section('content')
<div id="app">
    @if(auth()->user()->roles->pluck('name')[0]=='super.admin')
    <route-super-index role="{{ auth()->user()->roles->pluck('name')[0] }}" business_id="{{ auth()->user()->business_id }}"></route-super-index>
    @endif
    @if(auth()->user()->roles->pluck('name')[0]=='admin')
        <route-admin-index role="{{ auth()->user()->roles->pluck('name')[0] }}" business_id="{{ auth()->user()->business_id }}"></route-admin-index>
    @endif
</div>
@endsection

@section('scripts')
<script src="{{ mix('/js/routes.js') }}"></script>
@endsection
