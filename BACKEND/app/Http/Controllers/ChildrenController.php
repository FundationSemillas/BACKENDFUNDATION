<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\User;
use App\Models\Zones;
use Illuminate\Http\Request;

class ChildrenController extends Controller
{
    public function index()
    {
        return response()->json(
            children::all()
        );
    }

    public function store(Request $request)
    {
        $mensaje = 'Niño guardado exitosamente';
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = null;
            if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'mp4') {
                $picture   = date('His') . '-' . $filename;
                $path = $file->move('public/', $picture);
            } else {
                $mensaje = 'El niño se guardo exitosamente pero el archivo no es de un formato adecuado por lo que no se guardo el archivo';
            }
            $childdata = json_decode($request->data, true);
            //$user = User::find($childdata['user_id']);
            $child = new Children();
            $child->name = $childdata['name'];
            $child->surname = $childdata['surname'];
            $child->dateBirth = $childdata['dateBirth'];
            $child->CI = $childdata['CI'];
            $child->mothersName = $childdata['mothersName'];
            $child->fathersName = $childdata['fathersName'];
            $child->study = $childdata['study'];
            $child->houseAddress = $childdata['houseAddress'];
            $child->schoolName = $childdata['schoolName'];
            $child->image = $picture;
            //$child->state = $childdata['state'];
            //$child->user()->associate($user);
            $child->save();

            return response()->json([
                'message' => $mensaje,
                'res' => true,
            ], 201);
        } else {
            $childdata = json_decode($request->data, true);

            $child = new Children();
            $child->name = $childdata['name'];
            $child->surname = $childdata['surname'];
            $child->dateBirth = $childdata['dateBirth'];
            $child->CI = $childdata['CI'];
            $child->mothersName = $childdata['mothersName'];
            $child->fathersName = $childdata['fathersName'];
            $child->study = $childdata['study'];
            $child->houseAddress = $childdata['houseAddress'];
            $child->schoolName = $childdata['schoolName'];
            $child->image = null;
            $child->state = $childdata['state'];
            $child->save();

            return response()->json([
                'message' => $mensaje,
                'res' => true
            ], 201);
        }
    }

    public function show($id)
    {
        $children = children::findOrFail($id);
        return response()->json(
            $children
        );
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $children = children::findOrFail($id);
        $mensaje = 'Niño actualizado exitosamente';
        $children->name = $request->input('name');
        $children->surname = $request->input('surname');
        $children->dateBirth = $request->input('dateBirth');
        $children->CI = $request->input('CI');
        $children->mothersName = $request->input('mothersName');
        $children->fathersName = $request->input('fathersName');
        $children->study = $request->input('study');
        $children->houseAddress = $request->input('houseAddress');
        $children->schoolName = $request->input('schoolName');

        $children->save();
        return response()->json(
            [
                'message' => $mensaje,
                'res' => true,
            ]
        );
    }

    public function destroy(children $children, $id)
    {
        $children = children::findOrFail($id);
        $children->delete();
        return response()->json(['message' => 'Niño eliminado', 'Niño' => $children], 200);
    }
}
