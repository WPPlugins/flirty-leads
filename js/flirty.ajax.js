/**
*AJAX script for flirtyleads
*/
jQuery( document ).ready( function() {
	jQuery('#lcform_0, #lcform_1, #lcform_2, #lcform_3, #lcform_4, #lcform_5, #lcform_6, #lcform_7, #lcform_8, #lcform_9, #lcform_10').submit(function (e){
	//jQuery('#lcform').submit(function (e){
	e.preventDefault(); // this disables the submit button so the user stays on the page
	var form = this;
		
			
		
		var form_url = postdata.ajaxurl;
		var phone = postdata.phone;
		
	    
		
	
		var image_id = form.form_id.value;
		var nonce = form.nonce.value;
		var str_image_id = image_id.toString();
		var uniq_id = form.uniq_id.value;
		var str_uniq_id = uniq_id.toString();
		var email = form.email.value;
		var referer = form.referer.value;
		var lcemail = form.lcemail.value;
		
		// This is what we are sending the server
        var data = {
			action: 'flirtyleads',
			email: email, 
			lcemail: lcemail, 
			referer: referer,
			image_id: image_id,
			nonce: nonce,
			ajaxrequest: 1
        }
	
	
		   // To provide the user some immediate feedback
		if ((phone != '555 555 5555') || (phone == null) || (phone == "") || (email == null) || (email == "") || (email == "carroll@example.com") )
		{
           window.alert("Please enter your email address.");
		return false;
		}
		
			
		// Post to the server
        jQuery.post( postdata.ajaxurl, data, function(data) {
		
		
		   // Get the Status
            var status = jQuery( data ).find( 'response_data' ).text();
			 // Get the Message
            var message = jQuery( data ).find( 'supplemental message' ).text();
			//hides form and cta			
			jQuery('.lead_capture_header_' + str_uniq_id).hide();
			jQuery('#lcform_' + str_uniq_id).hide();
			//jQuery('#thanks_' + str_image_id).show();
			
			 // If we are successful, add the success message and remove the link
            if( status == 'success' ) {
			//thank you show
			jQuery('#thanks_' + str_image_id).show();
									  }
			else {// An error occurred, alert an error message
                alert( message );}						  
            
        });
       
		
		
	
		
		});
		
		
	
});