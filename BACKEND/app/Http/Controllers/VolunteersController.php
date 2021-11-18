<?php

namespace App\Http\Controllers;

use App\Models\Volunteers;
use Illuminate\Http\Request;

class VolunteersController extends Controller
{
    public function index()
    {
        return response()->json(
            volunteers::all()
        );
    }

    public function store(Request $request)
    {
        $mensaje = 'Voluntario guardado exitosamente';
        $dataVolunteers = $request->json()->all();
        //$dataVolunteers = $data['data'];
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = null;
            if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'mp4') {
                $picture   = date('His') . '-' . $filename;
                $path = $file->move('public/', $picture);
            } else {
                $mensaje = 'El voluntario se guardo con exito pero el archivo no es de un formata aceptado por lo tanto no se guradó el archivo';
            }
            $volunteers = new Volunteers();
            $volunteers->name =  $dataVolunteers['name'];
            $volunteers->surname =  $dataVolunteers['surname'];
            $volunteers->CI =  $dataVolunteers['CI'];
            $volunteers->description =  $dataVolunteers['description'];
            $volunteers->address =  $dataVolunteers['address'];
            $volunteers->availability =  $dataVolunteers['availability'];
            $volunteers->phoneNumber =  $dataVolunteers['phoneNumber'];
            $volunteers->image =  $picture;
            $volunteers->state =  $dataVolunteers['state'];
            $volunteers->save();
            return response()->json([
                'message' => $mensaje,
                'res' => true
            ], 201);
        } else {
            $volunteers = new Volunteers();
            
            $volunteers->name =  $dataVolunteers['name'];
            $volunteers->surname =  $dataVolunteers['surname'];
            $volunteers->CI =  $dataVolunteers['CI'];
            $volunteers->description =  $dataVolunteers['description'];
            $volunteers->address =  $dataVolunteers['address'];
            $volunteers->availability =  $dataVolunteers['availability'];
            $volunteers->phoneNumber =  $dataVolunteers['phoneNumber'];
            $volunteers->image =  null;
            $volunteers->state =  $dataVolunteers['state'];
            $volunteers->save();
            return response()->json([
                'message' => $mensaje,
                'res' => true
            ], 201); 
        }
    }

    public function show($id)
    {
        $volunteers = Volunteers::findOrFail($id);
        return response()->json(
            $volunteers
        );
    }

    public function update(Request $request)
    {
        $dataVolunteers = $request->json()->all();
        
        //$dataVolunteers = $data['data'];
        $id = $dataVolunteers['id'];
        $volunteers = Volunteers::findOrFail($id);

        $volunteers->name =  $dataVolunteers['name'];
        $volunteers->surname =  $dataVolunteers['surname'];
        $volunteers->CI =  $dataVolunteers['CI'];
        $volunteers->description =  $dataVolunteers['description'];
        $volunteers->address =  $dataVolunteers['address'];
        $volunteers->availability =  $dataVolunteers['availability'];
        $volunteers->phoneNumber =  $dataVolunteers['phoneNumber'];
        //$volunteers->image =  $dataVolunteers['image'];
        $volunteers->state =  $dataVolunteers['state'];
        $volunteers->save(); 
        return response()->json([
            'message' => 'Voluntario actualizado exitosamente',
            'res' => true
        ], 200);
    }

    public function destroy(volunteers $volunteers, $id)
    {
        $volunteers = volunteers::findOrFail($id);
        $volunteers->delete();
        return response()->json([
            'message' => 'Voluntario eliminado exitosamente',
            'volunteers' => $volunteers
        ], 200);
    }
}
