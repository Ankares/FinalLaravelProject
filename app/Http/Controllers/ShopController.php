<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopItemStoreRequest;
use App\Interfaces\CurrencyServiceInterface;
use App\Jobs\UploadProductsToAmazonJob;
use App\Repositories\ShopRepository;
use App\Services\AwsService;
use App\Services\ExchangeCurrencyService;
use App\Services\FeatureService;
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
     * @param \Illuminate\Http\Request     $request
     * @param \App\Services\FeatureService $featureService
     *
     *  @return \Illuminate\View\View
     */
    public function show(Request $request, FeatureService $featureService, CurrencyServiceInterface $currencyInterface)
    {
        $data = $featureService->paginationAndSorting($request->except(['search', '_token']));
        $filteredData = $featureService->filtration($request->only(['search']));

        $currencies = $currencyInterface->getCurrencies();

        return view('shop/shopPage', ['data' => $data, 'filteredData' => $filteredData, 'currencies' => $currencies]);
    }

    /**
     *  Export products prices to Amazon web service.
     *
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function exportPrices()
    {
        UploadProductsToAmazonJob::dispatch('shop-bucket', 'prices', __DIR__ . '/../../../storage/files/prices.csv');

        return redirect('/show-exports')->with('success', 'You have successfully exported prices');
    }

    /**
     *  Displaying all exported files in the bucket.
     *
     * @param \App\Services\AwsService $awsService
     *
     *  @return \Illuminate\View\View
     */
    public function showExports(AwsService $awsService)
    {
        $bucketData = $awsService->getBucketInfo('shop-bucket');
        if ($bucketData != null) {
            foreach ($bucketData->Contents as $content) {
                $filesData[] = $awsService->getContentOfFiles('shop-bucket', $content->Key);
            }
        }

        return view('files/export', ['bucketData' => $bucketData ?? null, 'filesData' => $filesData ?? null]);
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
    public function cart(ShopSessionsService $sessionService, Request $request, CurrencyServiceInterface $currencyInterface)
    {
        if ($request->input()) {
            $sessionService->addProductToSession($request->input());
        }
        $products = $sessionService->getProductsFromSession();

        $currencies = $currencyInterface->getCurrencies();

        return view('shop/cart', ['products' => $products, 'currencies' => $currencies]);
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
