<?php

namespace App\Http\Controllers\Lists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lists\ListDepartment;

class ListDepartmentController extends Controller
{
    public function all()
    {
        return ListDepartment::get();
    }
}
