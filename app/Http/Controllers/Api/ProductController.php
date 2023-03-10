<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Traits\Api\ApiResponseTrait;
use App\Models\Product;
use App\Models\ProductTranslation;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with(['store','storeOwner'])->paginate(10);

        return $this->apiResponse(
            ProductResource::collection($products)->response()->getData(true),
            'ok',
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try{
            $product_data = [
                'price' => $request->price,
                'store_id' => $request->store_id,
                'is_included_vat' => $request->is_included_vat,
                $request->locale  => [
                    'name'        => $request->name,
                    'description' => $request->description
                ],
             ];
            $product = Product::create($product_data);
        } catch(\Exception $e){
            return $this->apiResponse(null,'the Product not save',Response::HTTP_BAD_REQUEST);
        }
        return $this->apiResponse(new ProductResource($product->load(['store','storeOwner'])),'Product saved',Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if($product)
        {
            return $this->apiResponse(new ProductResource($product->load(['store','storeOwner'])),'ok',Response::HTTP_OK);
        }
        
        return $this->apiResponse(null,'this Product not found',Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        ProductTranslation::where('locale',$request->locale)->where('product_id',$id)->delete();
        try{
            $product_data = [
                'price' => $request->price,
                'store_id' => $request->store_id,
                'is_included_vat' => $request->is_included_vat,
                $request->locale  => [
                    'name'        => $request->name,
                    'description' => $request->description
                ],
             ];
            $product->update($product_data);
        } catch(\Exception $e){
            return $this->apiResponse(null,'the Product not update',Response::HTTP_BAD_REQUEST);
        }
        return $this->apiResponse(new ProductResource($product),'Product updated',Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return $this->apiResponse(null,'the Product deleted',Response::HTTP_OK);
    }
}
