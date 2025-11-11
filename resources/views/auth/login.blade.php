@extends('layouts.app')
@section('content')
    <section class="sign-main">
        <div class="sign-1">
            <div class="container">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <img src="{{ asset('storage/logos/1739371318_header.png') }}" class="profile-img" />
                    <h3 class="sign1-a">Welcome Back</h3>
                    <input type="email" name="email" class="sign-email" placeholder="Email" required />
                    <input type="password" name="password" class="sign-email" placeholder="Password" required />
                    <p class="sign1-b">Don’t have an account? <a href="{{ route('register') }}"> Sign Up </a> here.</p>
                    <input type="submit" class="sign-btn" value="Sign In" />
                </form>
            </div>
        </div>
    </section>
@endsection
