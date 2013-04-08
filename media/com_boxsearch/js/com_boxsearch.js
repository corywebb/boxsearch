jQuery(document).ready(function(){
	var offset = 0;
 jQuery("#pagination").submit(function () {
	 event.preventDefault();
	 
     offset = offset+30;
     alert(offset);
     var request = jQuery.ajax({
         type: "POST",
         url: "index.php?option=com_boxsearch&view=ajax&format=raw&offset="+offset,
         data: "",
         dataType: 'json',
         success: function(result) {
        	 $('#content1').html(result[0]);
         },
       });
      
     // callback handler that will be called on success
     request.done(function (response, textStatus, jqXHR){
         // log a message to the console
         console.log("Hooray, it worked!");
     }); 
    //return false;
});
});