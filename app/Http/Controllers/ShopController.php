<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopItemStoreRequest;
use App\Repositories\ShopRepository;
use App\Services\ShopItemProcessingService;
use App\Services\ShopSessionsService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
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
    public function store(ShopItemProcessingService $productService, ShopItemStoreRequest $request)
    {
        $productService->storeProduct($request);

        return redirect('/');
    }

    /**
     *  Show the shop page with products.
     *
     *  @return \Illuminate\View\View
     */
    public function show(ShopRepository $repository)
    {
        $products = $repository->getAllProducts(1, 100);

        return view('shop/shopPage', ['products' => $products]);
    }

    /**
     *  Show the edit product page.
     *
     *  @param \Illuminate\Http\Request $request
     *
     *  @return \Illuminate\View\View
     */
    public function edit(ShopRepository $repository, Request $request)
    {
        $product = $repository->getOneProductById($request->id);

        return view('shop/editPage', ['item' => $product]);
    }

    /**
     *  Update edited product in DB.
     *
     *  @param \Illuminate\Http\Request $request
     *
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function update(ShopItemProcessingService $productService, ShopItemStoreRequest $request)
    {
        $productService->updateProduct($request);

        return redirect('/');
    }

    /**
     *  Delete one product from DB.
     *
     *  @param \Illuminate\Http\Request $request
     *
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function delete(ShopItemProcessingService $productService, Request $request)
    {
        $productService->deleteProduct($request->id);

        return redirect('/');
    }

    /**
     *  Show additional services for chosen product.
     *
     *  @param \Illuminate\Http\Request $request
     *
     *  @return \Illuminate\View\View
     */
    public function additionalServices(ShopRepository $repository, Request $request)
    {
        $product = $repository->getOneProductById($request->id);

        return view('shop/productServices', ['item' => $product]);
    }

    /**
     *  Show user's cart with products.
     *
     *  @param \Illuminate\Http\Request $request
     *
     *  @return \Illuminate\View\View
     */
    public function cart(ShopSessionsService $sessionService, Request $request)
    {
        if ($request->input()) {
            $sessionService->addProductToSession($request->input());
        }
        $products = $sessionService->getProductsFromSession();

        return view('shop/cart', ['products' => $products]);
    }

    /**
     *  Delete product from user's cart.
     *
     *  @param \Illuminate\Http\Request $request
     *
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFromCart(ShopSessionsService $sessionService, Request $request)
    {
        $sessionService->deleteFromSession($request->id);

        return redirect('/shopping-cart');
    }
}
