<?php

namespace App\Services;

use App\Http\Requests\ShopItemStoreRequest;
use App\Repositories\ShopRepository;

class ShopItemProcessingService
{
    public const DEFAULTIMAGE = 'noimage.jpg';

    public function __construct(
        private readonly FileProcessingService $fileService,
        private readonly ShopRepository $repository
    ) {
    }

    /**
     * Validate product's input fields.
     *
     * @param \App\Http\Requests\ShopItemStoreRequest $request
     *
     * @return void
     */
    private function serviceValidation(ShopItemStoreRequest $request)
    {
        if ($request->warrantyPeriod === 'no') {
            $request->warrantyPeriod = null;
            $request->warrantyCost = null;
        }
        if ($request->deliveryPeriod === 'no') {
            $request->deliveryPeriod = null;
            $request->deliveryCost = null;
        }
    }

    /**
     * Storing one product to DB.
     *
     * @param \App\Http\Requests\ShopItemStoreRequest $request
     *
     * @return void
     */
    public function storeProduct(ShopItemStoreRequest $request)
    {
        $this->serviceValidation($request);

        $path = $this->fileService->imageStoring($request->file('itemImage'));

        $this->repository->addOneProduct($request, $path);
    }

    /**
     * Updating one product and image in directory and database.
     *
     * @param \App\Http\Requests\ShopItemStoreRequest $request
     *
     * @return void
     */
    public function updateProduct(ShopItemStoreRequest $request)
    {
        $this->serviceValidation($request);
        $productFromDB = $this->repository->getOneProductById($request->id);

        if ($request->itemImage && $productFromDB['itemImage'] != self::DEFAULTIMAGE) {
            $this->deleteImageFromDir($productFromDB['itemImage']);
            $path = $this->fileService->imageStoring($request->file('itemImage'));
        }
        if ($request->itemImage && $productFromDB['itemImage'] == self::DEFAULTIMAGE) {
            $path = $this->fileService->imageStoring($request->file('itemImage'));
        }
        if (!$request->itemImage) {
            $path = $productFromDB['itemImage'];
        }
        if (isset($request->dropImage) && !$request->itemImage && $productFromDB['itemImage'] != self::DEFAULTIMAGE) {
            $this->deleteImageFromDir($productFromDB['itemImage']);
            $path = self::DEFAULTIMAGE;
        }

        $this->repository->updateOneProduct($request, $path);
    }

    /**
     * Delete one product and image from database and directory.
     *
     * @param $id
     *
     * @return void
     */
    public function deleteProduct($id)
    {
        $productFromDB = $this->repository->getOneProductById($id);

        if ($productFromDB['itemImage'] != self::DEFAULTIMAGE) {
            $this->deleteImageFromDir($productFromDB['itemImage']);
        }

        $this->repository->deleteOneProduct($id);
    }

    /**
     * Combine deleting image from directory and deleting empty directory.
     *
     * @param string $image
     *
     * @return void
     */
    private function deleteImageFromDir($image)
    {
        $this->fileService->deleteFromDir($image);
        $this->fileService->deleteEmptyDir($image);
    }
}
