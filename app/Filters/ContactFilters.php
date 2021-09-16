<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactFilters extends QueryFilters
{
    protected $request;

    protected $sortable = ['first_name', 'last_name', 'email', 'telephone'];

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function term($term)
    {
        Inertia::share('term', $term);

        return $this->builder->where(function ($query) use ($term) {
            $query->where('contacts.first_name', 'LIKE', '%'.$term.'%')
                ->orWhere('contacts.last_name', 'LIKE', '%'.$term.'%')
                ->orWhere('contacts.email', 'LIKE', '%'.$term.'%')
                ->orWhere('contacts.telephone', 'LIKE', '%'.$term.'%');
        });
    }
}
