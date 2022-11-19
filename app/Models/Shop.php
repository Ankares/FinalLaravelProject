<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    public $timestamps = false;

    private $chosenData = [
        'itemId' => '',
        'warranty' => '',
        'delivery' => '',
        'setUp' => '',
    ];

    public function setData(array $chosenItemAndServices): void
    {
        foreach ($chosenItemAndServices as $key => $value) {
            if (array_key_exists($key, $this->chosenData)) {
                $this->chosenData[$key] = $value;
            }
        }
    }

    public function getData(): array
    {
        return array_filter($this->chosenData);
    }
}
