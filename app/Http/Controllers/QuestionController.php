<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Models\Question;

use App\Models\Vote;



class QuestionController extends Controller
{


// not tested yet 
    public function create(Request $request)
    {
        // Create a blank new question.


        $highestId = DB::table('questions')->max('id');

        // Determine the next available ID for a new question
        $newId = $highestId + 1;

        $question = new Question();
        
        $question->id = $newId;
        $question->title = $request->input('title');
        $question->content = $request->input('content');
        $question->user_id = Auth::user()->id;
        $question->upvotes = 0;

        // Save the card and return it as JSON.
        $question->save();
        return response()->json($question);
    }


    public function show(string $id): View
    {
        
        $question = Question::findOrFail($id);

        // Check if the current user can see (show) the card.
        $this->authorize('show', $question);  

        // Use the pages.card template to display the card.
        return view('pages.question', [
            'question' => $question
        ]);
    }
    
    public function showPersonalQuestions(): View
    {
        
        $questions = Question::where('user_id', Auth::user()->id)->get();

        // Check if the current user can see (show) the card.
        //$this->authorize('showPersonalQuestions', $questions);  

        // Use the pages.card template to display the card.
        return view('pages.personalQuestions', [
            'questions' => $questions
        ]);
    }

    public function list(Request $request)
    {
        // Check if the user is logged in.
        if (!Auth::check()) {
            // Not logged in, redirect to login.
            return redirect('/login');
        }
        
        $questionsQuery = Question::query()
        ->orderByDesc('upvotes')
        ->orderBy('id');

        // Check if a search query is provided
        $searchQuery = $request->input('search');
        if ($searchQuery !== null) {
            // If a search query is provided, filter the cards
            //$questionsQuery->where('title', 'ILIKE', "%$searchQuery%");
            $questionsQuery->whereRaw("to_tsvector('english', title) @@ to_tsquery('english', ?)", ["'$searchQuery'"]);
        }

        // Get the filtered or all cards
        $questions = $questionsQuery->get();

        

        
        // Check if the current user can list the cards.
        //$this->authorize('list', Card::class);

        // The current user is authorized to list cards.

        // Use the pages.cards template to display all cards.
        return view('pages.questions', [
            'questions' => $questions,
            'searchQuery' => $searchQuery,
        ]);
    }



    public function upvote($questionId)
{
 
    $question = Question::findOrFail($questionId);


    $numberOfUpvotes= $question->upvotes;

    $this->authorize('vote', $question);

    $user = Auth::user();

    $userId = $user->id;

    // Check if the user has already voted on this question
    $existingVote = $user->votes()->where('question_id', $questionId)->first();

   

    if (!$existingVote) {
        // If the user hasn't voted, create a new vote and increment upvotes
        $vote = new Vote([
            'type' => 'upvote',
        ]);
        
        $vote->user()->associate($user);
        $vote->question()->associate($question);
        $vote->save();

        $question->increment('upvotes');

        $numberOfUpvotes= $question->upvotes;


        return response()->json(['message' => 'Upvoted!', 'number_of_upvotes' => $numberOfUpvotes]);
}
return response()->json(['message' => 'Already voted!', 'number_of_upvotes' => $numberOfUpvotes]);

}

public function downvote($questionId)
{
    
    $question = Question::findOrFail($questionId);
    $this->authorize('vote', $question);

    $user = Auth::user();
    

    $numberOfUpvotes= $question->upvotes;
    // Check if the user has already voted on this question
    $existingVote = $user->votes()->where('question_id', $questionId)->first();

    if (!$existingVote) {
        // If the user hasn't voted, create a new vote and increment upvotes
        $vote = new Vote([
            'type' => 'downvote',
        ]);
        
        $vote->user()->associate($user);
        $vote->question()->associate($question);
        $vote->save();

        $question->decrement('upvotes');

        $numberOfUpvotes= $question->upvotes;

        return response()->json(['message' => 'Downvoted!', 'number_of_upvotes' => $numberOfUpvotes]);
    }
    return response()->json(['message' => 'Already voted!', 'number_of_upvotes' => $numberOfUpvotes]);

}

}