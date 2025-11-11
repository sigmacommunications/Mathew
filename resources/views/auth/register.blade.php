@extends('layouts.app')
@section('content')
    <section class="sign-main">
        <div class="sign-1">
            <div class="container">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h3 class="sign1-a">Hi There! <br> Please Create An Account</h3>
                    <input type="text" class="sign-email" name="name" placeholder="Name" required />
                    <input type="email" class="sign-email" name="email" placeholder="Email" required />
                    <input type="password" class="sign-email" name="password" placeholder="Password" required />
                    <p class="sign1-b">Already have an account?<a href="/"> Sign In </a> here.</p>
                    <input type="submit" class="sign-btn" value="Sign Up" />
                </form>
            </div>
        </div>
    </section>
@endsection