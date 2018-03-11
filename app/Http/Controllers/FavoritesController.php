<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * FavoritesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    /**
     * Store a new favorite element.
     *
     * @param Reply $reply
     */
    public function store(Reply $reply)
    {
        $reply->favorite();
    }
}
