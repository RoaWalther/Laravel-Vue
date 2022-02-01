@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">App de notas</div>
                <div class="card-body">
                    <tareas-component></tareas-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
