<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product_SQL extends Model
{
    protected $connection = 'mysql';
    //

    protected $fillable = [
        'title', 'price',  'description'
    ];

    public function m_insert($data)
    {
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        return DB::table('products')->insert($data);
    }

    public function m_getData()
    {
        return DB::table('products')->get();
    }
}
