<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\ProductsModel;
use Illuminate\Http\Request;

class Products extends Controller
{
    public function index(){
        return view('Home.Products.index');
    }

    public function store(Request $request){
        $product = [
            'name'           => (string)$request->input('name'),
            'unit'           => (string)$request->input('unit'),
            'price_purchase' => (float)str_replace(',', '.', $request->input('price_purchase')),
            'price_sale'     => (float)str_replace(',', '.', $request->input('price_sale')),
            'inventory'      => (int)$request->input('inventory'),
            'codebar'        => (string)$request->input('codebar'),
        ];

        $existName = ProductsModel::verifyExistByName($product["name"]);

        if($existName > 0){
            return json_encode([
                'status' => false,
                'message' => 'Nome do produto já existe'
            ]);
        }else{
            $existCodebar = ProductsModel::verifyExistByCodebar($product["codebar"]);
            if($existCodebar > 0){
                return json_encode([
                    'status' => false,
                    'message' => 'Código de barras já existe'
                ]);
            }else{
                $add = ProductsModel::store($product);
                if($add){
                    return json_encode([
                        'status' => true
                    ]);
                }else{
                    return json_encode([
                        'status' => false,
                        'message' => 'Erro ao cadastrar produto'
                    ]);
                }
            }
        }
    }
}
