<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

trait WithUpdateListener
{

    protected function getListeners()
    {
        $addListeners = isset($this->addListeners) ? $this->addListeners : [];
        return array_merge(['table-updated' => 'UpdateTable'], $addListeners);
    }

    public function updated($propertyName)
    {
        if (Str::contains($propertyName, '.')) {
            $property = explode('.',$propertyName);
            $this->{$property[0]}[$property[1]] = htmlspecialchars(strip_tags($this->{$property[0]}[$property[1]]));
        }else{
            $this->{$propertyName} =  htmlspecialchars(strip_tags($this->{$propertyName}));
        }
    }

    public function UpdateTable()
    {
        $this->emit('updateTippy');
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->UpdateTable();
    }

    public function updatingPerPage()
    {
        $this->UpdateTable();
    }

    public function filterBy($column)
    {
        $this->by = $column;
        if ($this->order == 'DESC') {
            $this->order = 'ASC';
        } else {
            $this->order = 'DESC';
        }
        $this->emit('updateTippy');
        $this->resetPage();
    }

    public function paginateCollection($collection)
    {
        $this->emit('updateTippy');
        return $collection->paginate((int)$this->perPage ?? 5);
    }

    public function getPagination($model)
    {
        $items = $model;
        if (isset($this->with)) {
            if (Str::contains($this->by, '._.')) {
                $with = [];
                $by = explode('._.', $this->by);

                if (count($by)>2) {
                    $with[$by[0]][$by[1]] = function ($q) use ($by) {
                        $q->orderBy($by[2], $this->order);
                    };

                    $items->with($with);
                } else {
                    $with[$by[0]] = function ($q) use ($by) {
                        $q->orderBy($by[1], $this->order);
                    };

                    $items->with($with);
                }
            } else {
                $items->with($this->with);
            }
        }
        if (trim($this->search) != '') {
            $items->where(function ($query) {
                $this->makeWhere($query);
            });
            if (!Str::contains($this->by, '._.')) {
                $items->orderBy($this->by, $this->order);
            }
        } else {
            if (!Str::contains($this->by, '._.')) {
                $items = $items->orderBy($this->by, $this->order);
            }
        }
        if (isset($this->withTables) && Str::contains($this->by, '._.')) {
            $by = explode('._.', $this->by);
            $items->orderBy($this->withTables[$by[0]].'.'.$by[1], $this->order);
        }

        $this->emit('updateTippy');

        return $items->paginate(((int)$this->perPage ?? 5));
    }


    private function makeWhere($query)
    {
        $i = 0;
        foreach ($this->columns as $column) {
            if (isset($column['name']) && $column['type'] != 9) {
                if (is_array($column['name'])) {
                    $this->whereByRelation($i,$column['name'],$query);
                } else {
                    if ($i == 0) {
                        $query->where($column['name'], 'like', '%' . $this->search . '%');
                    } else {
                        $query->orWhere($column['name'], 'like', '%' . $this->search . '%');
                    }
                }
                $i++;
            }
        }
    }


    private function whereByRelation($i, $relation , $query)
    {
        if ($i == 0) {
            $query->whereHas($relation[0], function ($q) use ($relation) {
                $q->where($relation[1], 'like', '%' . $this->search . '%');
            });
        } else {
            $query->orWhereHas($relation[0], function ($q) use ($relation) {
                $q->where($relation[1], 'like', '%' . $this->search . '%');
            });
        }
        return $query;
    }
}
