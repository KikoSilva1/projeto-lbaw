<?php

namespace App\Policies;

use App\Models\User;

use App\Models\Answer;
use App\Models\Question;

use Illuminate\Support\Facades\Auth;

class AnswerPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user, Answer $answer): bool
{
    // Your logic here...
    return Auth::check();;
}
}
