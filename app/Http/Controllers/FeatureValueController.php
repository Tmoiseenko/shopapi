<?php

namespace App\Http\Controllers;

use App\Category;
use App\Features;
use App\Http\Resources\CategoryResource;
use App\Product;
use App\Value;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeatureValueController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'product_id' => ['required', 'numeric'],
            'feature_id' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return $this->error('Incorrect values entered', 401, ['error' => $validator->errors()]);
        }
        $fields = $request->all();
        $value = new Value();
        $value->name = $fields["name"];
        $product = Product::find($fields["product_id"]);
        $product->featureValue()->save($value);
        $feature = Features::find($fields["feature_id"]);
        $feature->value()->save($value);

        return $this->success([], 'Feature value created');
    }

    public function delete(Value $value)
    {
        $value->delete();
        return $this->success([], 'Feature value deleted');
    }
}
