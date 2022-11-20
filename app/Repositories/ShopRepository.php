<?php

namespace App\Repositories;

use App\Interfaces\ShopDataInterface;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopRepository implements ShopDataInterface
{
    public function getAllProducts($limit = 30)
    {
        $shopItems = Shop::query()->where('id', '>', 20)->limit($limit)->get();

        return $shopItems;
    }

    public function getOneProductById($id)
    {
        $shopItem = Shop::query()->where('id', $id)->get();

        return $shopItem;
    }

    public function addOneProduct(Request $request, $pathToDB)
    {
        Shop::query()->create([
            'itemName' => $request->itemName,
            'manufacturer' => $request->manufacturer,
            'itemCost' => $request->price,
            'itemImage' => $pathToDB,
            'created_year' => $request->year,
            'warrantyPeriod' => $request->warrantyPeriod,
            'warrantyCost' => $request->warrantyCost,
            'deliveryPeriod' => $request->deliveryPeriod,
            'deliveryCost' => $request->deliveryCost,
            'itemSetupCost' => $request->setUpCost,
        ])->save();
    }

    public function updateOneProduct(Request $request, $pathToDB)
    {
        Shop::where('id', $request->id)->update([
            'itemName' => $request->itemName,
            'manufacturer' => $request->manufacturer,
            'itemCost' => $request->price,
            'itemImage' => $pathToDB,
            'created_year' => $request->year,
            'warrantyPeriod' => $request->warrantyPeriod,
            'warrantyCost' => $request->warrantyCost,
            'deliveryPeriod' => $request->deliveryPeriod,
            'deliveryCost' => $request->deliveryCost,
            'itemSetupCost' => $request->setUpCost,
        ]);
    }
}
