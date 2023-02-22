@extends('layouts._app')

@section('title') Home @endsection

@section('css')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div id="app">
                    @if(auth()->user()->roles->pluck('name')[0]=='super.admin')
                    	<route-index role="{{ auth()->user()->roles->pluck('name')[0] }}" business_id="{{ auth()->user()->business_id }}"></route-index>
                    @endif
                    @if(auth()->user()->roles->pluck('name')[0]=='admin')
                    	<route-admin-index role="{{ auth()->user()->roles->pluck('name')[0] }}" business_id="{{ auth()->user()->business_id }}"></route-admin-index>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
