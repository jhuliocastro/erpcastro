<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class ProductsModel extends Model
{
    use HasFactory;
    protected $collection = 'products';
    protected $guarded = [];

    /**
     * Save new product
     * @param array $product
     * @return mixed
     */
    public static function store(array $product){
        return ProductsModel::create([
            'name'           => $product["name"],
            'unit'           => $product["unit"],
            'price_purchase' => $product["price_purchase"],
            'price_sale'     => $product["price_sale"],
            'inventory'      => $product["inventory"],
            'codebar'        => $product["codebar"]
        ]);
    }

    /**
     * Check if there is a product with the name entered
     * @param string $name
     * @return mixed
     */
    public static function verifyExistByName(string $name){
        return ProductsModel::where('name', $name)->count();
    }

    public static function deleteProduct($id){
        return ProductsModel::where('_id', $id)->delete();
    }

    /**
     * Check if there is a product with the codebar entered
     * @param string $codebar
     * @return mixed
     */
    public static function verifyExistByCodebar(string $codebar){
        return ProductsModel::where('codebar', $codebar)->count();
    }

    /**
     * Return all products
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getProducts(){
        return ProductsModel::all();
    }

    public static function getProductByID($id){
        return ProductsModel::where('_id', $id)->get();
    }

    public static function updateInventory($id, $inventory){
        return ProductsModel::where('_id', $id)->update([
           'inventory' => $inventory
        ]);
    }
}
