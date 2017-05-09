/**
 * Created by admin on 1/05/17.
 */
$(document).ready(function(){
    /**
     * Create Research item
     */
    var ResearchModal = $('#CreateResearchModal'),
        ResearchFormMessage = $('#Form_CreateResearchItemForm_error');

    // RESEARCH Form submission success
    if ($(ResearchFormMessage).hasClass('good'))
    {
        $(ResearchModal).modal({
            show: 'true'
        });
    }

});