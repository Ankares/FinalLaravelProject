<?php

namespace App\Interfaces;

interface ShopDataInterface
{
    public function getAllProducts(int $limit);
    public function getOneProductById(int $id);
}
