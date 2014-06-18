// JavaScript Document
function initAutoSubmit(formName){	
	//Options for the jquery ajax form.
	var options = { 
        //beforeSubmit:  	showRequest,  // pre-submit callback 
        success:      	showResponse,  // post-submit callback 
		dataType:		'json'
 
        // other available options: 
        //url:       url         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
	
// bind to the form's submit event 
    $(formName).submit(function() { 
        // inside event callbacks 'this' is the DOM element so we first 
        // wrap it in a jQuery object and then invoke ajaxSubmit 
        $(this).ajaxSubmit(options); 
 
        // !!! Important !!! 
        // always return false to prevent standard browser submit and page navigation 
        return false; 
    }); 
}

/*
	// pre-submit callback 
function showRequest(formData, jqForm, options) { 
	// formData is an array; here we use $.param to convert it to a string to display it 
	// but the form plugin does this for you automatically when it submits the data 
	var queryString = $.param(formData); 
 
	// jqForm is a jQuery object encapsulating the form element.  To access the 
	// DOM element for the form do this: 
	// var formElement = jqForm[0]; 
 
	//alert('About to submit: \n\n' + queryString); 
 
	// here we could return false to prevent the form from being submitted; 
	// returning anything other than false will allow the form submit to continue 
	return true; 
} */
 
// post-submit callback 
function showResponse(response, statusText, xhr, $form)  { 
	// for normal html responses, the first argument to the success callback 
	// is the XMLHttpRequest object's responseText property 
 
	// if the ajaxSubmit method was passed an Options Object with the dataType 
	// property set to 'xml' then the first argument to the success callback 
	// is the XMLHttpRequest object's responseXML property 
 
	// if the ajaxSubmit method was passed an Options Object with the dataType 
	// property set to 'json' then the first argument to the success callback 
	// is the json data object returned by the server 
 
	//alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + 
	//	'\n\nThe output div should have already been updated with the responseText.');
	
	//Check to see if we have the needed values.
	if(    typeof response.success_bool == 'undefined'
		|| typeof response.success_message == 'undefined'
		|| typeof response.error_message == 'undefined'
		|| typeof response.debug_message == 'undefined'
		|| typeof response.redirect_url == 'undefined')
	{
		alert("Missing Return Value.");
		return;
	}
		
	if(response.debug_message != "")
	{
		alert(response.debug_message);
	}
	if(response.error_message != "")
	{
		alert(response.error_message);
	}	
	
	if(response.success_bool == true)
	{
		if(response.success_message != "")
		{
			alert(response.success_message);
		}
		
		if(response.redirect_url != '')
		{
			window.location = response.redirect_url;
		}	
		
	}
	
} 

