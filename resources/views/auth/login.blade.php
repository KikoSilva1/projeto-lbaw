@extends('layouts.app',  ['noSidebar' => true])

@section('content')

<!-- the login form is defined in a Blade view, and the form's action 
attribute is set to {{ route('login') }}. This means the form will be submitted to the route named 'login'. -->

<!-- The form data includes the user's login credentials, such as the email or username and password.
 This data is submitted as part of the HTTP POST request when the user submits the login form. -->

 <!-- After a successful login, Laravel often redirects the user to a specific URL. 
 This URL may be included in the form as a hidden input or determined by the controller logic. 
 The URL provides the destination page after the login is complete. -->

<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <label for="password" >Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <label>
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
    </label>

    <button type="submit">
        Login
    </button>
    <a class="button button-outline" href="{{ route('register') }}">Register</a>
    @if (session('success'))
        <p class="success">
            {{ session('success') }}
        </p>
    @endif
</form>
@endsection