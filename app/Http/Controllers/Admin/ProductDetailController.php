<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Product;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    /**
     * Handle the incoming request.
     *
     */
    public function __invoke($id)
    {
        $product = Product::find($id);

        return  view('webend.ecommerce.users.product.detail', compact('product'));
    }
}
