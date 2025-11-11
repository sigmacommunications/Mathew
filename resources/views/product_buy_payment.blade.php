@extends('layouts.app')

@section('content')
     <section class="product">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <!-- <div class="product-img--main" data-scale="1.2">
                        <img src="./assets/images/product-1.jpg" />
                    </div> -->

                    <div class="product-img--main" data-scale="1.5">
                        <img class="product-img--main__image" src="{{ asset('assets/images/product-1.jpg') }}" alt="Product Image">
                    </div>
                </div>
                <div class="col-md-6">
                    <h3 class="product1-a">TRANSCRIPT #3 </h3>
                    <h3 class="product1-b">$199.99 – $599.99 </h3>

                    <label for="cars">Transcript</label>
                    <select name="transcript" id="transcript">
                        <option value="">Choose an option</option>
                        <option value="complete-transcript">Complete Transcript</option>
                        <option value="process-server">Process server</option>
                        <option value="defendant">Defendant</option>
                    </select>
                
                    <h3 class="product1-b" id="selected-price">$599.99</h3>

                    <button id="add-to-cart" class="addtocart-btn">Add To Cart</button>

                    <div class="tab">
                        <button class="tablinks active" onclick="openCity(event, 'issues')">Issues</button>
                        <button class="tablinks" onclick="openCity(event, 'who-testified')">Who Testified</button>
                    </div>

                    <div id="issues" class="tabcontent" style="display: block;">
                        <p>Validity of CPLR 308(2) substituted service. <br><br>

                            -Process server’s testimony re: <br><br>

                            (i) log book and field sheet as business records; <br><br>

                            (ii) NYC Dept. of Consumer Affairs recordkeeping requirements for process servers; <br><br>

                            (iii) GPS photos as part of process server’s proof.</p>
                    </div>

                    <div id="who-testified" class="tabcontent">
                        <p>-Process server (direct examination; cross-examination) <br><br>

                            -Defendant (direct examination; cross-examination)</p>
                    </div>
                </div>
            </div>
        </div>
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
                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
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

    // Get the elements
    const priceRange = document.getElementById('price-range');
    const selectedPrice = document.getElementById('selected-price');
    const addToCartBtn = document.getElementById('add-to-cart');
    const transcriptSelect = document.getElementById('transcript');

    // Define the price for each transcript option
    const prices = {
        'complete-transcript': 199.99,
        'process-server': 399.99,
        'defendant': 599.99
    };

    // Event listener for the select element
    transcriptSelect.addEventListener('change', function() {
        const selectedOption = this.value;
        const price = prices[selectedOption];

        // Update the displayed price and Add to Cart button behavior
        if (price) {
            selectedPrice.textContent = '$' + price.toFixed(2);
            addToCartBtn.href = '#'; // You can set the actual URL for Add to Cart
        } else {
            selectedPrice.textContent = priceRange.textContent;
            addToCartBtn.href = '#'; // You can set the default behavior or disable the button
        }
    });
    // Payment next page
    document.getElementById('add-to-cart').addEventListener('click', function() {
    var selectedTranscript = document.getElementById('transcript').value;
    if (selectedTranscript) {
        // Send an AJAX request to the server
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "{{ route('payment') }}?transcript=" + selectedTranscript, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Redirect to the payment page upon successful response
                window.location.href = xhr.responseText;
            }
        };
        xhr.send();
    } else {
        alert("Please select a transcript option.");
    }
});
</script>
@endsection
