/**
 * Created by admin on 26/04/17.
 */
$(document).ready(function(){

    /**
     * Create News item, initiate tinyMCE for news Content field
     */


     if ($('#Form_CreateNewsItemForm_error').hasClass('good'))
     {
         $('#CreateNewsModal').modal({
             show: 'true'
         });
     }

     // RESEARCH Form submission success
    if ($('#Form_CreateNewsItemForm_error').hasClass('good'))
    {
        $('#Form_CreateResearchItemForm_error').modal({
            show: 'true'
        });
    }




});