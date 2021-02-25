@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header">Crear</div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                
                <form action="{{route('store')}}" method="post">
                    @csrf
                
                    <div class="form-group">
                      <label>ISBN</label>
                      <input type="number" class="form-control" name="isbn" value="{{old('isbn')}}" required>
                    </div>
                   
                   
                    <button type="submit" class="btn btn-primary">Guardar</button>
                  </form>
                </div>
            </div>
    </div>
</div>
@endsection
