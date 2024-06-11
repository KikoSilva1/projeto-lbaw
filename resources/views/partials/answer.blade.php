<li class="answer" data-id="{{$answer->id}}">
    <label>
        <span>{{ $answer->content }}</span>
        <p>Answered by:<a href="{{ route('user.showFromAnswers', ['answerId' => $answer->id]) }}"> {{ $answer->user->name }}</a></p>
    </label>
</li>