@extends('layouts.app')

@section('content')

<div class="container">



@if(Session::has('Mensaje'))

<div class="alert alert-primary" role="alert">
{{
    Session::get('Mensaje')
}}
</div>


@endif

<a href="{{url('contactos/create')}}" class="btn btn-primary">Agregar contacto</a>
</br></br>
<table class="table table-light table-hover">

    <thead class="thead-light">
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Teléfono</th>
        <th>Correo</th>
        <th>Dirección</th>
        
        <th>Foto</th>
        
        <th>Opciones</th>
    </tr>
    </thead>

    <tbody>
    @foreach($contactos as $contacto)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$contacto->Nombre}}</td>
            <td>{{$contacto->Apellidos}}</td>
            <td>{{$contacto->telefono}}</td>
            <td>{{$contacto->Correo}}</td>
            <td>{{$contacto->Direccion}}</td>
            
            <td>
            <img src="{{$contacto->Foto}}" alt="" width="200" height="200" >
            
            </td>
            
            <td>
            <a class="btn btn-warning" href="{{url('/contactos/'.$contacto->id.'/edit')}}">
                Editar
            </a>
            <form method="post" action="{{ url('/contactos/'.$contacto->id) }}" style="display:inline">
                {{csrf_field() }}
                {{method_field('DELETE') }}
                <button class="btn btn-danger" type="submit" onclick="return confirm('¿Borrar?');">Borrar</button>
            </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{$contactos->links()}}
</div>

@endsection
