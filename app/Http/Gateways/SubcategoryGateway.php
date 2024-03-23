<?php

namespace App\Http\Gateways;

use App\Models\Subcategory;
use App\Traits\BasicGatewaysTrait;

class SubcategoryGateway
{
    use BasicGatewaysTrait;

    public function all()
    {
        $query = Subcategory::query();

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

    public function getById(int $subcategoryId)
    {
        $query = Subcategory::query();

        if ($this->with) {
            $query->with($this->with);
        }

        $query->where([
            'id' => $subcategoryId,
        ]);

        return $query->first();
    }

    public function getBySubcategory(int $subcategoryId)
    {
        $query = Subcategory::query();

        if ($this->with) {
            $query->with($this->with);
        }

        $query->where([
            'subcategory_id' => $subcategoryId,
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
