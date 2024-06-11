<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Card;

class CardController extends Controller
{
    /**
     * Show the card for a given id.
     */
    public function show(string $id): View
    {
        // Get the card.
        $card = Card::findOrFail($id);

        // Check if the current user can see (show) the card.
        $this->authorize('show', $card);  

        // Use the pages.card template to display the card.
        return view('pages.card', [
            'card' => $card
        ]);
    }


// Método adicionado por mim 

    public function list(Request $request)
    {
        // Check if the user is logged in.
        if (!Auth::check()) {
            // Not logged in, redirect to login.
            return redirect('/login');
        }

        // Get cards for the user ordered by id.
        $cardsQuery = Auth::user()->cards()->orderBy('id');

        // Check if a search query is provided
        $searchQuery = $request->input('search');
        if ($searchQuery !== null) {
            // If a search query is provided, filter the cards
            $cardsQuery->where('name', 'like', "%$searchQuery%");
        }

        // Get the filtered or all cards
        $cards = $cardsQuery->get();

        // Check if the current user can list the cards.
        $this->authorize('list', Card::class);

        // The current user is authorized to list cards.

        // Use the pages.cards template to display all cards.
        return view('pages.cards', [
            'cards' => $cards,
            'searchQuery' => $searchQuery,
        ]);
    }








   /*  /* *
     * Shows all cards.
     
    public function list()
    {
        // Check if the user is logged in.
        if (!Auth::check()) {
            // Not logged in, redirect to login.
            return redirect('/login');

        } else {
            // The user is logged in.

            // Get cards for user ordered by id.
            $cards = Auth::user()->cards()->orderBy('id')->get();

            // Check if the current user can list the cards.
            $this->authorize('list', Card::class);

            // The current user is authorized to list cards.

            // Use the pages.cards template to display all cards.
            return view('pages.cards', [
                'cards' => $cards
            ]);
        }
    } */

    /**
     * Creates a new card.
     */
    public function create(Request $request)
    {
        // Create a blank new Card.
        $card = new Card();

        // Check if the current user is authorized to create this card.
        $this->authorize('create', $card);

        // Set card details.
        $card->name = $request->input('name');
        $card->user_id = Auth::user()->id;

        // Save the card and return it as JSON.
        $card->save();
        return response()->json($card);
    }

    /**
     * Delete a card.
     */
    public function delete(Request $request, $id)
    {
        // Find the card.
        $card = Card::find($id);

        // Check if the current user is authorized to delete this card.
        $this->authorize('delete', $card);

        // Delete the card and return it as JSON.
        $card->delete();
        return response()->json($card);
    }

}

/* 
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->search;

            if (!empty($query)) {
                $data = Card::where('id', 'like', '%' . $query . '%')
                    ->orWhere('name', 'like', '%' . $query . '%')
                    ->get();
            } elseif($query == '') {
                // If no search term provided, get all cards
                $data = Card::all();
            }

            if (count($data) > 0) {
                $output = view('partials.search_results')->with('data', $data)->render();
            } else {
                $output = view('partials.no_results')->render();
            }

            return response()->json(['output' => $output]);
        }
    }




 */
































 /*    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->search;

            if (!empty($query)) {
                $data = Card::where('id', 'like', '%' . $query . '%')
                    ->orWhere('name', 'like', '%' . $query . '%')
                    ->get();
            } elseif($query == '') {
                // If no search term provided, get all cards
                $data = Card::all();
                dd($data);
            }

            if (count($data) > 0) {
                $output = '<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Card ID</th>
                            <th scope="col">Name</th>
                        </tr>
                    </thead>
                    <tbody>';

                foreach ($data as $row) {
                    $output .= '<tr> 
                        <td >' . $row->id . '</td>
                        <td>' . $row->name . '</td>
                    </tr>';
                }

                $output .= '</tbody>
                    </table>';
            } else {
                $output = '<tr>' . '<td>' . 'No results' . '</td>' . '</tr>';
            }

            return $output;
        }
    }
}






 */



   /*  //este é o método que faz a pesquisa, foi adicionado por mim

    public function search(Request $request){
        
        try {

            if($request ->ajax()){


               /*  $data = Card::where('description', 'like','%'.$request->search.'%')
                ->orWhere('card_id', 'like','%'.$request->search.'%')->get();
    
                if(count($data)>0){
    
                 $output =' <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Card ID</th>
                        <th scope="col">Description</th>
                    </tr>
                    </thead>
                    <tbody>';
                     
                    foreach($data as $row){
                        $output .= 
                        '<tr> 
                         <th scope="row">'.$row->card_id.'</th>
                            <td>'.$row->description.'</td>
                        </tr>';
                    }
    
                    $output .= '</tbody>
                    </table>';
    
    
                }
                else{
                    $output = '<tr>'.'<td>'.'No results'.'</td>'.'</tr>';
                }
    
                return $output; 
    
            }
            

        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
        
    
    }
 */