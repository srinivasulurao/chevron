RightNow.namespace('Custom.Widgets.investigations.UpdateInvestigation');
Custom.Widgets.investigations.UpdateInvestigation = RightNow.Widgets.extend({ 
    /**
     * Widget constructor.
     */
    constructor: function() {
       
			YUI().use('transition','event','panel', function(Y) {
				
				    
			         //Show, Hide Form
			          	var add_thread = Y.one('#add_thread');
			            add_thread.on("click", function (e) {
			            	add_button_text=document.getElementById('add_thread').innerHTML;
			            	if(add_button_text=="+ Add"){
			            	Y.one('#thread_submit').show(true);
			            	add_thread.setContent("- Hide");
			            	}
			            	else{
			            	Y.one('#thread_submit').hide(true);
			            	add_thread.setContent("+ Add");
			            	}
			            	
			            });
			            
			 
			 //Contact Lookup Search.           
			      var cl = Y.all('#thread_submit .rn_Email');
			      cl.on("keyup", function (e) {   
			      	            contact_lookup=document.getElementsByName("Contact.Emails.PRIMARY.Address")[0].value;
			      	            if(parseInt(contact_lookup.length) > 3){
						      	RightNow.Ajax.makeRequest("/cc/customerFeedbackSystem/contactLookUpSearch",{input:contact_lookup}, {
			                    successHandler: function (response) {
			
			                        if(response.responseText!="")
			                            document.getElementById('contact_look_up').innerHTML=response.responseText                  
			                        else
			                            document.getElementById('contact_look_up').innerHTML='';
			
			                    },
			                    scope: this,
			                    json: false,
			                    type: "POST"
			                    });
			                   }
			      }); 
			            
			});      
			
			//Subscribe to response Event()
			var form = RightNow.Form.find("thread_submit", this.instanceID);
	        form.on("response", this.callThreads, this);      
    },

    /**
     * Sample widget method.
     */
    callThreads: function(type,args) {
    	//console.log(args);
    	//console.log(args.data.results.transaction.incident.value);
    },

    /**
     * Makes an AJAX request for `default_ajax_endpoint`.
     */
    getDefault_ajax_endpoint: function() {
        // Make AJAX request:
        var eventObj = new RightNow.Event.EventObject(this, {data:{
            w_id: this.data.info.w_id,
            // Parameters to send
        }});
        RightNow.Ajax.makeRequest(this.data.attrs.default_ajax_endpoint, eventObj.data, {
            successHandler: this.default_ajax_endpointCallback,
            scope:          this,
            data:           eventObj,
            json:           true
        });
    },

    /**
     * Handles the AJAX response for `default_ajax_endpoint`.
     * @param {object} response JSON-parsed response from the server
     * @param {object} originalEventObj `eventObj` from #getDefault_ajax_endpoint
     */
    default_ajax_endpointCallback: function(response, originalEventObj) {
       alert("Hello");
    }
});


function setContact(id,email){
	document.getElementById("rn_TextInput_36_Contact.Emails.PRIMARY.Address").value=email;
	document.getElementById('contact_look_up').innerHTML="";
}
