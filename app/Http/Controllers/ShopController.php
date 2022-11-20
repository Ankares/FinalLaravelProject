<?php

namespace App\Http\Controllers;

use App\Repositories\ShopRepository;
use App\Services\ShopItemProcessingService;
use App\Services\ShopSessionsService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct(
        private ShopRepository $repository,
        private ShopSessionsService $sessionService,
        private ShopItemProcessingService $itemService
    ) {
    }

    public function create()
    {
        return view('shop/create');
    }

    public function store(Request $request)
    {
        $this->itemService->storeProduct($request);
        return redirect('/');
    }

    public function show()
    {
        $collections = $this->repository->getAllProducts();
        return view('shop/shopPage', ['collections' => $collections]);
    }

    public function edit($id)
    {
        $collection = $this->repository->getOneProductById($id);
        return view('shop/editPage', ['item' => $collection[0]]);
    }

    public function update(Request $request)
    {
        $this->itemService->updateProduct($request);
        return redirect('/');
    }

    public function additionalServices(Request $request)
    {
        $collection = $this->repository->getOneProductById($request->id);

        return view('shop/productServices', ['collection' => $collection]);
    }

    public function cart(Request $request)
    {
        if ($request->input()) {
            $this->sessionService->addProductToSession($request->input());
        }
        $products = $this->sessionService->getProductsFromSession();

        return view('shop/cart', ['products' => $products]);
    }
}
