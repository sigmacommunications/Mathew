@extends('user.layouts.app')

<style>
    /* Add your custom CSS styles here */
    .form-previews__item {
        margin-bottom: 20px;
        background: #fff;
    }

    .form-preview {
        position: relative;
        cursor: pointer;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: box-shadow 0.3s;
    }

    .form-preview:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-preview__top {
        flex: 1;
        position: relative;
    }

    .form-preview__image {
        width: 100%;
        height: 39%;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border: 10px solid #fff;
        /* Outer border color and size */
        position: relative;
    }

    .form-preview__image::before {
        content: "";
        position: absolute;
        top: 3px;
        /* Adjust the distance of the inner border from the outer border */
        left: 3px;
        /* Adjust the distance of the inner border from the outer border */
        right: 3px;
        /* Adjust the distance of the inner border from the outer border */
        bottom: 3px;
        /* Adjust the distance of the inner border from the outer border */
        border: 1px solid #ffa500;
        /* Inner border color and size */
        border-radius: 5px;
        /* Same as the outer border radius */
    }

    .form-preview__bottom {
        padding: 15px;
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        box-sizing: border-box;
        overflow: hidden;
        max-height: 0;
        /* Set initial max height to 0 */
        transition: max-height 0.3s;
        transform-origin: top;
        transform: scaleY(0);
    }

    .form-preview:hover .form-preview__bottom {
        max-height: 200px;
        /* Adjust as needed */
        transform: scaleY(1);
    }

    .form-preview__action {
        text-align: center;
        /* Center the button text */
        background-color: #fff;
        /* Set button background color to white */
        padding: 15px;
        /* Add padding to the button container */
    }

    .button--bordered {
        padding: 4px 79px;
        /* border: 1px solid #ffa500; */
        color: #ffa500;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    .form-preview:hover .button--bordered {
        background-color: #ffa500;
        /* Light orange on hover */
        color: #fff;
    }

    .form-preview__title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .form-preview__title1 {
        font-size: 18px;
        font-weight: bold;
        padding: 15px;
        margin-bottom: 10px;
    }

    .form-preview__description {
        font-size: 14px;
        line-height: 1.5;
        overflow: hidden;
    }

    .form-preview__bottom:hover .form-preview__description {
        max-height: 200px;
        /* Adjust as needed */
    }
</style>

@section('content')
    <section class="page-section page-section--search-results">
        <div class="page-section__inner">
            <div class="search-results-wrapper js-search-results-wrapper">
                <div class="no-results js-search-results-no-results" style="display: none;">No results. Please check your
                    spelling or try another term.</div>
                <div class="search-results js-search-results">
                    <div class="row">
                        <!-- Paid Files -->
                        @if (isset($paidFiles) && count($paidFiles) > 0)
                            <div class="col-md-12">
                                <h4>Paid Transcript Files</h4>
                            </div>
                            <br><br>
                            @foreach ($paidFiles as $file)
                                <div class="col-md-4">
                                    <div class="form-previews__item">
                                        <div tabindex="0" data-form-id="{{ asset('storage/' . $file->path) }}"
                                            class="form-preview form-preview--with-description">
                                            <div class="form-preview__top">
                                                @if ($file->isPdf())
                                                    <!-- Display a PDF icon or link -->
                                                    <a href="{{ asset('storage/' . $file->path) }}" target="_blank">
                                                        <img class="form-preview__image"
                                                            src="{{ asset('storage/' . $file->cover_image) }}"
                                                            alt="Form preview" loading="lazy">
                                                    </a>
                                                @else
                                                    <!-- Display the image for non-PDF files -->
                                                    <img class="form-preview__image"
                                                        src="{{ asset('storage/' . $file->cover_image) }}"
                                                        alt="Form preview" loading="lazy">
                                                    <!-- Check if the file is an image and needs conversion -->
                                                    @if ($file->isImage())
                                                        <!-- Assuming convert_image is a function that converts the image -->
                                                        @php
                                                            $convertedImagePath = convert_image(
                                                                'storage/' . $file->path,
                                                            );
                                                        @endphp
                                                        <img class="form-preview__image"
                                                            src="{{ asset($convertedImagePath) }}" alt="Converted Image"
                                                            loading="lazy">
                                                    @endif
                                                @endif
                                                <div class="form-preview__title1">{{ $file->title }}</div>
                                                <div class="form-preview__bottom">
                                                    <div class="form-preview__title">{{ $file->title }}</div>
                                                    <div class="form-preview__description">{{ $file->description }}</div>
                                                </div>
                                            </div>

                                            <div class="form-preview__action">
                                                <a href="{{ asset('storage/' . $file->FileCategory->first()->file_path) }}"
                                                    class="button button--bordered fill-now-button"
                                                    style="background-color: green; color: white;">Fill Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="row">
                        @if (isset($unpaidFiles) && count($unpaidFiles) > 0)
                            <div class="col-md-12">
                                <h4>Unpaid Transcript Files</h4>
                            </div>
                            <br><br>
                            <!-- Unpaid Files -->
                            @foreach ($unpaidFiles as $file)
                                <div class="col-md-4">
                                    <div class="form-previews__item">
                                        <div tabindex="0" data-form-id="{{ asset('storage/' . $file->path) }}"
                                            class="form-preview form-preview--with-description">
                                            <div class="form-preview__top">
                                                @if ($file->isPdf())
                                                    <!-- Display a PDF icon or link -->
                                                    <a href="{{ route('checkPurchaseStatus', $file->id) }}"
                                                        target="_blank">
                                                        <img class="form-preview__image"
                                                            src="{{ asset('storage/' . $file->cover_image) }}"
                                                            alt="Form preview" loading="lazy">
                                                    </a>
                                                @else
                                                    <!-- Display the image for non-PDF files -->
                                                    <img class="form-preview__image"
                                                        src="{{ asset('storage/' . $file->cover_image) }}"
                                                        alt="Form preview" loading="lazy">
                                                    <!-- Check if the file is an image and needs conversion -->
                                                    @if ($file->isImage())
                                                        <!-- Assuming convert_image is a function that converts the image -->
                                                        @php
                                                            $convertedImagePath = convert_image(
                                                                'storage/' . $file->path,
                                                            );
                                                        @endphp
                                                        <img class="form-preview__image"
                                                            src="{{ asset($convertedImagePath) }}" alt="Converted Image"
                                                            loading="lazy">
                                                    @endif
                                                @endif
                                                <div class="form-preview__title1">{{ $file->title }}</div>
                                                <div class="form-preview__bottom">
                                                    <div class="form-preview__title">{{ $file->title }}</div>
                                                    <div class="form-preview__description">{{ $file->description }}</div>
                                                </div>
                                            </div>

                                            <div class="form-preview__action">
                                                <a href="{{ route('studymaterial.view', $file->id) }}"
                                                    class="button button--bordered fill-now-button"
                                                    style="background-color: red; color: white;">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
