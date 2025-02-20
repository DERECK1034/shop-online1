<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\marcas;
use Illuminate\Support\Facades\Storage;
use Session;

class shopcontroller extends Controller
{
    public function inicio()
    {
        return view('inicio');
    }

    public function carrito()
    {
        return view('carrito');
    }

    public function compradetalle()
    {
        return view('compradetalle');
    }

    public function listaproductos()
    {
        return view('listaproductos');
    }

    public function login()
    {
        return view('login');
    }
    
    public function micuenta()
    {
        return view('micuenta');
    }

    public function verificar()
    {
        return view('verificar');
    }

    public function listadeseos()
    {
        return view('listadeseos');
    }

    // 🔹 1. Mostrar el catálogo de marcas
    public function catalogarmarcas()
    {
        $marcas = marcas::paginate(6);  // Obtener todas las marcas de la base de datos
        return view('catalogarmarcas', compact('marcas')); // Pasar las marcas a la vista
    }

    // 🔹 2. Guardar una nueva marca en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre_marca' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'archivo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ahora puede ser opcional
        ]);

        $nombreArchivo = null; // Por defecto, no hay imagen

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(public_path('archivos'), $nombreArchivo);
        }

        marcas::create([
            'nombre_marca' => $request->nombre_marca,
            'descripcion' => $request->descripcion,
            'archivo' => $nombreArchivo, // Se guarda como null si no hay imagen
        ]);

        session()->flash('success', 'Marca creada correctamente.');

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_marca' => 'required|string|max:255',
            'descripcion' => 'required|string', // Validación de la descripción
            'archivo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $marca = marcas::findOrFail($id);
        $marca->nombre_marca = $request->nombre_marca;
        $marca->descripcion = $request->descripcion; // Asegúrate de agregar la descripción

        // Si se sube un nuevo archivo, reemplazar el anterior
        if ($request->hasFile('archivo')) {
            // Eliminar la imagen anterior si existe
            if ($marca->archivo && file_exists(public_path('archivos/' . $marca->archivo))) {
                unlink(public_path('archivos/' . $marca->archivo));
            }

            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(public_path('archivos'), $nombreArchivo);

            $marca->archivo = $nombreArchivo; // Guardar el nuevo archivo
        }

        $marca->save();

        session()->flash('success', 'Marca actualizada correctamente.');

        return redirect()->back();
    }

    // 🔹 4. Eliminar una marca
    public function destroy($idma)
    {
        // Buscar la marca a eliminar
        $marca = marcas::findOrFail($idma);

        // Eliminar imagen asociada si existe
        if ($marca->archivo) {
            Storage::disk('public')->delete($marca->archivo); // Usar Storage correctamente
        }

        // Eliminar la marca de la base de datos
        $marca->delete();

        return redirect()->route('catalogarmarcas')->with('success', 'Marca eliminada correctamente.');
    }
}
