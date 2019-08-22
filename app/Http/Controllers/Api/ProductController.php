<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\API;
use App\Stock;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private $product;

    public function __construct(Product $product){

        $this->product = $product;

    }


    //Retorna todos os produtos
    public function index()
    {	

        $data = DB::table('Products')
                    ->leftjoin('stocks', 'products.product_id', '=', 'stocks.product_id')
                    ->select('products.product_id',
                             'products.name',
                             'products.industry',
                             'products.price',
                             'stocks.amount',
                             'products.created_at',
                             'products.updated_at')->paginate();


        return response()->json($data,200,array('Content-Type' => 'application/json;charset=utf8')
        						,JSON_UNESCAPED_UNICODE);
    
    }

    //Adiciona um novo produto
    public function CreateProduct(Request $request)
    {   
        try{

            $productData = $request->all();

            //Verifica se passaram alguma quantidade para o estoque
            $amount = isset($productData['amount']) ? $productData['amount'] : 0;
            $newProduct = $this->product->Create($productData);
            
            //inclui estoque do produto criado
            $stock = new Stock;
            $stock->product_id = $newProduct->id;
            $stock->amount     = $amount;
            $stock->Save();
            $data = ['data' => ['msg'=> 'Produto inserido com sucesso!']];


            return response()->json($data,201);

        }catch(\Exception $e){
            
            if(config('app.debug')){
                return response()->json(API\ApiError::errorMessage($e->getMessage(),1010));
            }

            return response()->json(API\ApiError::errorMessage('Houve um erro na inserção dos dados',1010));

        }

    }

    public function UpdateProduct(Request $request,$id)
    {   
        try{
            
            $productData = $request->all();

            //Verifica se o produto existe através do ID
            $product= $this->product->where('product_id',$id)->first();

            if(isset($productData['amount']) and isset($product))
            {   
                //Tira o valor de estoque do array
                $amount = $productData['amount'];
                unset($productData['amount']);
                
                //Atualiza o produto
                $product = $this->product->where('product_id',$id);
                $product->Update($productData);
                
                //Atualiza o estoque
                $stock = DB::table('stocks')
                            ->where('product_id','=',$id)
                            ->update(['amount' => $amount]);

                $data = ['data' => ['msg'=> 'Produto atualizado com sucesso!']];

            }elseif(isset($product)){

                $product     = $this->product->where('product_id',$id);
                $product->Update($productData);
                $data = ['data' => ['msg'=> 'Produto atualizado com sucesso!']];

            }else{
                 return response()->json(['data' => ['msg' => 'Produto ID '.$id.' nao encontrado!']],404,
                                        array('Content-Type' => 'application/json;charset=utf8'),JSON_UNESCAPED_UNICODE);
            }
            return response()->json($data,201);

        }catch(\Exception $e){
            
            if(config('app.debug')){
                return response()->json(API\ApiError::errorMessage($e->getMessage(),1010));
            }

            return response()->json(API\ApiError::errorMessage('Houve um erro na atualização dos dados',1010),422);

        }

    }

    public function DeleteProduct($id)
    {   
        try{
  
            $product= $this->product->where('product_id',$id)->first();

            if(!$product)
            {
                return response()->json(['data' => ['msg' => 'Produto ID '.$id.' nao encontrado!']],404,
                                         array('Content-Type' => 'application/json;charset=utf8'),JSON_UNESCAPED_UNICODE);

            }

            $product = $this->product->where('product_id',$id);
            $product->Delete();
            
            $data = ['data' => ['msg'=> 'Produto removido com sucesso!']]; 
            return response()->json($data,200);

        }catch(\Exception $e){
            
            if(config('app.debug')){
                return response()->json(API\ApiError::errorMessage($e->getMessage(),1010));
            }

            return response()->json(API\ApiError::errorMessage('Houve um erro na exclusão dos dados'),1010);

        }

    }

    public function searchId($id)
    {
        $product = DB::table('Products')
                        ->leftjoin('stocks', 'products.product_id', '=', 'stocks.product_id')
                        ->where('products.product_id','=',$id)
                        ->select('products.product_id',
                                 'products.name',
                                 'products.industry',
                                 'products.price',
                                 'stocks.amount',
                                 'products.created_at',
                                 'products.updated_at')->first();

        if (!$product) return response()->json(['data' => ['msg' => 'Produto não encontrado!']],
        					  404,array('Content-Type' => 'application/json;charset=utf8'),JSON_UNESCAPED_UNICODE);
        
        $data = ['data' => $product];
        return response()->json($data);

    }

    public function searchDescription($text)
    {
        $product = DB::table('Products')
                        ->leftjoin('stocks', 'products.product_id', '=', 'stocks.product_id')
                        ->Where('products.name','like','%'.$text.'%')
                        ->orWhere('products.industry','like','%'.$text.'%')
                        ->select('products.product_id',
                                 'products.name',
                                 'products.industry',
                                 'products.price',
                                 'stocks.amount',
                                 'products.created_at',
                                 'products.updated_at')->paginate();
        
        if ($product->total() == 0) return response()->json(['data' => ['msg' => 'Produto não encontrado!']],
                              404,array('Content-Type' => 'application/json;charset=utf8'),JSON_UNESCAPED_UNICODE);
        
        return response()->json($product);

    }
}
