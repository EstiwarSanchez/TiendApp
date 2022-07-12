<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Schema;

trait QueryHelpers
{
    public function scopeSearchByAll($query, $search = '', $only = [], $except = [])
    {
        $columns = Schema::getColumnListing($this->getTable());
        if (($key = array_search('id', $columns)) !== false) {
            unset($columns[$key]);
        }
        $query->where(function ($q) use ($columns, $only, $except, $search){
            foreach ($columns as $column) {
                if (empty($only)) {
                    if (!in_array($column, $except)) {
                        $q->orWhere($column, 'LIKE', '%' . $search . '%');
                    }
                } else {
                    if (in_array($column, $only)) {
                        $q->orWhere($column, 'LIKE', '%' . $search . '%');
                    }
                }
            }
        });
        return $query;
    }

    public function scopeActive($query, $column = 'status')
    {
        return $query->where($column, 1);
    }

    public function scopeGetRange($query, $limit=1, $offset=0)
    {
        return $query->offset($offset)->limit($limit);
    }

    public function scopeSelectOptions($query, $search = '', $only = [],$limit = 5)
    {
        if (!empty($only)) {
            $query->select($only);
        }

        return $query->searchByAll($search, $only)->active()->getRange($limit)->get();
    }
}
