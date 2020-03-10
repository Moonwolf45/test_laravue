@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            {{ __('section.index') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <section-create-component></section-create-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
