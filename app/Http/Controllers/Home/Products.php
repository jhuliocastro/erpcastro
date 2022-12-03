<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\HistoryProductModel;
use App\Models\ProductsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Products extends Controller
{
    /**
     * Visualization of products
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        return view('Home.Products.index');
    }

    public function table(){
        $list = ProductsModel::getProducts();
        $table["data"] = [];
        foreach($list as $product){
            $action = "
                <span class='action-table' onclick=\"addInventory('$product->id')\"><i class='fa-solid fa-cart-plus'></i></span>
                <span class='action-table' onclick=\"deleteProduct('$product->id')\"><i class='fa-solid fa-trash'></i></span>
            ";

            $table["data"][] = [
                $product->codebar,
                $product->name,
                $product->price_purchase,
                $product->price_sale,
                $product->inventory,
                $product->unit,
                $action
            ];
        }

        return json_encode($table);
    }

    public function inventoryAdd(Request $request){
        $product = ProductsModel::getProductByID($request->id_product);
        $amountNew = $product[0]->inventory + $request->amount;
        $return = ProductsModel::updateAmount($request->id_product, $amountNew);
        if($return){
            $data = [
                'product' => $request->id_product,
                'amount' => $request->amount,
                'action' => 'add',
                'user' => Auth::user()->id
            ];
            $return = HistoryProductModel::store($data);
            if($return){
                return json_encode([
                    'status' => true
                ]);
            }else{
                return json_encode([
                    'status' => false,
                    'message' => 'Erro ao registrar histórico de estoque'
                ]);
            }
        }else{
            return json_encode([
                'status' => false,
                'message' => 'Erro ao alterar estoque'
            ]);
        }
    }

    public function delete(Request $request){
        $return = ProductsModel::deleteProduct($request->product);
        if($return){
            return json_encode([
                'status' => true,
            ]);
        }else{
            return json_encode([
                'status' => false,
                'message' => 'Erro ao deletar produto'
            ]);
        }
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
