@extends('layouts.default')

	@section('content')	 
	
	<?php // tenantIDis sent in from controller // We sent in Plan
 

if($plan == "" || $plan_price == ""){ Redirect::to('subscription'); } ?>
<?php if(isset($plan) && $plan != ""){

	// set in session
	$chosen_plan = $plan;
	
	// determine item number
	function item_num($chosen_plan, $level){
		$item_number = 0;
		
		if($level == 1){
			switch($chosen_plan){

			case "Premium plan":
			$item_number = 1;
			break;
			
			case "Super Premium plan":
			$item_number = 5;
			break;
			
			default :
			$item_number = 1;
			break;
						
		   }
		} // End if level 1
		
		if($level == 2){
			switch($chosen_plan){

			case "Premium plan":
			$item_number = 2;
			break;
			
			case "Super Premium plan":
			$item_number = 6;
			break;
			
			default :
			$item_number = 1;
			break;
						
		   }
		} // End if level 2
		
		if($level == 3){
			switch($chosen_plan){

			case "Premium plan":
			$item_number = 3;
			break;
			
			case "Super Premium":
			$item_number = 7;
			break;
			
			default :
			$item_number = 1;
			break;
						
		   }
		} // End if level 3
		
		if($level == 4){
			switch($chosen_plan){

			case "Premium plan":
			$item_number = 4;
			break;
			
			case "Super Premium plan":
			$item_number = 8;
			break;
			
			default :
			$item_number = 1;
			break;
						
		   }
		} // End if level 4
		 
		return $item_number;
			
	}

}?>

<?php if(isset($is_verification) && $is_verification == 1): ?>
	<p class="messageboxok">Thank you, your email has been verified. please proceed with your order.</p>	
