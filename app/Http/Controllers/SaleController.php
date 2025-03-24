<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function SalePage(Request $request){
        $user_id = $request->header('id');
        $customers = Customer::where('user_id', $user_id)->get();
        $products = Product::where('user_id', $user_id)->get();
        return Inertia::render('SalePage',['products'=> $products,'customers'=> $customers]);
    }
}
