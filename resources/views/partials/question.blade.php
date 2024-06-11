


<article class="question" data-id="{{ $question->id }}">
    <header>
        <h2><a href="{{ route('question.show', ['id' => $question->id]) }}">{{ $question->title }}</a></h2>
        <p>Questioned by:<a href="{{ route('user.show', ['id' => $question->id]) }}"> {{ $question->user->name }} </a></p>
    </header>
    <p>{{ $question->content}}</p>
<div>
    <button class="upvote-btn" data-question-id="{{ $question->id }}">Upvote</button>
    <span class="vote-count" data-question-id="{{ $question->id }}">{{ $question->upvotes }}</span>
    <button class="downvote-btn" data-question-id="{{ $question->id }}">Downvote</button>
</div>
    <h3>Answers:</h3>
    <ul>
        @each('partials.answer', $question->answers()->orderBy('id')->get(), 'answer')
    </ul>

    <form class="new_answer">
        <input type="text" name="content" placeholder="new answer">
    </form>
</article>
