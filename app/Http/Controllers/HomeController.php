<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Country;
//use App\Models\Transportation;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::with('product')->get();
        return view('home',compact('categories'));
        //return view('home');
        
    }

    public function view($id){
        $product = product::find($id);
        $country = country::find($product['country_id']);
        return view('product.order',compact('product', 'country'));
    }

}
