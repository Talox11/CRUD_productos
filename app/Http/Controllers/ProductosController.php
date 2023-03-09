<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $productos = Productos::toBase()->get();
        return response()->json($productos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->validate($request,[
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',
            'stock' => 'required',
        ]);
        DB::beginTransaction();
        try{
            $producto = Productos::create([
                'nombre' => $request['nombre'],
                'descripcion' => $request['descripcion'],
                'precio' => $request['precio'],
                'stock' => $request['stock']
            ]);
            DB::commit();
            return response()->json([$producto,'producto guardado',200]);
        }catch(\Exception $e){
            throw $e;
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function show($id_producto)
    {
        //
        $producto = Productos::toBase()->where('id', $id_producto)->first();
        return response()->json($producto);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id_producto)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_producto)
    {
        //

        
        $this->validate($request,[
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',
            'stock' => 'required',
        ]);
        DB::beginTransaction();
        try{
            DB::table('productos')
                ->where('id', $id_producto)
                ->update([
                    'nombre' => $request['nombre'],
                    'descripcion' => $request['descripcion'],
                    'precio' => $request['precio'],
                    'stock' => $request['stock']
                ]);
            DB::commit();
            return response()->json(['producto actualizado',201]);
        }catch(\Exception $e){
            throw $e;
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id_producto)
    {
        //
        DB::beginTransaction();
        try{
            DB::table('productos')
                ->where('id', $id_producto)
                ->delete();
            DB::commit();
            return response()->json(['producto eliminado',201]);
        }catch(\Exception $e){
            throw $e;
            DB::rollBack();
        }

    }
}
