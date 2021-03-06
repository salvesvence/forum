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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Reply $reply)
    {
        try {

            $reply->favorite();

            session()->flash('flash', 'The reply is favorite now.');

        } catch (\Exception $exception) {

            \Log::error($exception->getMessage());

            session()->flash('flash', 'The reply is not favorite, try again.');
        }

        return redirect()->back();
    }


    /**
     * Store a new favorite element.
     *
     * @param Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reply $reply)
    {
        try {

            $reply->unfavorite();

            $message = 'The reply is favorite now.';

        } catch (\Exception $exception) {

            \Log::error($exception->getMessage());

            $message = 'The reply is not favorite, try again.';
        }

        if(request()->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->back()->with('flash', $message);
    }
}
