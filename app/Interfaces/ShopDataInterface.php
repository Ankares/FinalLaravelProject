<?php

namespace App\Interfaces;

interface ShopDataInterface
{
    public function getAllProducts(int $from, int $limit);
    public function getOneProductById(int $id);
}
