@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        {{ __('user.index') }}
                    </div>
                    <div class="float-right">
                        <a href="{{ route('user_create') }}" class="btn btn-info">{{ __('user.add') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <user-index-component></user-index-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
