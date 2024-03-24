<?php

namespace App\Http\Gateways;

use App\Models\Product;
use App\Traits\BasicGatewaysTrait;

class ProductGateway
{
    use BasicGatewaysTrait;

    public function all()
    {
        $query = Product::query();

        if ($this->with) {
            $query->with($this->with);
        }

        if ($this->limit) {
            $query->limit($this->limit);
        }
        $query->where('activated', true);
        if ($this->search['keywords'] && count($this->search['columns'])) {
            $this->appendSearch($query);
        }

        if (count($this->filters)) {
            $this->appendFilters($query);
        }

        if ($this->paginate) {
            return $query->paginate($this->paginate);
        }

        return $query->get();
    }

    public function getById(int $ProductId)
    {
        $query = Product::query();

        if ($this->with) {
            $query->with($this->with);
        }
        $query->with('photos');
        $query->where([
            'id' => $ProductId,
        ]);

        return $query->first();
    }

    public function getByCategory(int $ProductCategoryId)
    {
        $query = Product::query();

        if ($this->with) {
            $query->with($this->with);
        }

        $query->where([
            'category_id' => $ProductCategoryId,
        ]);

        return $query->first();
    }

    protected function appendFilters($query)
    {
        if (array_key_exists('start_created_at', $this->filters)) {
            $query->where('created_at', '>=', $this->filters['start_created_at']);
        }

        if (array_key_exists('end_created_at', $this->filters)) {
            $query->where('created_at', '<=', $this->filters['end_created_at']);
        }

        return $query;
    }
    public function getRandomProducts()
    {
        $randomProducts = Product::where('activated', true)->inRandomOrder()->limit(50)->get();
        return $randomProducts;

    }
}
