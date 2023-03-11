<?php 

namespace App\Http\Traits\Api;

use App\Models\Product;
use App\Models\Store;

trait CartTrait 
{
    public function getCartData($product_ids,$quantity)
    {
        $products = [];
        $stores = [];
        $sub_total = $vat_value = $shopping_cost = 0;
        foreach ($product_ids as $key => $value) 
        {              
            $product = Product::with('store')->find($value);
            $sub_total += ($product->price * $quantity[$key]);
            if(!$product->is_included_vat)
            {
                $vat_value += ($product->price * ($product->store->VAT / 100));
            }
            $stores[] = $product->store->id ;
            $products[] = [
                'quantity' => $quantity[$key],
                'unit_price' => $product->price,
                'product_id' => $value,
            ];
        }
        $shopping_cost = Store::whereIn('id',$stores)->sum('shipping_cost');

        return $data = [
            'products' => $products,
            'sub_total' => $sub_total,
            'vat_value' => $vat_value,
            'shopping_cost' => $shopping_cost,
        ];
    }
}