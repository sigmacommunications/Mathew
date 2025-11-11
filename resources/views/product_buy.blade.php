@extends('layouts.app')
<style>
    #lable{
        font-size: 13px;
    }
    span{
        font-size:15px;
        color:red;
    }
    .error-message {
        color: red;
        font-weight: bold;
        font-size: 15px;
    }

    .error-category {
        color:blue;
    }
   
</style>
@section('content')
     <section class="product">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="product-img--main" data-scale="1.5">
                        <img class="product-img--main__image" src="{{ asset('storage/' . $product->cover_image) }}" alt="Product Image">
                    </div>
                </div>
                <div class="col-md-6">
                    
                   <h3 class="product1-a">{{ $product->title }} </h3>

                    @php
                        $minPrice = $product->fileCategory->min('amount');
                        $maxPrice = $product->fileCategory->max('amount');
                    @endphp
                    
                    @if($minPrice === $maxPrice)
                        <h3 class="product1-b">${{ $minPrice }}</h3>
                    @else
                        <h3 class="product1-b">${{ $minPrice }} – ${{ $maxPrice }}</h3>
                    @endif
                    
                    <!--$product->purchases->category_id -->
                    <label for="cars">Transcript</label>
                    <select name="transcript" id="transcript">
                        <option value="">Choose an option</option>
                        @foreach($product->fileCategory as $category)
                            <option value="{{ $category->Category->id }}" data-price="{{ $category->amount }}" data-category-id="{{ $category->Category->id }}" data-category-name="{{ $category->Category->name }}">{{ $category->Category->name }}</option>
                        @endforeach
                    </select>

                    <h3 class="product1-b" id="selected-price">$599.99</h3>
                    <span id="error-message"></span>
                    <a href="#" id="add-to-cart" class="addtocart-btn" data-bs-toggle="modal" >Add To Cart</a>
                    <br/>
                    <div class="tab">
                        <button class="tablinks active" onclick="openCity(event, 'issues')">Issues</button>
                        <button class="tablinks" onclick="openCity(event, 'who-testified')">Who Testified</button>
                    </div>

                    <div id="issues" class="tabcontent" style="display: block;">
                        <p>{!! $product->author !!}</p>
                    </div>

                    <div id="who-testified" class="tabcontent">
                        <p>{!! $product->testified !!}</p>
                    </div>
                </div>
            </div>
        </div>


                <!-- Modal -->
                <div class="modal fade" id="buyNowModal" tabindex="-1" role="dialog" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                    <div class="modal-content" style="background-color: #f1bd4d;">
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="subscriptionModalLabel">Checkout</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if (Session::has('success'))
                            <div class="alert alert-success text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p>{{ Session::get('success') }}</p>
                            </div>
                            @endif

                            <form role="form" action="{{ route('user.buy.now') }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                @csrf

                <div class='mb-2'>
                    <label for="selected-price1" class="form-label">Amount</label>
                    <input type="text" name="price" class="form-control" placeholder="Amount" id="selected-price1" disabled>
                    <input type="hidden" name="amount" id="selected-price2">
                    <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="cat_id" id="category-id">
                </div>
                <div class='row mb-3'>
                    <div class='col-md-6'>
                        <label for="card-name" class='control-label' id="lable" >Name on Card</label>
                        <input id="card-name" class='form-control' size='4' type='text'>
                    </div>
                    <div class='col-md-6'>
                        <label for="card-number" class='control-label' id="lable" >Card Number</label>
                        <input id="card-number" autocomplete='off' class='form-control card-number' size='20' type='text' placeholder='4242 4242 4242 4242' maxlength="16">
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-4 mb-3'>
                        <label for="card-cvc" class='control-label' id="lable" >CVC</label>
                        <input id="card-cvc" autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                    </div>
                    <div class='col-md-4 mb-3'> 
                        <label for="card-expiry-month" class='control-label' id="lable" >Expiration Month</label>
                        <input id="card-expiry-month" class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                    </div>
                    <div class='col-md-4 mb-3'>
                        <label for="card-expiry-year" class='control-label' id="lable" >Expiration Year</label>
                        <input id="card-expiry-year" class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                    </div>
                </div>
                <div class='form-row row'>
                    <div class='col-md-12 error form-group hide'>
                        <div class='alert-danger alert' style="background: aliceblue;">Please correct the errors and try again.</div>
                    </div>
                </div>
                <div class="form-row row">
                    <div class="col-xs-12">
                        <button class="btn btn-danger btn-lg btn-block" type="submit">Pay Now</button>
                    </div>
                </div>
            </form>

            </div>
        </div>
    </div>
</div>        
<!--End Modal-->
    </section>

