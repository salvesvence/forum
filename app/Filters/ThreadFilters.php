<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadFilters
{
    /**
     * @var Request
     */
    private $request;

    /**
     * ThreadFilters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the necessary filters to the builder given.
     *
     * @param $builder
     * @return mixed
     */
    public function apply($builder)
    {
        if(! $username = $this->request->by) return $builder;

        $user = User::where('name', $username)->firstOrFail();

        return $builder->where('user_id', $user->id);
    }
}