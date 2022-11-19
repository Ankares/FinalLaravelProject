<?php

namespace App\Repositories;

use App\Interfaces\ShopDataInterface;
use App\Models\Shop;

class ShopRepository implements ShopDataInterface
{
    public function getAllProducts($limit = 20)
    {
        $shopItems = Shop::query()->where('id', '>', 25)->limit($limit)->get();

        return $shopItems;
    }

    public function getOneProductById($id)
    {
        $shopItem = Shop::query()->where('id', $id)->get();

        return $shopItem;
    }
}
