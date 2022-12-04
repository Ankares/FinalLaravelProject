<?php

namespace App\Repositories;

use App\Interfaces\ShopDataInterface;
use App\Models\ShopItem;
use Illuminate\Http\Request;

class ShopRepository implements ShopDataInterface
{
    /**
     * Get limited products from DB.
     *
     * @param int $from
     * @param int $limit
     *
     * @return array
     */
    public function getAllProducts($from, $limit)
    {
        $shopItems = ShopItem::query()->where('id', '>=', $from)->limit($limit)->get();

        return $shopItems;
    }

    /**
     * Get one product from DB.
     *
     * @param int $id
     *
     * @return array
     */
    public function getOneProductById($id)
    {
        $shopItem = ShopItem::query()->where('id', $id)->first();

        return $shopItem;
    }

    /**
     * Add product to DB.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $pathToDB
     *
     * @return void
     */
    public function addOneProduct(Request $request, $pathToDB)
    {
        ShopItem::query()->create([
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

    /**
     * Update product in DB.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $pathToDB
     *
     * @return void
     */
    public function updateOneProduct(Request $request, $pathToDB)
    {
        ShopItem::where('id', $request->id)->update([
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

    /**
     * Delete one product from DB.
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteOneProduct($id)
    {
        ShopItem::query()->where('id', $id)->delete();
    }
}
