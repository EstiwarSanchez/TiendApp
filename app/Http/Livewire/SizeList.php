<?php

namespace App\Http\Livewire;

use App\Http\Traits\WithUpdateListener;
use App\Models\Size;
use Livewire\Component;
use Livewire\WithPagination;

class SizeList extends Component
{
    use WithPagination, WithUpdateListener;

    public $columns;
    public $actions;
    private $sizes;
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
            ['type' => 1, 'title' => __('Description'), 'name' => 'description', 'filter' => true],
            ['type' => 3, 'title' => __('Created at'), 'name' => 'created_at', 'filter' => true],
        ];

        $this->actions = [
            [
                'color' => 'blue',
                'function' => ['editSize', 'id'],
                'icon' => 'edit',
                'title' => ___('Edit :resource',['resource'=>__('Size')])
            ]
        ];
    }

    public function render()
    {
        $this->sizes = $this->getPagination(Size::select());
        return view(
            'livewire.size-list',
            ['items' => $this->sizes]
        );
    }
}
