@extends('layouts.app')


@section('content')

    <section>
        <h2>User Information</h2>
        <p>Name: {{ $user->name }}</p>
        <p>Email: {{ $user->email }}</p>
        <!-- Add more information as needed -->
    </section>

<h2>User questions:</h2>
<div class="center-wrapper">
<ul>
        @foreach ($userQuestions as $question)
            <h1><a href="{{ route('question.show', ['id' => $question->id]) }}">{{ $question->title }} </a></h1>
            <p>{{ $question->content }}</p>
        @endforeach
    </ul>
</div>
@endsection
</body>
