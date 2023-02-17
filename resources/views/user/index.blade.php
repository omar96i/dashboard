@extends('layouts._app')

@section('title') Usuarios @endsection

@section('css')
@endsection
@section('content')
<h5 class="fw-bold py-2 mb-3"><span class="text-muted fw-light">Gestion de usuarios /</span> Usuarios</h5>
<div class="col-lg-12 mb-4 order-0">
    <div class="card">
        <div class="d-flex align-items-end row">
            <div id="app">
                <user-index></user-index>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
