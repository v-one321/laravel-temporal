@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    @can('crear')
                        <p>Tienes permiso de crear</p>
                        <button class="btn btn-primary">Agregar</button>
                    @endcan
                    @can('editar')
                        <p>Tienes permiso para editar</p>
                        <button class="btn btn-warning">Editar</button>
                    @endcan
                    @can('eliminar')
                        <p>tienes permiso para eliminar</p>
                        <button class="btn btn-danger">Eliminar</button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
