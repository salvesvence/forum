<?php

namespace App\Http\Controllers;

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
        try {

            Favorite:create([
                'user_id' => auth()->id(),
                'favorited_id' => $reply->id,
                'favorited_type' => get_class($reply),
            ]);

        } catch (\Exception $exception) {

            \Log::error($exception->getMessage());
        }
    }
}
