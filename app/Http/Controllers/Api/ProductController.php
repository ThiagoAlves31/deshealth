<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{
    private $product;

    public function __construct(Product $product){

        $this->product = $product;

    }

    
    public function index()
    {	

        $data = ['data' => $this->product->all()];
        return response()->json($data);
    
    }

    public function store($id)
    {
        $product = $this->product->where('id',$id)->first();

        if (!$product) return response()->json(['data' => ['msg' => 'Produto não encontrado!']],404,array('Content-Type' => 'application/json;charset=utf8'),JSON_UNESCAPED_UNICODE);
        $data = ['data' => $product];
        return response()->json($data);

    }
}
