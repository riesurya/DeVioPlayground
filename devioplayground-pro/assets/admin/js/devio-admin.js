jQuery( document ).ready( function($) 
{ 

  $('#postbox-container-2').change(function (ev) {

     //execute this block only if one of the radio button from "update-ship" group has changed
      if (ev.target.name == '_devio_pagelayout_mode') {

        //hide all optional li's
        $('#rightsidebar,#leftsidebar').hide();

        if ( $("input[value$='right']").prop('checked') || $("input[value$='doubleright']").prop('checked') || $("input[value$='left_right']").prop('checked') || $("input[value$='doubleleft']").prop('checked') ) {
           $('#rightsidebar').show();
        }

        if ( $("input[value$='left']").prop('checked') || $("input[value$='doubleright']").prop('checked') || $("input[value$='left_right']").prop('checked') || $("input[value$='doubleleft']").prop('checked') ) {
           $('#leftsidebar').show();
        }
      }

  }); //eof 

 $('#devioplayground-blogpro-home_testimonyitem .media_upload_button').remove();
 $('#devioplayground-blogpro-home_testimonyitem .remove-image').remove(); 
    
  $('#redux-import-link-button').remove(); 
  $('#redux-export-link').remove(); 
  $("#redux-import-code-button").text("Import Backup");

    $('#postbox-container-1').change(function (ev) {

     //execute this block only if one of the radio button from "update-ship" group has changed
      if (ev.target.name == 'post_format') {

        //hide all optional li's
        $('#deviogallery').hide();

        if ( $("#post-format-gallery").prop('checked') ) {
           $('#deviogallery').show();
        }

        if ( $(":not(#post-format-gallery)").prop('checked') ) {
           $('#deviogallery').hide();
        }

      }

  }); //eof 


}); //eof jQuery