<?php

namespace App\Services;

use App\Repositories\ShopRepository;
use Illuminate\Contracts\Session\Session;

class FeatureService
{
    public const PERPAGE = 9;

    public function __construct(
        private readonly ShopRepository $shopRepository,
        private readonly Session $filterSession,
    ) {
    }

    /**
     * Making pagination + applying chosen sorting.
     *
     * @param array $filter
     *
     * @return array
     */
    public function paginationAndSorting($filter)
    {
        if (!empty($filter) && !isset($filter['page'])) {
            $this->filterSession->put('filter', $filter);
        }
        if (isset($filter['reset'])) {
            $this->filterSession->forget('filter');
        }
        if (empty($filter) || !$this->filterSession->has('filter')) {
            $sortedProducts = $this->shopRepository->getAllProducts('id', 'asc', self::PERPAGE);

            return [
                'products' => $sortedProducts,
            ];
        }

        $filter = $this->filterSession->get('filter');
        list($orderField, $order) = explode('-', key($filter));
        $sortedProducts = $this->shopRepository->getAllProducts($orderField, $order, self::PERPAGE);

        return [
            'products' => $sortedProducts,
        ];
    }

    /**
     * Searching for needle products.
     *
     * @param string $input
     *
     * @return array|null
     */
    public function filtration($input)
    {
        if (isset($input['search'])) {
            $searchedProducts = $this->shopRepository->getAllSearchedProducts($input['search']);

            return $searchedProducts;
        }

        return null;
    }
}
