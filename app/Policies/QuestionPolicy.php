<?php

namespace App\Policies;

use App\Models\User;

use App\Models\Question;

class QuestionPolicy
{
    /**
     * Create a new policy instance.
     */


     public function show(User $user, Question $question)
     {
         // Add your authorization logic here
         // For example, you might check if the user can view the question based on certain conditions
     
         // For simplicity, allow any authenticated user to view any question
         return auth()->check();
     }
          
     public function showPersonalQuestions($questions){
            return auth()->check();
     }
     
     public function create(Request $request)
     {
         // Authorization check
         $this->authorize('create', Question::class);
     
         // Rest of the create method...
     }
     
    public function __construct()
    {
        //
    }

    public function vote(User $user, Question $question)
    {
        // Add your authorization logic here
        // For example, you might check if the user can vote based on certain conditions

        // For simplicity, allow any authenticated user to vote
        return auth()->check();
    }
}
