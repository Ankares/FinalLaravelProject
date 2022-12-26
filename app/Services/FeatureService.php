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
        if (isset($filter['reset']) || isset($filter['refresh'])) {
            $this->filterSession->forget('filter');
        }
        if (empty($filter) || !$this->filterSession->has('filter')) {
            $sortedProducts = $this->shopRepository->getAllProducts('id', 'asc', self::PERPAGE);

            return $sortedProducts;
        }
        if (isset($filter['category']) || $this->filterSession->has('category')) {
            return;
        }

        $filter = $this->filterSession->get('filter');
        list($orderField, $order) = explode('-', key($filter));
        $sortedProducts = $this->shopRepository->getAllProducts($orderField, $order, self::PERPAGE);

        return $sortedProducts;
    }

    /**
     * Choosing product's category + applying filter to this category
     *
     * @param array $category
     *
     * @return array
     */
    public function chooseCategory($category)
    {
        $orderField = 'itemName';
        $order = 'asc';

        if (!empty($category['filter'])) {
            $this->filterSession->put('filter', $category['filter']);
        }
        if (!empty($category['category'])) {
            $this->filterSession->put('category', $category['category']);
        }
        if ($this->filterSession->has('category')) {
            $category = $this->filterSession->get('category');
        }
        if ($this->filterSession->has('filter') && $this->filterSession->has('category')) {
            $filter = $this->filterSession->get('filter');
            list($orderField, $order) = explode('-', key($filter));
        }

        $products = $this->shopRepository->getProductsByCategory($category, $orderField, $order, self::PERPAGE);
        return $products;
    }

     /**
     * Forget category to display all products
     *
     * @param mixed $refresh
     *
     * @return void
     */
    public function forgetCategory($refresh)
    {
        if (!empty($refresh) && $this->filterSession->has('category')) {
            $this->filterSession->forget('category');
            return;
        }
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
