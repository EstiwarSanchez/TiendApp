<?php

namespace App\Http\Livewire;

use App\Http\Traits\WithUpdateListener;
use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class CompanyList extends Component
{
    /* use WithPagination, WithUpdateListener;

    public $columns;
    public $actions;
    private $companies;
    public $totalPercent;
    public $enableSearch = true;
    public $search = '';
    public $page = 1;
    public $perPage = '5';
    public $filter = true;
    public $order = 'DESC';
    public $by = 'created_at';
    public $width = '600';
    public $with=[];

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
            ['type' => 1, 'title' => __('Name'), 'name' => 'description', 'filter' => true],
            ['type' => 2, 'title' => __('Status'), 'name' => 'status', 'filter' => true],
            ['type' => 3, 'title' => __('Created at'), 'name' => 'created_at', 'filter' => true],
        ];

        $this->actions = [
            [
                'color' => 'blue',
                'can' => 'companies.edit',
                'function' => ['editCompany', 'id'],
                'icon' => 'edit',
                'title' => ___('Edit :resource',['resource'=>__('Company')])
            ],
            [
                'condition' => '==',
                'value' => '1',
                'to_check' => 'status',
                'color' => 'red',
                'can' => 'companies.manage_status',
                'function' => ['updateCompanyStatus', 'id'],
                'icon' => 'circle',
                'title' => ___('Inactive :resource',['resource'=>__('Company')])
            ],
            [
                'condition' => '==',
                'value' => '0',
                'to_check' => 'status',
                'color' => 'green',
                'can' => 'companies.manage_status',
                'function' => ['updateCompanyStatus', 'id'],
                'icon' => 'circle',
                'title' => ___('Active :resource',['resource'=>__('Company')])
            ],
        ];
    }


    public function render()
    {
        //obtenemos los usuarios diferentes a los tokens y el admin
        $this->companies = $this->getPagination(Company::select());
        return view('livewire.company-list', ['items' => $this->companies]);
    } */
}
