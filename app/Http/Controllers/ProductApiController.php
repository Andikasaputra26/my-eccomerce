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
}