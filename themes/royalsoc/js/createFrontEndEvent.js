/**
 * Created by admin on 24/04/17.
 */
$(document).ready(function(){

    /**
     * Create Front End Event Form
     */
    var CreateEventDropDown = $('#Form_frontEndEventForm_EventID');

    var EventName = $('#Form_frontEndEventForm_Title'),
        FullName = $('#Form_frontEndEventForm_FullName'),
        Region = $('#Form_frontEndEventForm_RegionID'),
        Email = $('#Form_frontEndEventForm_Email'),
        Organisation = $('#Form_frontEndEventForm_Organisation'),
        Link = $('#Form_frontEndEventForm_Link'),
        RSVPEmail = $('#Form_frontEndEventForm_RSVPEmail'),
        InfoURL = $('#Form_frontEndEventForm_InfoURL'),
        Topic = $('#Form_frontEndEventForm_Topic'),
        SpeakerName = $('#Form_frontEndEventForm_SpeakerName'),
        SpeakerTitle = $('#Form_frontEndEventForm_SpeakerTitle'),
        Source = $('#Form_frontEndEventForm_Source'),
        SourceID = $('#Form_frontEndEventForm_SourceID'),
        Location = $('#Form_frontEndEventForm_Location'),
        Start = $('#Form_frontEndEventForm_Start_date'),
        End = $('#Form_frontEndEventForm_End_date'),
        Description = $('#Form_frontEndEventForm_Content');

    $(CreateEventDropDown).change(function(){
        var selectedVal = $(this).find('option:selected').val();

        // On change clear tinyMCE
        //tinyMCE.activeEditor.setContent('');

        $.ajax({
            type:"POST",
            url: '/pagefunction/updateFeEventData',
            dataType: "json",
            data: {Value:selectedVal},
            success: function (response) {
                $(EventName).val(response['EventName']);
                $(FullName).val(response['FullName']);
                $(Region).val(response['Region']);
                $(Email).val(response['Email']);
                $(Organisation).val(response['Organisation']);
                $(Link).val(response['Link']);
                $(RSVPEmail).val(response['RSVPEmail']);
                $(InfoURL).val(response['InfoURL']);
                $(Topic).val(response['Topic']);
                $(SpeakerName).val(response['SpeakerName']);
                $(SpeakerTitle).val(response['SpeakerTitle']);
                $(Source).val(response['Source']);
                $(SourceID).val(response['SourceID']);
                $(Location).val(response['Location']);
                $(Start).val(response['Start']);
                $(End).val(response['End']);
                $(Description).val(response['Content']);
                // tinymce.get("Form_frontEndEventForm_Content").execCommand('mceInsertContent', false, response['Content']);
            },
            complete: function(){

            },
            error: function(){

            }
        })

    });

    // It wont run modal since we are using the cms DatePicker on front end (it loads jquery twice)
    if ($('#Form_frontEndEventForm_error').hasClass('good'))
    {
        $('#FronEndEventModal').modal({
            show: 'true'
        });
    }

    //tinymce.init({ selector:'textarea#Form_frontEndEventForm_Content' });

    // tinyMCE.init({
    //     theme: 'advanced',
    //     //mode: 'textareas',
    //     selector: 'textarea#Form_frontEndEventForm_Content',
    //     theme_advanced_toolbar_location : "top",
    //     theme_advanced_buttons1 : "formatselect,|,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,outdent,indent,separator,undo,redo",
    //     theme_advanced_buttons2 : "",
    //     theme_advanced_buttons3 : "",
    //     height:"250px",
    //     width:"100%"
    // })
});