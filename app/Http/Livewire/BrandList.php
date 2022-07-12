<?php

namespace App\Http\Livewire;

use App\Http\Traits\WithUpdateListener;
use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;

class BrandList extends Component
{
    use WithPagination, WithUpdateListener;

    public $columns;
    public $actions;
    private $brands;
    public $enableSearch = true;
    public $search = '';
    public $page = 1;
    public $perPage = '5';
    public $filter = true;
    public $order = 'DESC';
    public $by = 'created_at';
    public $width = '600';
    public $with = [];

    public function getQueryString()
    {
        return [
            'page' => ['except' => 1],
            'perPage' => ['except' => '5'],
            'search' => ['except' => ''],
            'by' => ['except' => 'created_at'],
            'order' => ['except' => ($this->by === 'created_at' ? 'DESC' : '')]
        ];
    }

    public function mount()
    {
        $this->columns = [
            ['type' => 1, 'title' => __('Name'), 'name' => 'name', 'filter' => true],
            ['type' => 1, 'title' => __('Reference'), 'name' => 'reference', 'filter' => true],
            ['type' => 3, 'title' => __('Created at'), 'name' => 'created_at', 'filter' => true],
        ];

        $this->actions = [
            [
                'color' => 'blue',
                'function' => ['editBrand', 'id'],
                'icon' => 'edit',
                'title' => ___('Edit :resource',['resource'=>__('Brand')])
            ],
            [
                'color' => 'red',
                'function' => ['deleteBrand', 'id'],
                'icon' => 'trash-alt',
                'title' => ___('Delete')
            ]
        ];
    }

    public function render()
    {
        $this->brands = $this->getPagination(Brand::getBrand());
        return view('livewire.brand-list', ['items' => $this->brands]);
    }
}
