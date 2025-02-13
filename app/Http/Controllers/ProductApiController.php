<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index()
    {
        try {
            $products = Product::all();
    
            if ($products->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'No products found.',
                    'data' => []
                ], 200);
            }
    
            return response()->json([
                'success' => true,
                'data' => $products
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving products.',
                'error' => $e->getMessage() 
            ], 500);
        }
 
    }

    public function show($id){
        try{
            $product = Product::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $product
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the product.',
                'error' => $e->getMessage() 
            ], 500);
        }
    }

    public function store(Request $request){
        try{
            $product = Product::create($request->all());
            return response()->json([
                'success' => true,
                'data' => $product
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the product.',
                'error' => $e->getMessage() 
            ], 500);
        }
    }

    public function delete($id){
        try{
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.'
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the product.',
                'error' => $e->getMessage() 
            ], 500);
        }
    }
}