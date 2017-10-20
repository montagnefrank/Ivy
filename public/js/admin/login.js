$(document).ready(function() {
    "use strict";
	
	// Options for Message
	//----------------------------------------------
  var options = {
	  'btn-loading': '<i class="fa fa-spinner fa-pulse"></i>',
	  'btn-success': '<i class="fa fa-check"></i>',
	  'btn-error': '<i class="fa fa-remove"></i>',
	  'msg-success': 'All Good! Redirecting...',
	  'msg-error': 'Wrong login credentials!',
	  'useAJAX': false
  };

	// Login Form
	//----------------------------------------------
	// Validation
  $("#login-form").validate({
  	rules: {
            usuario: "required",
            contrasena: "required"
        },
        messages: {
               usuario: {required: "Campo Requerido"},
               contrasena:{required: "Campo Requerido"}
            },
  	errorClass: "form-invalid",
        submitHandler: function(form){
            form.submit();
        }
  });
  
//  // Form Submission
//  $("#login-form").submit(function() {
//  	remove_loading($(this));
//		
//		if(options['useAJAX'] == true)
//		{
//			// Dummy AJAX request (Replace this with your AJAX code)
//		  // If you don't want to use AJAX, remove this
//  	  dummy_submit_form($(this));
//		
//		  // Cancel the normal submission.
//		  // If you don't want to use AJAX, remove this
//  	  return false;
//		}
//  });
	

//	// Loading
//	//----------------------------------------------
//  function remove_loading($form)
//  {
//  	$form.find('[type=submit]').removeClass('error success');
//  	$form.find('.login-form-main-message').removeClass('show error success').html('');
//  }
//
//  function form_loading($form)
//  {
//    $form.find('[type=submit]').addClass('clicked').html(options['btn-loading']);
//  }
//  
//  function form_success($form)
//  {
//	  $form.find('[type=submit]').addClass('success').html(options['btn-success']);
//	  $form.find('.login-form-main-message').addClass('show success').html(options['msg-success']);
//  }
//
//  function form_failed($form)
//  {
//  	$form.find('[type=submit]').addClass('error').html(options['btn-error']);
//  	$form.find('.login-form-main-message').addClass('show error').html(options['msg-error']);
//  }
//
//	// Dummy Submit Form (Remove this)
//	//----------------------------------------------
//	// This is just a dummy form submission. You should use your AJAX function or remove this function if you are not using AJAX.
//  function dummy_submit_form($form)
//  {
//  	if($form.valid())
//  	{
//  		form_loading($form);
//  		
//  		setTimeout(function() {
//  			form_success($form);
//  		}, 2000);
//  	}
//  }
	
});