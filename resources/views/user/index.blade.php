@extends('layouts._app')

@section('title') Usuarios @endsection

@section('css')
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div id="app">
                    <user-index role="{{ auth()->user()->roles->pluck('name')[0] }}" business_id="{{ auth()->user()->business_id }}"></user-index>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ mix('/js/app.js') }}"></script>
@endsection
