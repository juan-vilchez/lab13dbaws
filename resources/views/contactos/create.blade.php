@extends('layouts.app')

@section('content')

<div class="container">




<form class="form-horizontal" action="{{url('/contactos')}}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}

@include('contactos.form',['Modo'=>'crear'])


</form>

</div>

@endsection
