<?php

namespace App\Http\Controllers;

use App\Contactos;
use Illuminate\Http\Request;
//importadion Cloudinary

use JD\Cloudder\Facades\Cloudder;
//use Cloudder;


class ContactosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['contactos']=contactos::paginate(8);
        return view('contactos.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('contactos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

//-001------------------------------agregado para clñoudinary
    public function uploadImages(Request $request)
    {
        $this->validate($request,[
            'image_name'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
        ]);

        $image_name = $request->file('Foto')->getRealPath();;

        Cloudder::upload($image_name, null);

        return redirect()->back()->with('status', 'Image Uploaded Successfully');

    }

//--001---------------------------------------------------------

    public function store(Request $request)
    {
        $datosUsuario=request()->except('_token');
        
 //---------------------- parte de cloudinary
        $this->validate($request,[
            'Foto'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
        ]);

        $image = $request->file('Foto');
        $name = $request->file('Foto')->getClientOriginalName();
        $image_name = $request->file('Foto')->getRealPath();;
        Cloudder::upload($image_name, null);
        list($width, $height) = getimagesize($image_name);
        $image_url= Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height"=>$height]);
        //temporal la de abajo--> obtiene el nombre de la imagen
        $image_name_un= Cloudder::getPublicId();

        //temporal para una consulta de un dato
        //$valoress = contactos::find('Nombre')->where('id','17')->first();
        $valoress = contactos::where('id',5)
        ->firstOr(['Nombre_foto'],function(){});
        
        //save to uploads directory
        $image->move(public_path("uploads"), $name);
                
        //obetner valores individualmente
        $nombre_nuevo = $request->input('Nombre');
        $apellido_nuevo = $request->input('Apellidos');
        $telefono_nuevo = $request->input('telefono');
        $correo_nuevo = $request->input('Correo');
        $direccion_nuevo = $request->input('Direccion');
            //insertar
        contactos::insert([
        'Nombre'  =>$nombre_nuevo ,
        'Apellidos' => $apellido_nuevo,
        'telefono' =>$telefono_nuevo ,
        'Correo' => $correo_nuevo, 
        'Direccion' => $direccion_nuevo, 
        'Foto' => $image_url,
        'Nombre_foto'=>$image_name_un]);

        // anterior        contactos::insert($datosUsuario);

        return redirect('contactos')->with('Mensaje','Contacto agregado exitosamente   ');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function show(Contactos $contactos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        ////
        $usuario= contactos::findOrFail($id);
        return view('contactos.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $datosUsuario=request()->except(['_token','_method']);
        //---------------img
        $this->validate($request,[
            'Foto'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
        ]);
        $image = $request->file('Foto');
        $name = $request->file('Foto')->getClientOriginalName();
        $image_name = $request->file('Foto')->getRealPath();;
        Cloudder::upload($image_name, null);
        list($width, $height) = getimagesize($image_name);
        $image_url= Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height"=>$height]);
        $image_name_un= Cloudder::getPublicId();
        $image->move(public_path("uploads"), $name);    
        $nombre_nuevo = $request->input('Nombre');
        $apellido_nuevo = $request->input('Apellidos');
        $telefono_nuevo = $request->input('telefono');
        $correo_nuevo = $request->input('Correo');
        $direccion_nuevo = $request->input('Direccion');

        //elimina el dato de cloudinary--------------------------
        $valoress = contactos::where('id',$id)
        ->firstOr(['Nombre_foto'],function(){});
        //da formato
        $nombre_foto =$valoress->Nombre_foto;
        Cloudder::destroyImages($nombre_foto);
        //elimina----------------------------------------------

        contactos::where('id','=',$id)->update([
        'Nombre'  =>$nombre_nuevo ,
        'Apellidos' => $apellido_nuevo,
        'telefono' =>$telefono_nuevo ,
        'Correo' => $correo_nuevo, 
        'Direccion' => $direccion_nuevo, 
        'Foto' => $image_url,
        'Nombre_foto'=>$image_name_un]);

        $usuario= contactos::findOrFail($id);

        //return view('contactos.edit', compact('usuario'));
        return redirect('contactos')->with('Mensaje','Modificación realizada con éxito');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
    //recoge el valor de imagen
    $valoress = contactos::where('id',$id)
    ->firstOr(['Nombre_foto'],function(){});
    //da formato
    $nombre_foto =$valoress->Nombre_foto;
    //eliminacloud
    Cloudder::destroyImages($nombre_foto);

    //elimina DB
    contactos::destroy($id);

    return redirect('contactos')->with('Mensaje','Contacto Eliminado con éxito  ');

    }
}
