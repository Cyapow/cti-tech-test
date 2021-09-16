<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QueryFilters
{
    protected $request;

    protected $builder;

    protected $sortable;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;
        foreach ($this->filters() as $name => $value) {
            if (! method_exists($this, $name)) {
                continue;
            }
            if (strlen($value)) {
                $this->$name($value);
            }
        }

        return $this->builder;
    }

    public function filters(): array
    {
        return $this->request->all();
    }

    public function sort($sort)
    {
        if (! $this->sortable) {
            return $this->builder;
        }
        $column = $this->sortColumn($sort);

        if (! in_array($column, $this->sortable)) {
            return $this->builder;
        }

        $order = $this->sortOrder($sort);

        Inertia::share('sortingColumn', $column);
        Inertia::share('sortingAsc', $order == 'asc');
        Inertia::share('sortKey', $sort);

        return $this->builder->orderBy($column, $order);
    }

    protected function sortColumn($sort)
    {
        return substr($sort, 1);
    }

    protected function sortOrder($sort): string
    {
        $direction = substr($sort, 0, 1);
        if ($direction == '+') {
            return 'asc';
        }
        if ($direction == '-') {
            return 'desc';
        }

        return '';
    }
}
