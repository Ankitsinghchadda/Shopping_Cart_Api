<?php

namespace App\Http\Controllers;

use App\Models\SQLModel;
use Illuminate\Http\Request;

class SQLController extends Controller
{
    public function index()
    {
        return SQLModel::index();
    }
}
