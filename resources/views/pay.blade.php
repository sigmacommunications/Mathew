<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
     <style>
        .alert.parsley {
            margin-top: 5px;
            margin-bottom: 0px;
            padding: 10px 15px 10px 15px;
        }
        .check .alert {
            margin-top: 20px;
        }
        .credit-card-box .panel-title {
            display: inline;
            font-weight: bold;
        }
        .credit-card-box .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 100%;
        }
        .credit-card-box .display-tr {
            display: table-row;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
<body id="app-layout">
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1 class="text-primary text-center">
          <strong> Subscription Plan</strong>
        </h1>
    </div>
</div>
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default credit-card-box">
        <div class="panel-heading display-table" >
            <div class="row display-tr" >
                <strong>Subscription</strong>
            </div>                    
        </div>
        <div class="panel-body">
            <div class="col-md-12">
             <form method="POST" action="{{ route('order-post') }}"  data-parsley-validate id="payment-form">
                @csrf
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="form-group" id="product-group">
                    <label for="plane">Select Plan:</label>
                    <select name="plan" id="plan" class="form-control" required data-parsley-class-handler="#product-group" disable>
                        <option value="{{ $package->id }}">{{ $package->name }}  (${{ $package->amount }})</option>
                    </select>
    </div>
    
    <div class="form-group" id="cc-group">
        <label for="credit_card_number">Credit card number:</label>
        <input type="text" name="credit_card_number" id="credit_card_number" class="form-control" required data-stripe="number" data-parsley-type="number" maxlength="16" data-parsley-trigger="change focusout" data-parsley-class-handler="#cc-group">
    </div>
    <div class="form-group" id="ccv-group">
        <label for="cvc">CVC (3 or 4 digit number):</label>
        <input type="text" name="cvc" id="cvc" class="form-control" required data-stripe="cvc" data-parsley-type="number" data-parsley-trigger="change focusout" maxlength="4" data-parsley-class-handler="#ccv-group">
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group" id="exp-m-group">
                <label for="exp_month">Ex. Month</label>
                <select name="exp_month" id="exp_month" class="form-control" required data-stripe="exp-month">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" id="exp-y-group">
                <label for="exp_year">Ex. Year</label>
                <select name="exp_year" id="exp_year" class="form-control" required data-stripe="exp-year">
                    @php
                        $currentYear = date('Y');
                    @endphp
                    @for ($i = $currentYear; $i <= $currentYear + 10; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-lg btn-block btn-primary btn-order" id="submitBtn" style="margin-bottom: 10px;">Place order!</button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <span class="payment-errors" style="color: red;margin-top:10px;"></span>
        </div>
    </div>
</form>
            </div>
        </div>
    </div>
    
  </div>
</div>
    
       <script>
        window.ParsleyConfig = {
            errorsWrapper: '<div></div>',
            errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
            errorClass: 'has-error',
            successClass: 'has-success'
        };
    </script>
    
    <script src="http://parsleyjs.org/dist/parsley.js"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        Stripe.setPublishableKey("<?php echo env('STRIPE_KEY') ?>");
        jQuery(function($) {
            $('#payment-form').submit(function(event) {
                var $form = $(this);
                $form.parsley().subscribe('parsley:form:validate', function(formInstance) {
                    formInstance.submitEvent.preventDefault();
                    alert();
                    return false;
                });
                $form.find('#submitBtn').prop('disabled', true);
                Stripe.card.createToken($form, stripeResponseHandler);
                return false;
            });
        });
        function stripeResponseHandler(status, response) {
            var $form = $('#payment-form');
            if (response.error) {
                $form.find('.payment-errors').text(response.error.message);
                $form.find('.payment-errors').addClass('alert alert-danger');
                $form.find('#submitBtn').prop('disabled', false);
                $('#submitBtn').button('reset');
            } else {
                var token = response.id;
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                $form.get(0).submit();
            }
        };
    </script>
</body>
</html>