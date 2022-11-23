<?php

namespace App\Services;

use App\Repositories\ShopRepository;
use Illuminate\Http\Request;

class ShopItemProcessingService
{
    public function __construct(
        private FileProcessingService $fileService,
        private ShopRepository $repository
    ) {
    }

    /**
     * Validate product's input fields.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    private function validation(Request $request)
    {
        $request->validate([
            'itemName' => 'required|min:5|max:100',
            'manufacturer' => 'required|string|max:100',
            'price' => 'required|integer',
            'year' => 'required|integer|min:2000|max:2022',
            'itemImage' => 'nullable|image|mimes:jpg,png,jpeg|max:2048|dimensions:min_width=300,min_height=300,max_width=2000,max_height=2000',
            'warrantyCost' => 'nullable|integer|max:2000',
            'deliveryCost' => 'nullable|integer|max:2000',
            'setUpCost' => 'nullable|integer|max:2000',
        ]);

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
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function storeProduct(Request $request)
    {
        $this->validation($request);

        $path = $this->fileService->imageStoring($request);

        $this->repository->addOneProduct($request, $path);
    }

    /**
     * Updating one product and image in directory and database.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function updateProduct(Request $request)
    {
        $this->validation($request);
        $productFromDB = $this->repository->getOneProductById($request->id);

        if ($request->itemImage && $productFromDB[0]['itemImage'] != 'noimage.jpg') {
            $this->deleteImageFromDir($productFromDB[0]['itemImage']);
            $path = $this->fileService->imageStoring($request);
        }
        if ($request->itemImage && $productFromDB[0]['itemImage'] == 'noimage.jpg') {
            $path = $this->fileService->imageStoring($request);
        }
        if (!$request->itemImage) {
            $path = $productFromDB[0]['itemImage'];
        }
        if (isset($request->dropImage) && !$request->itemImage && $productFromDB[0]['itemImage'] != 'noimage.jpg') {
            $this->deleteImageFromDir($productFromDB[0]['itemImage']);
            $path = 'noimage.jpg';
        }

        $this->repository->updateOneProduct($request, $path);
    }

    /**
     * Delete one product and image from database and directory.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function deleteProduct($id)
    {
        $productFromDB = $this->repository->getOneProductById($id);

        if ($productFromDB[0]['itemImage'] != 'noimage.jpg') {
            $this->deleteImageFromDir($productFromDB[0]['itemImage']);
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
