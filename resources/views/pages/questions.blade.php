

@extends('layouts.app')



@section('content')


<form id="searchQuestionsForm" action="/search" method="get">
    <label for="searchQuestions">Search:</label>
    <input type="text" id="searchQuestions" name="q" placeholder="Search a Question">
    <button type="submit">Search</button>
</form>

<form id="createQuestionsForm" action="/create" method="put">
    <label for="createQuestion">Ask a Question</label>
    <input type="text" id="questionTitle" name="q" placeholder="Question Title">
    <input type="text" id="questionContent" name="q" placeholder="Question Content">   
    <button type="submit">Add Question</button>
</form>

<div class="center-wrapper">
<section id="questions">
    @each('partials.question', $questions, 'question')
</section>
</div>
@endsection
