<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Categoria_Producto;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    //
    public function getViewProducto()
    {
        $categoria = new Categoria();
        $proveedor = new Proveedor();

        $data = DB::select("call getProductos()");

        $categorias = $categoria->all();

        $proveedores = $proveedor->all();

        return view('productos', compact('data', 'categorias', 'proveedores'));
    }

    public function aggProducto(Request $request)
    {
        $request->validate([
            'proveedor' => 'required',
            'nombre' => 'required',
            'categoria' => 'required'
        ]);

        $producto = new Producto();
        $producto->id_proveedores = $request->proveedor;
        $producto->nombre = $request->nombre;
        $producto->save();

        $categoria_productos = new Categoria_Producto();
        $categoria_productos->id_productos = $producto->id_productos;
        $categoria_productos->id_categoria = $request->categoria;
        $categoria_productos->save();

        //agregamos nuevo producto al stock con cantidad 0
        $stock = new Stock();
        $stock->id_productos = $producto->id_productos;
        $stock->cantidad = 0;
        $stock->valor_unitario = 0;
        $stock->save();

        return redirect()->route('producto.getViewProduct');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'idProductoEliminar' => 'required',
        ]);

        $id_categoria_productos = Categoria_Producto::where('id_productos', $request->idProductoEliminar)->select('id_categoria_productos')->get();
        $id_stock = Stock::where('id_productos', $request->idProductoEliminar)->select('id_stock')->get();



        $categoria_productos = Categoria_Producto::find($id_categoria_productos);
        $categoria_productos->each->delete();

        $stock = Stock::find($id_stock);
        $stock->each->delete();

        $producto = Producto::find($request->idProductoEliminar);
        $producto->delete();



        return redirect()->route('producto.getViewProduct');
    }

    public function update(Request $request)
    {

        $request->validate([
            'idProductoEditar' => 'required',
            'proveedor' => 'required',
            'categoria' => 'required',
            'nombre' => 'required',
        ]);

        $id_categoria_productos = Categoria_Producto::where('id_productos', $request->idProductoEditar)->select('id_categoria_productos')->get();

        $categoria_productos = new Categoria_Producto();
        $categoria_productos->find($id_categoria_productos);
        $categoria_productos->id_productos = $request->idProductoEditar;
        $categoria_productos->id_categoria = $request->categoria;

        $id_categoria_productos->each->delete();
        $categoria_productos->save();

        $producto = Producto::find($request->idProductoEditar);
        $producto->nombre = $request->nombre;
        $producto->id_proveedores = $request->proveedor;
        $producto->save();

        return redirect()->route('producto.getViewProduct');
    }
}
