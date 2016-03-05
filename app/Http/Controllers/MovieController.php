<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MovieController extends Controller
{
    public function index(){
    	echo 'estoy en index';
    }

    public function create(){
    	echo 'estoy en create';
    }

    public function store($id){
    	echo 'estoy en index';
    }

    public function show($id){
    	echo 'estoy en show';
    }

    public function edit($id){
    	echo 'estoy en edit';
    }

    public function update($id){
    	echo 'estoy en update';
    }

    public function delete($id){
    	echo 'estoy en index';
    }
}
