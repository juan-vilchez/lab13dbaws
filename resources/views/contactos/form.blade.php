<div class="form-group">
<label class="control-label" for="Nombre">{{'Nombre'}}</label>
<input class="form-control" type="text" name="Nombre" id="Nombre" 
value="{{isset($usuario->Nombre)?$usuario->Nombre:''}}">
</div>

<div class="form-group">
<label class="control-label" for="Apellidos">{{'Apellidos'}}</label>
<input class="form-control" type="text" name="Apellidos" id="Apellidos"
value="{{isset($usuario->Apellidos)?$usuario->Apellidos:''}}">
</div>


<div class="form-group">
<label class="control-label" for="telefono">{{'telefono'}}</label>
<input class="form-control" type="number" name="telefono" id="telefono"
value="{{isset($usuario->telefono)?$usuario->telefono:''}}">
</div>


<div class="form-group">
<label class="control-label" for="Correo">{{'Correo'}}</label>
<input class="form-control" type="text" name="Correo" id="Correo"
value="{{isset($usuario->Correo)?$usuario->Correo:''}}">
</div>


<div class="form-group">
<label class="control-label" for="Direccion">{{'Direccion'}}</label>
<input class="form-control" type="text" name="Direccion" id="Direccion"
value="{{isset($usuario->Direccion)?$usuario->Direccion:''}}">
</div>


<div class="form-group">
<label class="control-label" for="Foto">{{'Foto'}}</label>
<input class="form-control" type="file" name="Foto" id="Foto"
value="{{isset($usuario->Foto)?$usuario->Foto:''}}">
</div>

<input class="btn btn-primary" type="submit" value="{{$Modo=='crear' ? 'Agregar':'Modificar'}}">

<a class="btn btn-success" href="{{url('contactos')}}">Regresar</a>