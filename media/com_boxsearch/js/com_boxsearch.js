jQuery(document).ready(function(){
 jQuery("#pagination").submit(function () {
    //var usr = jQuery("#username").val();
    /*
    if (usr.length >= 2) {
     jQuery("#status").html('<img src="loader.gif" align="absmiddle">&nbsp;Checking availability...');
     jQuery.ajax({
         type: "POST",
         url: "index.php?option=com_test&view=check_user",
         data: "username=" + usr,
         success: function (msg) {
         jQuery("#status").ajaxComplete(function (event, request, settings) {
         if (msg == 'OK') {
            jQuery("#username").removeClass('object_error'); // if necessary
                jQuery("#username").addClass("object_ok");
         }
         else {
               jQuery("#username").removeClass('object_ok'); // if necessary
               jQuery("#username").addClass("object_error");
               jQuery(this).html(msg);
         }
       });
      }
    });
  }*/
    alert('working');   
});
});