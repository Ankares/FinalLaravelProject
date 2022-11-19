<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Repositories\ShopRepository;
use App\Services\ShopSessionsService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct(
        private ShopRepository $repository,
        private ShopSessionsService $service,
        private Shop $shopModel
    ) {
    }
    public function shop()
    {
        $collections = $this->repository->getAllProducts();

        return view('shop/shopPage', ['collections' => $collections]);
    }

    public function services(Request $request)
    {
        $collection = $this->repository->getOneProductById($request->id);

        return view('shop/productServices', ['collection' => $collection]);
    }

    public function cart(Request $request)
    {
        if ($request->input()) {
            $this->service->addProductToSession($request->input());
        }
        $products = $this->service->getProductsFromSession();

        return view('shop/cart', ['products' => $products]);
    }
}
