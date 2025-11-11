@extends('layouts.master')

@section('title', 'Study Material')

@push('styles')
    <style>
        .product-title {
            font-size: 24px;
            font-weight: bold;
        }

        .price-range,
        .selected-price {
            font-size: 18px;
            margin: 10px 0;
        }

        .transcript-label {
            font-weight: bold;
            margin-top: 15px;
        }

        .form-select,
        .add-to-cart-btn {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }

        .add-to-cart-btn {
            background-color: #007bff;
            color: white;
            border: none;
            font-weight: bold;
        }

        .tab-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .tab-btn {
            padding: 10px 15px;
            border: none;
            background-color: #ddd;
            cursor: pointer;
            font-weight: bold;
            border-radius: 4px;
        }

        .tab-btn.active {
            background-color: #007bff;
            color: white;
        }

        .content-list,
        .sub-list {
            list-style-type: none;
            padding-left: 0;
        }

        .content-list li,
        .sub-list li {
            padding-left: 20px;
            position: relative;
            margin-bottom: 8px;
        }

        .content-list li:before {
            content: "-";
            position: absolute;
            left: 0;
        }

        .sub-list li:before {
            content: "•";
            position: absolute;
            left: 5px;
        }
    </style>
@endpush

@section('content')
    <section class="inner-pg-sec1">
        <div class="main-div">
            <h1>Study Material Detail</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ucorper purus ac vulputate tellus.</p>
        </div>
    </section>

    <!-- Modal -->

    <div class="modal fade" id="buyNowModal" tabindex="-1" role="dialog" aria-labelledby="subscriptionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: #f1bd4d;">
                <div class="modal-header">
                    <h5 class="modal-title">Checkout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="payment-form" method="POST" action="{{ route('user.buy.now') }}">
                        @csrf
                        <!-- Hidden fields -->
                        <input type="hidden" name="amount" id="selected-price2">
                        <input type="hidden" name="id" value="{{ $details->id }}">
                        <input type="hidden" name="cat_id" id="category-id">
                        <input type="hidden" name="stripeToken" id="stripe-token">

                        <!-- Display amount -->
                        <div class="mb-3">
                            <label>Amount</label>
                            <input type="text" id="selected-price1" class="form-control" disabled>
                        </div>

                        <!-- Payment Method Select -->
                        <div class="mb-3">
                            <label>Payment Method</label>
                            <select id="payment-method" class="form-select" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="stripe">Stripe</option>
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>

                        <!-- Name on Card -->
                        <div id="stripe-fields">
                            <!-- Name on Card -->
                            <div class="mb-3">
                                <label>Name on Card</label>
                                <input type="text" id="card-name" class="form-control">
                            </div>

                            <!-- Stripe Card Element -->
                            <div class="mb-3">
                                <label>Card Details</label>
                                <div id="card-element" class="form-control p-2 bg-white rounded"></div>
                                <div id="card-errors" class="text-danger mt-2"></div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-dark w-100" id="submit-btn">Pay Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--End Modal-->



    <section class="product py-4">
        <div class="container">
            <div class="row">
                <!-- Image Left -->
                <div class="col-md-6 mb-4">
                    <div>
                        <img src="{{ asset('storage/' . $details->cover_image) }}" alt="Product Image"
                            class="img-fluid rounded">
                    </div>
                </div>

                <!-- Content Right -->
                <div class="col-md-6">
                    <h2 class="product-title">{{ $details->title }}</h2>
                    <p class="price-range">
                        ${{ $minPrice != $maxPrice ? "$minPrice - $maxPrice" : $minPrice }}
                    </p>

                    <label class="transcript-label" for="transcript">Category</label>
                    <select id="category-select" class="form-select" name="transcript">
                        <option value="">Choose an option</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" data-price="{{ $category->amount }}"
                                data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="selected-price" id="selected-price">$0.00</div>

                    @auth
                        <button id="add-to-cart" class="add-to-cart-btn"
                            data-logged-in="{{ auth()->check() ? 'true' : 'false' }}">
                            Add To Cart
                        </button>
                    @else
                        <button id="add-to-cart" class="add-to-cart-btn"> Add To Cart </button>
                    @endauth

                    <div id="error-message" class="text-danger mt-2"></div>

                    <div class="tab-container">
                        <div class="tab-buttons">
                            <button class="tab-btn active" data-tab="issues">Issues</button>
                            <button class="tab-btn" data-tab="testified">Who Testified</button>
                        </div>

                        <div class="tab-content" id="issues">
                            <ul class="content-list" style="padding:15px;">
                                {{-- @foreach ($details as $detail) --}}
                                {!! $details->author !!}
                                {{-- @endforeach --}}
                            </ul>
                        </div>

                        <div class="tab-content" id="testified" style="display: none;">
                            <ul class="content-list" style="padding:15px;">
                                {!! $details->testified !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = btn.getAttribute('data-tab');

                    tabButtons.forEach(b => b.classList.remove('active'));
                    tabContents.forEach(c => c.style.display = 'none');

                    btn.classList.add('active');
                    document.getElementById(target).style.display = 'block';
                });
            });
        });
    </script>

    <script>
        document.getElementById('category-select').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var price = selectedOption.getAttribute('data-price') || '0.00';
            document.getElementById('selected-price').textContent = `$${parseFloat(price).toFixed(2)}`;
        });

        // Trigger once on page load (optional)
        document.getElementById('category-select').dispatchEvent(new Event('change'));
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartBtn = document.getElementById('add-to-cart');
            const categorySelect = document.getElementById('category-select');
            const isLoggedIn = addToCartBtn.getAttribute('data-logged-in') === 'true';

            addToCartBtn.addEventListener('click', function(event) {
                if (!isLoggedIn) {
                    toastr.info("Please log in to continue!");
                    setTimeout(function() {
                        window.location.href = "{{ route('login') }}";
                    }, 2000);
                    return;
                }

                const selectedValue = categorySelect.value;
                if (!selectedValue) {
                    toastr.error('Please select the Category');
                    return;
                }

                const modal = new bootstrap.Modal(document.getElementById('buyNowModal'));
                modal.show();

                const selectedOption = categorySelect.options[categorySelect.selectedIndex];
                document.getElementById('selected-price1').value = selectedOption.getAttribute(
                    'data-price');
                document.getElementById('selected-price2').value = selectedOption.getAttribute(
                    'data-price');
                document.getElementById('category-id').value = selectedOption.getAttribute(
                    'data-category-id');
            });
        });
    </script>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const stripe = Stripe("{{ config('services.stripe.key') }}");
            const elements = stripe.elements();
            const card = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#32325d'
                    }
                }
            });
            card.mount('#card-element');

            const form = document.getElementById('payment-form');
            const submitBtn = document.getElementById('submit-btn');
            const errorDisplay = document.getElementById('card-errors');
            const paymentMethodSelect = document.getElementById('payment-method');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                submitBtn.disabled = true;

                const selectedMethod = paymentMethodSelect.value;
                if (!selectedMethod) {
                    toastr.error('Please select a payment method.');
                    submitBtn.disabled = false;
                    return;
                }

                if (selectedMethod === 'stripe') {
                    const cardName = document.getElementById('card-name').value;
                    stripe.createToken(card, {
                        name: cardName
                    }).then(function(result) {
                        if (result.error) {
                            errorDisplay.textContent = result.error.message;
                            submitBtn.disabled = false;
                        } else {
                            document.getElementById('stripe-token').value = result.token.id;
                            form.submit();
                        }
                    });
                } else if (selectedMethod === 'paypal') {
                    form.submit(); // Let Laravel handle redirect to PayPal
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethodSelect = document.getElementById('payment-method');
            const stripeFields = document.getElementById('stripe-fields');

            // Initially hide Stripe fields
            stripeFields.style.display = 'none';

            paymentMethodSelect.addEventListener('change', function() {
                if (this.value === 'stripe') {
                    stripeFields.style.display = 'block';
                } else {
                    stripeFields.style.display = 'none';
                }
            });
        });
    </script>
@endpush
