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

    /**
     *  Show the create product page.
     *
     *  @return \Illuminate\View\View
     */
    public function create()
    {
        return view('shop/create');
    }

    /**
     *  Add created product to DB.
     *
     *  @param \Illuminate\Http\Request $request
     *
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->itemService->storeProduct($request);

        return redirect('/');
    }

    /**
     *  Show the shop page with products.
     *
     *  @return \Illuminate\View\View
     */
    public function show()
    {
        $collections = $this->repository->getAllProducts(1, 100);

        return view('shop/shopPage', ['collections' => $collections]);
    }

    /**
     *  Show the edit product page.
     *
     *  @param \Illuminate\Http\Request $request
     *
     *  @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $collection = $this->repository->getOneProductById($request->id);

        return view('shop/editPage', ['item' => $collection[0]]);
    }

    /**
     *  Update edited product in DB.
     *
     *  @param \Illuminate\Http\Request $request
     *
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->itemService->updateProduct($request);

        return redirect('/');
    }

    /**
     *  Delete one product from DB.
     *
     *  @param \Illuminate\Http\Request $request
     *
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $this->itemService->deleteProduct($request->id);

        return redirect('/');
    }

    /**
     *  Show additional services for chosen product.
     *
     *  @param \Illuminate\Http\Request $request
     *
     *  @return \Illuminate\View\View
     */
    public function additionalServices(Request $request)
    {
        $collection = $this->repository->getOneProductById($request->id);

        return view('shop/productServices', ['item' => $collection[0]]);
    }

    /**
     *  Show user's cart with products.
     *
     *  @param \Illuminate\Http\Request $request
     *
     *  @return \Illuminate\View\View
     */
    public function cart(Request $request)
    {
        if ($request->input()) {
            $this->sessionService->addProductToSession($request->input());
        }
        $products = $this->sessionService->getProductsFromSession();

        return view('shop/cart', ['products' => $products]);
    }

    /**
     *  Delete product from user's cart.
     *
     *  @param \Illuminate\Http\Request $request
     *
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFromCart(Request $request)
    {
        $this->sessionService->deleteFromSession($request->id);

        return redirect('/shopping-cart');
    }
}
