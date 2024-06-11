<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Answer;

class AnswerController extends Controller
{
    public function create(Request $request, $question_id)
    {
        // Create a blank new item.
        $answer = new Answer();

        // Set item's card.
        $answer->question_id = $question_id;

        // Check if the current user is authorized to create this item.
        //$this->authorize('create', $answer);

        $this->authorize('create', $answer);

        // Set item details.
        $answer->content = $request->input('content');
        
        $answer->user_id = Auth::user()->id; 

        $user_name = Auth::user()->name; 

    

        // Save the item and return it as JSON.
        $answer->save();
        return response()->json(['answer' => $answer, 'user_name' => $user_name]);
    }

}
