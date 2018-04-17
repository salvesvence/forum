<?php

namespace App\Http\Forms;

use App\Exceptions\ThrottleException;
use App\Reply;
use App\Thread;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreatePostForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new Reply());
    }

    /**
     * @throws ThrottleException
     */
    protected function failedAuthorization()
    {
        throw new ThrottleException('You are posting too frequently. Please, take a break. :)');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|spamfree'
        ];
    }

    /**
     * Persist the form with the data given.
     *
     * @param Thread $thread
     * @return \Illuminate\Http\JsonResponse
     */
    public function persist($thread)
    {
        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'The reply has been stored',
            'reply' => $reply->load('owner')
        ]);
    }
}
