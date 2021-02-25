@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header">Libros <a href='{{route('create')}}' class="btn btn-primary float-right">Crear</a></div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Cover</th>
                        <th>ISBN</th>
                        <th>Titulo</th>

                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($libros as $libro)
                        <tr>
                            <td>@if (!is_null($libro->cover))         
                                <img src="{{$libro->cover}}" alt="img" class="img-thumbnail" width="100" height="200" >
                                @else                                    
                                Sin imagen
                                @endif
                            </td>
                            <td>{{$libro->isbn}}</td>
                            <th>{{$libro->titulo}}</th>

                            <td>
                                <a href="{{route('show',$libro->isbn)}}" class="btn btn-warning">Detalles</a>
                                <form method="POST" action="{{route('destroy',$libro->isbn)}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                  </form>

                            </td>
                        </tr>
                        @endforeach
                    
                    </tbody>
                  </table>
                  {{ $libros->links() }}
                </div>
            </div>
    </div>
</div>
@endsection