<?php endif; ?>
	
	<h1><a href="{{ URL::previous() }}">Back &raquo;</a> <?php echo $plan; ?> subscription order</h1>
	 
	 <?php if(isset($plan)): ?>

    <div class="cart_section">   
        <div class="billing_cycle">
            <h3>Prepaid Billing<span class="mand">*</span><br />({{ $plan }}) </h3>
			
			 {{ Form::open(array('url' => 'subscription/card', 'method' => 'POST', 'name' => 'paymentcart')) }}
			 
			 <input type="hidden" value="<?php echo $apply_upgrade_amount == true ?  "yes": "no"; ?>" name="apply_upgrade_amount" id="apply_upgrade_amount" />
   			 <input type="hidden" value="<?php echo $applied_upgrade_amount != 0 ? $applied_upgrade_amount : 0; ?>" name="applied_upgrade_amount" id="applied_upgrade_amount" />
            <fieldset>
            	<input type="hidden" id="thisplan" name="thisplan" value="{{ $plan }}"  />
            	<input type="hidden" id="thisplan_price" name="thisplan_price" value="<?php echo $plan_price; ?>"  />
                <div class="plansel"><input type="radio" name="subcr_duration" class="duration1" lineitem="1" value="{{ item_num($chosen_plan, 1) }}" per_savings="{{ $oneMonthDiscount }}" /> 1 month <span class="savings"></span><div />
                <div class="plansel"><input type="radio" name="subcr_duration" class="duration2" lineitem="2" value="{{ item_num($chosen_plan, 2) }}" per_savings="{{ $threeMonthsDiscount }}" /> 3 months <span class="savings"> (saves {{ $threeMonthsDiscount }}%)</span><div />
                <div class="plansel"><input type="radio" name="subcr_duration" class="duration3" lineitem="3" value="{{ item_num($chosen_plan, 3) }}" per_savings="{{ $sixMonthsDiscount }}" /> 6 months <span class="savings"> (saves {{ $sixMonthsDiscount }}%)</span><div />
                <div class="plansel"><input type="radio" checked="checked" name="subcr_duration" class="duration3" lineitem="4" value="{{ item_num($chosen_plan, 4) }}" per_savings="{{ $twelveMonthsDiscount }}" /> 12 months <span class="savings">(saves {{ $twelveMonthsDiscount }}%)</span><div />
            </fieldset>
            
             <div class="padlock"><img src="{{ URL::asset('assets/img/secure.png') }}" alt="secure site" /></div>

        </div> <!-- END billing_cycle -->
 
      
        <div class="shopping_cart">
        <h3>Check out </h3>
            <div id="summary">
            	<p class="sel_plan"><!-- <?php echo $plan; ?> <?php echo $plan_price; ?> GBP / mth --></p>
            	<p class="line_through"><span class="item_count"></span> month(s) </span> <span class="item_price1"><?php echo $plan; ?></span> = <span class="cum_total"><?php echo $plan_price; ?> </span></p>
                <p class="line_through"><span class="cart_savings"> </span> <span class="savings_amount"></span></p>
                 <?php if($apply_upgrade_amount == true): ?>
                 <p class="line_through"><span class="carry_over_savings">Adjustment:</span> <span class="carry_over_amount"><?php echo $applied_upgrade_amount; ?></span></p>
                <?php endif; ?>
                <p class="line_through"><span class="cart_total">Total: &#36;</span><span class="cart_amount"><?php echo $plan_price; ?></span></p>
             </div>
    
                <input type="hidden" name="item_number" value="1" id="item_number" />
                <input type="hidden" name="item_name" value="1 month subscription" id="item_name" />
                <input type="hidden" name="amount" value="<?php echo $plan_price; ?>" id="amount" />
                <input type="hidden" name="tenantID" value="<?php echo $tenantID; ?>" />

                <input type="hidden" name="last_recorded_start_date" value="<?php echo $last_recorded_start_date; ?>" />
                <input type="hidden" name="last_recorded_end_date" value="<?php echo $last_recorded_end_date; ?>" />
                <?php if($upgrading_from_unexpired_account == true): ?>
                <input type="hidden" name="upgrading_from_unexpired_account" value="yes" />
                <?php else: ?>
                 <input type="hidden" name="upgrading_from_unexpired_account" value="no" />
                <?php endif; ?>
                
                <?php if($extending_account == true): ?>
                <input type="hidden" name="extending_account" value="yes" />
                <?php else: ?>
                 <input type="hidden" name="extending_account" value="no" />
                <?php endif; ?>
                
                <?php if($renewing_expired_account == true): ?>
                <input type="hidden" name="renewing_expired_account" value="yes" />
                <?php else: ?>
                 <input type="hidden" name="renewing_expired_account" value="no" />
                <?php endif; ?>
                
                <input type="hidden" name="subcr_plan" value="<?php echo $chosen_plan; ?>" /><br />                
                <input type="checkbox" name="" value="" id="agree_terms" /> <span>I agree to the <a class="ordinary_link2" href="{{ URL::to('terms') }}">terms.</a></span><span class="mand">*</span><br /><br />   
                <input type="submit" class="gen_btn" id="checkout_paycard" value="Pay by card"><img class="" src="{{ URL::asset('assets/img/icon_store_creditcards.png') }}" alt="" /> <br />
                <input type="submit" class="gen_btn" id="checkout_paypal" value="Pay by paypal"><img class="" src="{{ URL::asset('assets/img/icon_store_paypal.png') }}" alt="" />
               
                @include('common.mandatory_field_message')
            <!-- </form> -->
             {{ Form::close() }}
     
        </div><!-- END shopping_cart -->
    </div><!-- END cart_section -->
	 
<?php endif; ?><!-- END if no post plan -->
	 	
	@stop
	

	@section('footer')
		
		<script>
		
			$(function(){
				
				 if($('#appmenu').length > 0){
				    $('.more_all_menu').addClass('selected_group'); 		 
			  		$('.menu_subscription').addClass('selected');		  		
			  		$('.more_all_menu ul').css({'display': 'block'});
			     }
				
				
				$('input[type=submit]').click(function(){	
				 
					if(!$('#agree_terms').attr('checked')){						
						alert('You must agree to terms');						
						return false;
					}
				 
				});
			 
			 
				$('#checkout_paypal').bind('click', function(){
					 document.paymentcart.action = "./paypal";					   
				});
				
				$('#checkout_paycard').bind('click', function(){
					 document.paymentcart.action = "./card";				   
				});
				 
			});
			
		</script>
		
 
 	<script src="{{ URL::asset('assets/js/cart.js') }}"></script>
 
	@stop