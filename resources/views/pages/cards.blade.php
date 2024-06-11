@extends('layouts.app')

@section('title', 'Cards')

@section('content')

<form id="searchForm" action="/search" method="get">
    <label for="search">Search:</label>
    <input type="text" id="search" name="q" placeholder="Search a Card">
    <button type="submit">Search</button>
</form>

<section id="cards">
    @each('partials.card', $cards, 'card')
    <article class="card">
        <form class="new_card">
            <input type="text" name="name" placeholder="new card">
        </form>
    </article>
</section>

@endsection
