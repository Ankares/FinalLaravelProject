<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property array $chosenData
 *
 * @method setData
 * @method getData
 */
class ShopItem extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ['id'];

    /**
     * Chosen services for product.
     *
     * @var array<string, string|int>
     */
    private $chosenData = [
        'itemId' => '',
        'warranty' => '',
        'delivery' => '',
        'setUp' => '',
    ];

    /**
     * Set product and chosen services.
     *
     * @param array $chosenItemAndServices
     *
     * @return void
     */
    public function setData($chosenItemAndServices)
    {
        foreach ($chosenItemAndServices as $key => $value) {
            if (array_key_exists($key, $this->chosenData)) {
                $this->chosenData[$key] = $value;
            }
        }
    }

    /**
     * Get chosen product with services.
     *
     * @return array
     */
    public function getData()
    {
        return array_filter($this->chosenData);
    }
}