@endsection

    @section('scripts')
        
        <script src="https://js.stripe.com/v2/"></script>
        <script type="text/javascript">
        $(document).ready(function() {
            var $form = $(".require-validation");
            $form.on('submit', function(e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');
                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                // Retrieve card number value
                var cardNumber = $('#card-number').val();

                // Validate card number
                if (!isValidCardNumber(cardNumber)) {
                    $('#card-number').parent().addClass('has-error');
                    $errorMessage.removeClass('hide').text('Please enter a valid credit card number');
                    e.preventDefault();
                    return;
                }

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: cardNumber, // Pass the card number value here
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }
            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    /* token contains id, last4, and card type */
                    var token = response['id'];
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }

            function isValidCardNumber(cardNumber) {
                // Implement card number validation logic here
                // You can use a library like Luhn algorithm or regex pattern matching to validate the card number
                // Here's an example of Luhn algorithm implementation:
                var sum = 0;
                var shouldDouble = false;
                for (var i = cardNumber.length - 1; i >= 0; i--) {
                    var digit = parseInt(cardNumber.charAt(i));

                    if (shouldDouble) {
                        if ((digit *= 2) > 9) digit -= 9;
                    }

                    sum += digit;
                    shouldDouble = !shouldDouble;
                }
                return (sum % 10) == 0;
            }
        });
 
        $('.product-img--main')
            // tile mouse actions
            .on('mouseover', function () {
                $(this).find('.product-img--main__image').css({ 'transform': 'scale(' + $(this).attr('data-scale') + ')' });
            })
            .on('mouseout', function () {
                $(this).find('.product-img--main__image').css({ 'transform': 'scale(1)' });
            })
            .on('mousemove', function (e) {
                $(this).find('.product-img--main__image').css({ 'transform-origin': ((e.pageX - $(this).offset().left) / $(this).width()) * 100 + '% ' + ((e.pageY - $(this).offset().top) / $(this).height()) * 100 + '%' });
            });

        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        const priceRange = document.getElementById('price-range');
        const selectedPrice = document.getElementById('selected-price');
        const selectedPriceInput = document.getElementById('selected-price2');
        const addToCartBtn = document.getElementById('add-to-cart');
        const transcriptSelect = document.getElementById('transcript');
        
        // Event listener for the select element
        document.addEventListener('DOMContentLoaded', function() {
            // Get the elements
            const selectedPriceElement = document.getElementById('selected-price');
            const selectedPriceInput1 = document.getElementById('selected-price1');
            const selectedPriceInput2 = document.getElementById('selected-price2');
            const transcriptSelect = document.getElementById('transcript');
            const categoryIdInput = document.getElementById('category-id');
            
            
                // Event listener for the select element
                transcriptSelect.addEventListener('change', function() {
                    const selectedOptionPrice = this.options[this.selectedIndex].getAttribute('data-price');
                    const selectedOptionCategoryId = this.options[this.selectedIndex].getAttribute('data-category-id'); // Get the category ID
                    const selectedOptionCategoryName = this.options[this.selectedIndex].getAttribute('data-category-name');
                       
                    const authUserId = {{ auth()->id() ?? 'null' }};
                    // Update the displayed price
                    if (selectedOptionPrice && selectedOptionCategoryId) {
                        selectedPriceElement.textContent = '$' + selectedOptionPrice;

                        selectedPriceInput1.value = '$' + selectedOptionPrice; // Set the value of the input field with id selected-price1
                        selectedPriceInput2.value = selectedOptionPrice; // Set the value of the hidden input field with id selected-price2
                        categoryIdInput.value = selectedOptionCategoryId;
                        
                        const productCategories = @json($product->purchases->toArray());
                        
                        // Check if the selected option's category ID and user ID match any purchase
                        const matchingPurchase = productCategories.find(purchase => {
                            return purchase.category_id === parseInt(selectedOptionCategoryId) && purchase.user_id === authUserId;
                        });

                        if (matchingPurchase) {
                            // Hide the "Add To Cart" button
                            document.getElementById('add-to-cart').style.display = 'none';
                            document.getElementById('error-message').innerHTML = 'This item cannot be added to the cart <span class="error-category">' + selectedOptionCategoryName + '</span> has already been purchased.<br>';

                        } else {
                            // Show the "Add To Cart" button
                            document.getElementById('add-to-cart').style.display = 'block flex';
                            // Clear error message
                            document.getElementById('error-message').innerText = '';
                        }

                    } else {
                        // Handle the case when price is not available
                        console.error('Price not available for selected option');
                    }
                });
        });

        //add to cart
        document.getElementById('add-to-cart').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default anchor behavior
            var selectedTranscript = document.getElementById('transcript').value;
            
            if (selectedTranscript) {
                // Check if the user is authenticated
                var isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
                
                if (isAuthenticated) {
                    $('#buyNowModal').modal('show');
                    var xhr = new XMLHttpRequest();
                
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Redirect to the payment page upon successful response
                            window.location.href = xhr.responseText;
                        }
                    };
                    xhr.send("transcript=" + selectedTranscript);
                } else {
                    alert("Please login first to add items to the cart.");
                    window.location.href = "{{ route('login') }}";
                }
            } else {
                // If transcript option is not selected, show an alert without opening the modal
                alert("Please select a transcript option.");
                $('#buyNowModal').modal('hide'); // Hide the modal if it's currently open
            }
        });

      

</script>
@endsection
