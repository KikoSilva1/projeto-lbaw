@extends('layouts.app')



@section('content')


<form id="searchQuestionsForm" action="/search" method="get">
    <label for="searchQuestions">Search:</label>
    <input type="text" id="searchQuestions" name="q" placeholder="Search a Question">
    <button type="submit">Search</button>
</form>

<div class="center-wrapper">
<section id="questions">
    @each('partials.question', $questions, 'question')
</section>
</div>
@endsection
