<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;

use App\Models\Answer;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;

class UserController extends Controller
{
    
    public function showPersonalPage(): View
    {
        
        $user = Auth::user();
        $userQuestions = Question::where('user_id', $user->id)->get(); 


        
        return view('pages.userProfile', [
            'user' => $user,
            'userQuestions' => $userQuestions,
        ]);
    }

    public function showUser(string $id): View
    {
        
        $question = Question::findOrFail($id);

        $user= $question->user;

        $userQuestions = Question::where('user_id', $user->id)->get(); 


       
        return view('pages.userProfile', [
            'user' => $user,
            'userQuestions' => $userQuestions,
        ]);
    }


    public function showUserFromAnswers(string $answerId): View
    {
        
        $answer = Answer::findOrFail($answerId);

        $user= $answer->user;

        $userQuestions = Question::where('user_id', $user->id)->get();

        return view('pages.userProfile', [
            'user' => $user,
            'userQuestions' => $userQuestions,
        ]);

    }

}
