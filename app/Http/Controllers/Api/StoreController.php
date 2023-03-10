<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Http\Resources\StoreResource;
use App\Http\Traits\Api\ApiResponseTrait;
use App\Models\Store;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::paginate(10);

        return $this->apiResponse(
            StoreResource::collection($stores)->response()->getData(true),
            'ok',
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        try{
            $store = Store::create([
                'name' => $request->name,
                'VAT' => $request->VAT ?? 0,
                'shipping_cost' => $request->shipping_cost ?? 0,
                'user_id' => auth()->user()->id,
            ]);
        } catch(\Exception $e){
            return $this->apiResponse(null,'the store not save',Response::HTTP_BAD_REQUEST);
        }
        return $this->apiResponse(new StoreResource($store),'store saved',Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $store = Store::find($id);

        if($store)
        {
            return $this->apiResponse(new StoreResource($store),'ok',Response::HTTP_OK);
        }
        
        return $this->apiResponse(null,'this store not found',Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id)
    {
        $store = Store::find($id);

        try{
            $store->update([
                'name' => $request->name,
                'VAT' => $request->VAT ?? $store->VAT,
                'shipping_cost' => $request->shipping_cost ?? $store->shipping_cost,
            ]);
        } catch(\Exception $e){
            return $this->apiResponse(null,'the store not update',Response::HTTP_BAD_REQUEST);
        }
        return $this->apiResponse(new StoreResource($store),'store updated',Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store = Store::find($id);
        $store->delete();
        return $this->apiResponse(null,'the store deleted',Response::HTTP_OK);
    }
}
