<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SQLModel extends Model
{
    protected $connection = 'mysql';


    public static function index()
    {
        return DB::table('clients')
            ->join('payments', 'payments.client_id', 'clients.client_id')
            ->join('payment_methods', 'payment_methods.payment_method_id', 'payments.payment_method')
            ->select('clients.client_id', 'payment_methods.name')
            ->groupBy('client_id', 'name')
            ->get();
    }
}
