@extends('layouts.master')

@section('title', 'Inner-Blog')
<style>
    .comment-form {
        margin: 0 auto;
        max-width: auto;
        padding: 20px;
    }

    .comment-list {
        list-style: none;
        padding: 0;
    }

    .comment-body {
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .comment-metadata {
        font-style: italic;
        margin-bottom: 10px;
    }

    .comment-content {
        margin-top: 10px;
    }

    #respond {
        margin-top: 40px;
    }

    .comment-reply-title {
        margin-bottom: 20px;
    }

    .form-submit {
        margin-top: 20px;
    }

    input[type="text"],
    input[type="email"],
    input[type="url"],
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    input[type="checkbox"] {
        margin-right: 5px;
    }

    .form-submit .submit {
        display: inline-block;
        font-weight: 400;
        color: #c36;
        text-align: center;
        white-space: nowrap;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid #c36;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        border-radius: 3px;
        font-family: system-ui;
        transition: all .3s;
    }

    .form-submit .submit:hover {
        background: #c36;
        color: #fff;
        transition: 0.3s;
    }

    #comments .comment-list {
        margin: 0;
        padding: 0;
        list-style: none;
        font-size: .9em;
    }

    #comments .comment,
    #comments .pingback {
        position: relative;
    }

    #comments .comment .comment-body,
    #comments .pingback .comment-body {
        display: flex;
        flex-direction: column;
        padding-block-start: 30px;
        padding-block-end: 30px;
        padding-inline-start: 60px;
        padding-inline-end: 0;
        border-block-end: 1px solid #ccc;
    }

    #comments .comment-meta {
        display: flex;
        justify-content: space-between;
        margin-block-end: 0.9rem;
    }

    .innerblog {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .fn {
        color: #c36;
        font-size: 14px;
        text-decoration: underline;
        margin-left: 10px;
    }

    .avatar {
        border-radius: 50%;
    }

    .comment-metadata time {
        color: #c36;
        font-style: normal;
        font-size: 11px;
    }

    .comment-metadata a {
        color: #c36;
    }

    .comment-approve {
        font-size: 13px;
        font-style: italic;
        color: #333;
    }

    .title-comments {
        color: #333;
        font-weight: 500;
        font-size: 28px;
        margin-bottom: 40px;
    }

    .comment-content {
        font-size: 14px;
        color: #333;
        font-family: system-ui;
    }

    .reply-btn {
        font-size: 11px;
        color: #c36;
        margin-top: 10px;
        display: block;
    }

    .comment-blog {
        margin-left: 55px;
    }

    .cancel-reply {
        font-size: 25px;
        color: #c36;
        font-weight: 500;
    }
</style>
@section('content')
    <div class="privacy-main">
        <div class="privacy-bg1">
            <div class="container">
                <h1 class="blogs-h1">{{ $inner_blogs->title }}</h1>
            </div>
        </div>
        <div class="privacy-bg2">
            <div class="container">

                {!! $inner_blogs->description !!}
            

            @if (count($comments) > 0)
                <h3 class="title-comments">{{ count($comments) }} Responses</h3>
                <ol class="comment-list">
                    @foreach ($comments as $comment)
                        <li id="comment-{{ $comment->id }}" class="comment even thread-even depth-1">
                            <article id="div-comment-{{ $comment->id }}" class="comment-body">
                                <div class="comment-author vcard">
                                    <div class="innerblog">
                                        <div class="innerblog1">
                                            <img alt=""
                                                src="https://secure.gravatar.com/avatar/{{ md5(strtolower(trim($comment->email))) }}?s=42&amp;d=mm&amp;r=g"
                                                srcset="https://secure.gravatar.com/avatar/{{ md5(strtolower(trim($comment->email))) }}?s=84&amp;d=mm&amp;r=g 2x"
                                                class="avatar avatar-42 photo" height="42" width="42"
                                                decoding="async">
                                            <b class="fn">{{ $comment->author }}</b> <span class="says">says:</span>
                                        </div>
                                        <!-- .comment-author -->
                                        <div class="comment-metadata">
                                            <a href="#comment-{{ $comment->id }}"><time
                                                    datetime="{{ $comment->created_at }}">{{ $comment->created_at->format('F j, Y \a\t g:i a') }}</time></a>
                                        </div>
                                        <p class="comment-approve">Your comment is awaiting moderation.</p>
                                    </div>
                                </div>

                                <!-- .comment-metadata -->
                                <div class="comment-blog">
                                    <div class="comment-content">
                                        {{ $comment->comment }}
                                    </div>
                                    <!-- .comment-content -->
                                    <!-- Reply button -->
                                    <a class="reply-btn" data-comment-id="{{ $comment->id }}">Reply</a>
                                </div>
                                <!-- Reply form -->

                                <div id="respond" class="comment-respond">

                                    <!-- Show form -->
                                    <form action="{{ route('comments.reply') }}" method="post"
                                        id="reply-form-{{ $comment->id }}" style="display: none;">
                                        @csrf
                                        <!-- Your existing main comment form content here -->
                                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">

                                        <input type="hidden" name="blog_id" value="{{ $inner_blogs->id }}">
                                        <h2 id="reply-title" class="comment-reply-title">Reply to Berk Fisher<a
                                                href="#" class="cancel-reply"
                                                data-comment-id="{{ $comment->id }}">Cancel
                                                reply</a><small>
                                                <a rel="nofollow" id="cancel-comment-reply-link"
                                                    href="/service-of-process-and-personal-jurisdiction/#respond"
                                                    style="display:none;">Cancel reply</a></small>
                                        </h2>
                                        <span id="email-notes">Your email address will not be published. Required fields are
                                            marked *</span>
                                        <p class="comment-form-comment">
                                            <label for="comment">Comment <span class="required">*</span></label>
                                            <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525"></textarea>
                                        </p>
                                        <p class="comment-form-author">
                                            <label for="author">Name <span class="required">*</span></label>
                                            <input id="author" name="author" type="text"
                                                value="{{ $comment->author }}" size="30" maxlength="245"
                                                autocomplete="name" required="">
                                        </p>
                                        <p class="comment-form-email">
                                            <label for="email">Email <span class="required">*</span></label>
                                            <input id="email" name="email" type="email"
                                                value="{{ $comment->email }}" size="30" maxlength="100"
                                                aria-describedby="email-notes" autocomplete="email" required="">
                                        </p>
                                        <p class="comment-form-url">
                                            <label for="url">Website</label>
                                            <input id="url" name="website" type="url"
                                                value="{{ $comment->website }}" size="30" maxlength="200"
                                                autocomplete="url">
                                        </p>
                                        <p class="comment-form-cookies-consent">
                                            <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent"
                                                type="checkbox" value="yes">
                                            <label for="wp-comment-cookies-consent">Save my name, email, and website in
                                                this
                                                browser for the next time I comment.</label>
                                        </p>
                                        <p class="form-submit">
                                            <input name="submit" type="submit" id="submit" class="submit"
                                                value="Reply Comment">
                                        </p>
                                    </form>

                                </div>

                            </article>
                            <!-- .comment-body -->
                        </li>
                        <!-- #comment-## -->
                    @endforeach
                </ol>
                <!-- .comment-list -->
            @else
                <h3 class="title-comments">0 Responses</h3>
            @endif
            <div id="respond" class="comment-respond">

                <!-- Show form -->
                <form action="{{ route('comments.store') }}" method="post" id="show-form">
                    @csrf
                    <!-- Your existing main comment form content here -->
                    <input type="hidden" name="blog_id" value="{{ $inner_blogs->id }}">
                    <h2 id="reply-title" class="comment-reply-title">Leave a Reply <small>
                            <a rel="nofollow" id="cancel-comment-reply-link"
                                href="/service-of-process-and-personal-jurisdiction/#respond" style="display:none;">Cancel
                                reply</a></small>
                    </h2>
                    <span id="email-notes">Your email address will not be published. Required fields are marked *</span>
                    <p class="comment-form-comment">
                        <label for="comment">Comment <span class="required">*</span></label>
                        <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required=""></textarea>
                    </p>
                    <p class="comment-form-author">
                        <label for="author">Name <span class="required">*</span></label>
                        <input id="author" name="author" type="text" value="" size="30"
                            maxlength="245" autocomplete="name" required="">
                    </p>
                    <p class="comment-form-email">
                        <label for="email">Email <span class="required">*</span></label>
                        <input id="email" name="email" type="email" value="" size="30"
                            maxlength="100" aria-describedby="email-notes" autocomplete="email" required="">
                    </p>
                    <p class="comment-form-url">
                        <label for="url">Website</label>
                        <input id="url" name="website" type="url" value="" size="30"
                            maxlength="200" autocomplete="url">
                    </p>
                    <p class="comment-form-cookies-consent">
                        <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox"
                            value="yes">
                        <label for="wp-comment-cookies-consent">Save my name, email, and website in this browser for the
                            next
                            time I comment.</label>
                    </p>
                    <p class="form-submit">
                        <input name="submit" type="submit" id="submit" class="submit" value="Post Comment">
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
