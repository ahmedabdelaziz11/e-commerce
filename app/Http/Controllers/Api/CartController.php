<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Http\Traits\Api\ApiResponseTrait;
use App\Http\Traits\Api\CartTrait;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    use ApiResponseTrait,CartTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::with(['products','user'])->paginate(10);

        return $this->apiResponse(
            CartResource::collection($carts)->response()->getData(true),
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
    public function store(CartRequest $request)
    {
        DB::beginTransaction();
        try{
            $cartData = $this->getCartData($request->product_ids,$request->quantity);

            $cart = Cart::create([
                'sub_total' => $cartData['sub_total'],
                'shipping_cost' => $cartData['shopping_cost'],
                'vat_value' => $cartData['vat_value'],
                'user_id' => auth()->user()->id,
            ]);

            $cart->cartProducts()->createMany($cartData['products']);
        } catch(\Exception $e){
            DB::rollback();
            return $this->apiResponse(null,'the cart not save',Response::HTTP_BAD_REQUEST);
        }
        DB::commit();
        return $this->apiResponse(new CartResource($cart->load(['products','user'])),'cart saved',Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cart = Cart::find($id);

        if($cart)
        {
            return $this->apiResponse(new CartResource($cart->load(['products','user'])),'ok',Response::HTTP_OK);
        }
        
        return $this->apiResponse(null,'this cart not found',Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(CartRequest $request, $id)
    {
        DB::beginTransaction();
        try{

            $cartData = $this->getCartData($request->product_ids,$request->quantity);

            $cart = Cart::find($id);
            CartProduct::where('cart_id',$id)->delete();

            $cart->update([
                'sub_total' => $cartData['sub_total'],
                'shipping_cost' => $cartData['shopping_cost'],
                'vat_value' => $cartData['vat_value'],
                'user_id' => auth()->user()->id,
            ]);

            $cart->cartProducts()->createMany($cartData['products']);
        } catch(\Exception $e){
            DB::rollback();
            return $this->apiResponse(null,'the cart not update',Response::HTTP_BAD_REQUEST);
        }
        DB::commit();
        return $this->apiResponse(new CartResource($cart->load(['products','user'])),'cart updated',Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return $this->apiResponse(null,'the cart deleted',Response::HTTP_OK);
    }
}
