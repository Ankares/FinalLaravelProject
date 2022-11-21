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

    public function storeProduct(Request $request)
    {
        $this->validation($request);

        $path = $this->fileService->imageStoring($request);

        $this->repository->addOneProduct($request, $path);
    }

    public function updateProduct(Request $request)
    {
        $this->validation($request);
        $productFromDB = $this->repository->getOneProductById($request->id);

        if ($request->hasFile('itemImage') && $productFromDB[0]['itemImage'] != 'noimage.jpg') {
            $this->fileService->deleteFromDir($productFromDB[0]['itemImage']);
            $this->fileService->deleteEmptyDir($productFromDB[0]['itemImage']);
            $path = $this->fileService->imageStoring($request);
        }
        if ($request->hasFile('itemImage') && $productFromDB[0]['itemImage'] == 'noimage.jpg') {
            $path = $this->fileService->imageStoring($request);
        }
        if (!$request->hasFile('itemImage')) {
            $path = $productFromDB[0]['itemImage'];
        }
        if (isset($request->dropImage) && !$request->hasFile('itemImage') && $productFromDB[0]['itemImage'] != 'noimage.jpg') {
            $this->fileService->deleteFromDir($productFromDB[0]['itemImage']);
            $this->fileService->deleteEmptyDir($productFromDB[0]['itemImage']);
            $path = 'noimage.jpg';
        }

        $this->repository->updateOneProduct($request, $path);
    }

    public function deleteProduct(Request $request)
    {
        $productFromDB = $this->repository->getOneProductById($request->id);

        if ($productFromDB[0]['itemImage'] != 'noimage.jpg') {
            $this->fileService->deleteFromDir($productFromDB[0]['itemImage']);
            $this->fileService->deleteEmptyDir($productFromDB[0]['itemImage']);
        }

        $this->repository->deleteOneProduct($request->id);
    }
}
