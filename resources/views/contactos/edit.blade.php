@extends('layouts.app')

@section('content')

<div class="container">
<form action="{{url('/contactos/' . $usuario->id)}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    {{method_field('PATCH')}}
    
    @include('contactos.form',['Modo'=>'editar'])

</form>
</div>

@endsection
