@extends('layouts.app')

@section('content')


<link href='' rel='stylesheet'>
         
<style>

a {
    text-decoration: none;
}

.pricingTable {
    text-align: center;
    background: #fff;
        margin: -8px -3px 15px -7px;
    box-shadow: 0 0 10px #ababab;
    padding-bottom: 40px;
    border-radius: 10px;
    color: #b12a2a;
    transform: scale(1);
    transition: all .5s ease 0s
}

.pricingTable:hover {
    transform: scale(1.05);
    z-index: 1
}

.pricingTable .pricingTable-header {
    padding: 40px 0;
    background: #f5f6f9;
    border-radius: 10px 10px 50% 50%;
    transition: all .5s ease 0s
}

.pricingTable:hover .pricingTable-header {
    background: #ff9624
}

.pricingTable .pricingTable-header i {
    font-size: 50px;
    color: #858c9a;
    margin-bottom: 10px;
    transition: all .5s ease 0s
}

.pricingTable .price-value {
    font-size: 35px;
    color: #f27f02fc;
    font-weight: bold;
    transition: all .5s ease 0s;
}

.pricingTable .month {
    display: block;
    font-size: 14px;
    color: #cad0de
}

.pricingTable:hover .month,
.pricingTable:hover .price-value,
.pricingTable:hover .pricingTable-header i {
    color: #fff
}

.pricingTable .heading {
    font-size: 24px;
    color: #ff9624;
    margin-bottom: 20px;
    text-transform: uppercase
}

.pricingTable .heading1 {
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 20px;
    text-transform: uppercase;
}



.pricingTable .pricing-content ul {
    list-style: none;
    padding: 0;
    margin-bottom: 30px
}

.pricingTable .pricing-content ul li {
    line-height: 30px;
    color: #a7a8aa
}

.pricingTable .pricingTable-signup a {
    display: inline-block;
    font-size: 15px;
    color: #fff;
    padding: 10px 35px;
    border-radius: 20px;
    background: #ffa442;
    text-transform: uppercase;
    transition: all .3s ease 0s
}

.pricingTable .pricingTable-signup a:hover {
    box-shadow: 0 0 10px #ffa442
}

.pricingTable.blue .heading,
.pricingTable.blue .price-value {
    color: #4b64ff
}

.pricingTable.blue .pricingTable-signup a,
.pricingTable.blue:hover .pricingTable-header {
    background: #4b64ff
}

.pricingTable.blue .pricingTable-signup a:hover {
    box-shadow: 0 0 10px #4b64ff
}

.pricingTable.red .heading,
.pricingTable.red .price-value {
    color: #ff4b4b
}

.pricingTable.red .pricingTable-signup a,
.pricingTable.red:hover .pricingTable-header {
    background: #ff4b4b
}

.pricingTable.red .pricingTable-signup a:hover {
    box-shadow: 0 0 10px #ff4b4b
}

.pricingTable.green .heading,
.pricingTable.green .price-value {
    color: #40c952
}

.pricingTable.green .pricingTable-signup a,
.pricingTable.green:hover .pricingTable-header {
    background: #40c952
}

.pricingTable.green .pricingTable-signup a:hover {
    box-shadow: 0 0 10px #40c952
}

.pricingTable.blue:hover .price-value,
.pricingTable.green:hover .price-value,
.pricingTable.red:hover .price-value {
    color: #fff
}

.pricing-content p {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
}

@media screen and (max-width:990px) {
    .pricingTable {
        margin: 0 0 20px
    }
}</style>


<!-- Subscription Modal -->
<div class="modal fade" id="subscriptionModal" tabindex="-1" role="dialog" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="subscriptionModalLabel">Subscribe Now</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
    
                    <form 
                            role="form" 
                            action="{{ route('stripe.post') }}"
                            method="post" 
                            class="require-validation"
                            data-cc-on-file="false"
                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="payment-form">
                        @csrf
    
                        <div class='form-row row'>
                                <div class='col-md-6 form-group required'>
                                        <label>Amount</label>
                                        <input type="text" id="convert_amount" class="form-control" placeholder="Amount" disabled>
								        <input type="hidden" name="amount" id="price" class="form-control" placeholder="Amount">
									<input type="hidden" name="package_id" id="package_id" class="form-control" placeholder=" Amount">
                                      
                                </div>
                                <div class='col-md-6 form-group required'>
                                    <label class='control-label'>Name on Card</label> <input
                                        class='form-control' size='4' type='text'>
                                </div>
                            </div>
    
                        <div class='form-row row'>
                            <div class='col-sm-12 form-group required'>
                                <label class='control-label'>Card Number</label> <input
                                    autocomplete='off' class='form-control card-number' size='20'
                                    type='text'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off'
                                    class='form-control card-cvc' placeholder='ex. 311' size='4'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input
                                    class='form-control card-expiry-month' placeholder='MM' size='2'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input
                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='text'>
                            </div>
                        </div>
                        <br/>
                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'>Please correct the errors and try
                                    again.</div>
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
    <div class="container">
        <div class="demo">
            <div class="container">
                <h4 class="bg3-b" style="color: #ffa442;font-family: cursive;">Subscription Package</h4><br>
                <div class="row">
                    @foreach ($package as $pck)
                        <div class="col-md-4 col-sm-4">
                            <div class="pricingTable">
                                <div class="pricingTable-header">
                                    <div class="price-value">${{ isset($pck->amount) ? $pck->amount : 0 }} </div>
                                    <h5 class="price-value" style="font-size: 13px;">{{ $pck->period }}</h5>
                                </div>
                                <h3 class="heading">{{ $pck->name }}</h3><br />
                                <div style="display: flex; justify-content: center; align-items: center;">
                                    <a href="{{ route('pay.now', $pck->id) }}"
                                        style="display: flex; align-items: center; margin-right: 10px;">
                                        <img src="{{ asset('assets/images/stripe.png') }}" alt="Stripe"
                                            style="width: 94px; height: auto;">
                                    </a>
                                    <form action="{{ route('paypal.payment') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="package_id" value="{{ $pck->id }}">
                                        <input type="hidden" name="amount" value="{{ $pck->amount }}">
                                        <button type="submit" style="border: none; background: none; padding: 0;">
                                            <img src="{{ asset('assets/images/paypal.png') }}" alt="PayPal"
                                                style="width: 100px; height: auto;">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if ($loop->iteration % 4 == 0)
                </div>
                <div class="row">
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
<section>
@endsection
@section('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	<script type="text/javascript">
    
  var $form = $(".require-validation");
  $('form.require-validation').on('submit', function(e) {
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

  $('.subscription-btn').on('click', function() {
    var packageAmount = $(this).data('package-amount');
    var convertAmount = $(this).data('convert-amount');
    var packageId = $(this).data('package-id');
    $('#price').val(packageAmount);
    $('#convert_amount').val(convertAmount);
    $('#package_id').val(packageId);
});

l

</script>
@endsection
