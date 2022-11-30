<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\ProductsModel;
use Illuminate\Http\Request;

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
                <span class='action-table' onclick=\"editProduct('$product->id')\"><i class='fa-solid fa-edit'></i></span>
                <span class='action-table' onclick=\"addInventory('$product->id', '$product->name')\"><i class='fa-solid fa-cart-plus'></i></span>
                <span class='action-table' onclick=\"removeInventory('$product->id', '$product->name')\"><i class='fa-solid fa-cart-arrow-down'></i></span>
                <span class='action-table' onclick=\"deleteProduct('$product->id')\"><i class='fa-solid fa-trash'></i></span>
            ";

            $table["data"][] = [
                $product->codebar,
                $product->name,
                "R$ ".number_format($product->price_purchase, 2, ',', '.'),
                "R$ ".number_format($product->price_sale, 2, ',', '.'),
                $product->inventory,
                $product->unit,
                $action
            ];
        }

        return json_encode($table);
    }

    public function dataByID(Request $request){
        $data = ProductsModel::getProductByID($request->id);
        $data[0]->price_purchase = number_format($data[0]->price_purchase, '2', ',', '.');
        $data[0]->price_sale = number_format($data[0]->price_sale, '2', ',', '.');
        return json_encode($data[0]);
    }

    public function addInventory(Request $request){
        $inventoryNow = ProductsModel::getProductByID($request->id);
        $newInventory = $inventoryNow[0]->inventory + $request->amount;
        $return = ProductsModel::updateInventory($request->id, $newInventory);
        if($return){
            return json_encode([
                'status' => true,
            ]);
        }else{
            return json_encode([
                'status' => false,
                'message' => 'Erro ao alterar estoque'
            ]);
        }
    }

    public function removeInventory(Request $request){
        $inventoryNow = ProductsModel::getProductByID($request->id);
        $newInventory = $inventoryNow[0]->inventory - $request->amount;
        if($newInventory < 0){
            return json_encode([
                'status' => false,
                'message' => 'Estoque não pode ficar abaixo de 0'
            ]);
        }else{
            $return = ProductsModel::updateInventory($request->id, $newInventory);
            if($return){
                return json_encode([
                    'status' => true,
                ]);
            }else{
                return json_encode([
                    'status' => false,
                    'message' => 'Erro ao alterar estoque'
                ]);
            }
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
