<?php

namespace App\Http\Livewire;

use App\Http\Traits\WithUpdateListener;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{

    use WithPagination, WithUpdateListener;

    public $columns;
    public $actions;
    private $products;
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
            ['type' => 1, 'title' => __('Size'), 'name' => ['size','name'], 'filter' => false],
            ['type' => 1, 'title' => __('Brand'), 'name' => ['brand','name'], 'filter' => false],
            ['type' => 1, 'title' => __('Observations'), 'name' => 'observations', 'filter' => true],
            ['type' => 1, 'title' => __('Number of Inventory'), 'name' => 'inventory_quantity', 'filter' => true],
            ['type' => 3, 'title' => __('Boarding of date'), 'name' => 'boarding_date', 'filter' => true],
        ];

        $this->actions = [
            [
                'color' => 'blue',
                'function' => ['editProduct', 'id'],
                'icon' => 'edit',
                'title' => ___('Edit :resource',['resource'=>__('Product')])
            ],
            [
                'color' => 'red',
                'function' => ['deleteProduct', 'id'],
                'icon' => 'trash-alt',
                'title' => ___('Delete')
            ]
        ];
    }
    public function render()
    {
        $this->products = $this->getPagination(Product::getProduct());
        return view('livewire.product-list',['items' => $this->products]);
    }
}
