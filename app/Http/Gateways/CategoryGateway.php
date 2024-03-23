<?php

namespace App\Gateways;

use App\Models\Category;
use App\Traits\BasicGatewaysTrait;

class CategoryGateway
{
    use BasicGatewaysTrait;

    public function all()
    {
        $query = Category::query();

        if ($this->with) {
            $query->with($this->with);
        }

        if ($this->limit) {
            $query->limit($this->limit);
        }

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

    public function getById(int $categoryId)
    {
        $query = Category::query();

        if ($this->with) {
            $query->with($this->with);
        }

        $query->where([
            'id' => $categoryId,
        ]);

        return $query->first();
    }

    public function getByCategory(int $categoryId)
    {
        $query = Category::query();

        if ($this->with) {
            $query->with($this->with);
        }

        $query->where([
            'category_id' => $categoryId,
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
}
