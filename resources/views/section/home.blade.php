@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        {{ __('section.index') }}
                    </div>
                    <div class="float-right">
                        <a href="{{ route('section_create') }}" class="btn btn-info">{{ __('section.add') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <section-index-component></section-index-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
