<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Variant;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $vari = ProductVariant::all();
        
        $products = DB::table('Products')
        
        ->join('product_variant_prices', 'product_variant_prices.product_id', '=', 'Products.id')
        ->join('product_variants', 'product_variants.product_id', '=', 'Products.id')
        ->select('products.*', 'product_variants.*', 'product_variant_prices.*')
        ->when($request->date!=null,function($q) use ($request){
            return $q->whereDate('products.created_at',$request->date);
        })
            ->when($request->title!= null, function ($q) use ($request) {
                return $q->where('products.title', $request->title);
            })
        ->when($request->variant != null, function ($q) use ($request) {
            return $q->where('product_variants.variant', $request->variant);
        })
        ->when($request->price_from, function ($query) use ($request) {
            return $query->where('price', '>=', $request->price_from);
        })
        ->when($request->price_to, function ($query) use ($request) {
            return $query->where('price', '<=', $request->price_to);
            })
            
       ->paginate(10);
        return view('products.index', compact('products','vari','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
      
        $variants = Variant::all();
        return view('products.create', compact('variants'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $timestamp =Carbon::now();

        
        Product::insert([
            'title'=>$request->product_name,
            'sku'=>$request->product_sku,
            'description'=>$request->product_description,
            'created_at'=>$timestamp,
            
        ]);


        return redirect()->route('sendData');
    }



    public function show()
    {
       
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->title = $request->input('title');
        $product->sku = $request->input('sku');
        $product->description = $request->input('description');
        $product->save();
        return redirect('/product')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
