<?php

namespace App\Http\Controllers;

use App\Features;
use App\Http\Resources\FeatureResource;
use App\Http\Resources\FeaturesResource;
use App\Traits\ApiResponser;
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
        return new FeaturesResource(Features::all());
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

        $features = Features::firstOrCreate($validator->getData());

        FeaturesResource::withoutWrapping();
        return new FeatureResource($features);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Features  $features
     * @return \Illuminate\Http\Response
     */
    public function show(Features $feature)
    {
        FeaturesResource::withoutWrapping();
        return new FeatureResource($feature);
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
    public function update(Request $request, Features $feature)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return $this->error('Incorrect values entered', 401, ['error' => $validator->errors()]);
        }

        $feature->name = $request->name;
        $feature->save();

        FeaturesResource::withoutWrapping();
        return new FeatureResource($feature);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Features  $features
     * @return \Illuminate\Http\Response
     */
    public function destroy(Features $feature)
    {
        $feature->delete();
        return $this->success([], 'Feature was deleted');
    }
}
