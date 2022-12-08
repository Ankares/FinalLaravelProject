<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ShopDataInterface
{
    public function getAllProducts($orderField, $order, $itemsPerPage);
    public function getAllSearchedProducts($name);
    public function getOneProductById(int $id);
    public function addOneProduct(Request $request, $pathToDB);
    public function updateOneProduct(Request $request, $pathToDB);
    public function deleteOneProduct($id);
}
