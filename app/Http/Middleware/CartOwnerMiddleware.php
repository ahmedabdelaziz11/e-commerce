<?php

namespace App\Http\Middleware;

use App\Http\Traits\Api\ApiResponseTrait;
use App\Models\Cart;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartOwnerMiddleware
{
    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $cart = Cart::find($request->id);

        if($cart == null)
        {
            return $this->apiResponse(null,'this cart not found',Response::HTTP_BAD_REQUEST);
        }

        if($cart->user_id != auth()->user()->id)
        {
            return $this->apiResponse(null,'not allowed',Response::HTTP_FORBIDDEN);
        } 
        return $next($request);
    }
}
