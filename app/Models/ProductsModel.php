<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class ProductsModel extends Model
{
    use HasFactory;
    protected $collection = 'products';
    protected $guarded = [];

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

    public static function verifyExistByName(string $name){
        return ProductsModel::where('name', $name)->count();
    }

    public static function verifyExistByCodebar(string $codebar){
        return ProductsModel::where('codebar', $codebar)->count();
    }
}
