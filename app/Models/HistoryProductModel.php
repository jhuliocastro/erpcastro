<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class HistoryProductModel extends Model
{
    use HasFactory;
    protected $collection = 'history_inventory';
    protected $guarded = [];

    public static function store($data){
        return HistoryProductModel::create($data);
    }
}
