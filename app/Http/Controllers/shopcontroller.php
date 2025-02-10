<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\marcas;
use Illuminate\Support\Facades\Storage;


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
            'descripcion' => 'required|string|max:255',
            'archivo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Subir la imagen si existe
        $rutaImagen = null;
        if ($request->hasFile('archivo')) {
            $rutaImagen = $request->file('archivo')->store('marcas', 'public');
        }

        // Crear nueva marca
        marcas::create([
            'nombre_marca' => $request->nombre_marca,
            'descripcion' => $request->descripcion,
            'archivo' => $rutaImagen
        ]);

        return redirect()->route('catalogarmarcas')->with('success', 'Marca agregada correctamente.');
    }

    // 🔹 3. Editar una marca existente
    public function update(Request $request, $idma)
    {
        // Buscar la marca a editar
        $marca = marcas::findOrFail($idma);

        $request->validate([
            'nombre_marca' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'archivo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Subir nueva imagen si se ha seleccionado una
        if ($request->hasFile('archivo')) {
            // Eliminar imagen anterior si existe
            if ($marca->archivo) {
                Storage::disk('public')->delete($marca->archivo); // Usar Storage correctamente
            }

            // Guardar nueva imagen
            $marca->archivo = $request->file('archivo')->store('marcas', 'public');
        }

        // Actualizar los demás datos de la marca
        $marca->nombre_marca = $request->nombre_marca;
        $marca->descripcion = $request->descripcion;

        // Guardar los cambios en la base de datos
        $marca->save();

        return redirect()->route('catalogarmarcas')->with('success', 'Marca actualizada correctamente.');
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
