<?php

namespace App\Http\Controllers;

use App\Models\Kardex;
use App\Models\Producto;
use App\Models\Stock;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class KardexController extends Controller
{
    //
    public function getViewKardex()
    {

        $productos = DB::select("call getProductos()");

        $data = DB::select("call getKardex()");


        return view('kardex', compact('data', 'productos'));
    }

    public function aggKardex(Request $request)
    {
        $request->validate([
            'fecha' => 'required',
            'num_factura' => 'required',
            'id_productos' => 'required',
            'tipoOperacion' => 'required',
            'cantidad' => 'required',
        ]);

        $kardex = new Kardex();
        $kardex->id_productos = $request->id_productos;
        $kardex->fecha = $request->fecha;
        $kardex->num_factura = $request->num_factura;
        $kardex->tipo_operacion = $request->tipoOperacion;
        $kardex->cantidad = $request->cantidad;

        if ($request->tipoOperacion == "compra") {
            $kardex->valor_unitario = $request->valorUnitario;
            $kardex->valor_total = floatval($request->cantidad) * floatval($request->valorUnitario);
            $kardex->save();

            $id_stock = Stock::where('id_productos', $request->id_productos)->select('id_stock')->first();

            $stock = Stock::find($id_stock->id_stock);
            $stock->valor_unitario = (($stock->valor_unitario * $stock->cantidad) + ($request->valorUnitario * $request->cantidad)) / ($request->cantidad + $stock->cantidad);
            $stock->cantidad += $request->cantidad;
            $stock->save();
        } else {
            //Si no tiene precio, buscamos las cantidades en el stock con su valor unitario
            $id_stock = Stock::where('id_productos', $request->id_productos)->select('id_stock')->first();

            $stock = Stock::find($id_stock->id_stock);

            $kardex->valor_unitario = $stock->valor_unitario;
            $kardex->valor_total = floatval($stock->valor_unitario) * floatval($request->cantidad);
            $kardex->save();

            $stock->cantidad -= $request->cantidad;
            $stock->save();
        }


        return redirect()->route('kardex.getViewKardex');
    }
}
