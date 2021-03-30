<?php

namespace App\Http\Controllers;

use App\Features;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return $this->error('Incorrect values entered', 401, ['error' => $validator->errors()]);
        }

        $category = Features::firstOrCreate($validator->getData());

        FeaturesResource::withoutWrapping();
        return new FeaturesResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Features  $features
     * @return \Illuminate\Http\Response
     */
    public function show(Features $features)
    {
        FeaturesResource::withoutWrapping();
        return new FeaturesResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Features  $features
     * @return \Illuminate\Http\Response
     */
    public function edit(Features $features)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Features  $features
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Features $features)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return $this->error('Incorrect values entered', 401, ['error' => $validator->errors()]);
        }

        $features = Features::find($features);
        $features->update($validator->getData());
        $features->save();

        FeaturesResource::withoutWrapping();
        return new FeaturesResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Features  $features
     * @return \Illuminate\Http\Response
     */
    public function destroy(Features $features)
    {
        $features = Features::find($features);
        $features->delete();
        return $this->success([
            'messege' => 'Category was deleted'
        ]);
    }
}
