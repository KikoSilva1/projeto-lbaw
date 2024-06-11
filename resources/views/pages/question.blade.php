@extends('layouts.app')



@section('content')
<div class="center-wrapper">
    <section id="questions">
        @include('partials.question', ['question' => $question])
    </section>
</div>
@endsection