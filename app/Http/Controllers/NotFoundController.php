<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class NotFoundController extends Controller
{
    public function index(){
    	abort(404);
    }
}
