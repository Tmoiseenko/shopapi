<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsResource;
use App\Product;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::all();

        if ($request->query()) {
            $validator = Validator::make($request->all(), [
                'category' => ['string', 'max:255'],
                'price' => ['numeric'],
                'feature' => ['string']
            ]);
            if ($validator->fails()) {
                return $this->error('Incorrect values entered', 401, ['error' => $validator->errors()]);
            }
            if ($request->filled('category_name')) {
                $products = $products->where('category.name', '=', $request->get('category_name'));
            }
            if ($request->filled('category_id')) {
                $products = $products->where('category_id', '=', $request->get('category_id'));
            }
            if ($request->filled('price')) {
                $products = $products->where('price', '=', $request->get('price'));
            }
        }
        return new ProductsResource($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        ProductResource::withoutWrapping();
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return $this->error('Incorrect values entered', 401, ['error' => $validator->errors()]);
        }
        $fields = $request->all();
        $fields['slug'] = Str::slug($request->name);
        $product->update($fields);

        ProductResource::withoutWrapping();
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->success([], 'Product was deleted');
    }

    public function getBySlug($slug)
    {
        $product = Product::where('slug', '=', $slug)->first();
        ProductResource::withoutWrapping();
        return new ProductResource($product);
    }
}
