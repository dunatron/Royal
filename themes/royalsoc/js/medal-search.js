/**
 * Created by admin on 21/03/17.
 */
$( document ).ready(function() {
    /**
     * Medal Search Awards
     */
    var ResearchSelectBox = $('#medal-sort'),
        SubjectSelectBox    = $('#subject-sort'),
        MedalsContainer =   $('.calc-full-list-container');

    $(ResearchSelectBox).change(function(){
        var selectedVal = $(this).find('option:selected').val(),
            url = window.location.href;

        $(MedalsContainer).html('<div class="calc-list-item-container"></div>');

        $.ajax({
            type:"POST",
            url: url + '/generateSubjects',

            data: {Value:selectedVal},
            success: function (response) {
                $(SubjectSelectBox).html(response);
                setSubjectVisibility();
            },
            complete: function(){

            }
        });

    });

    function setSubjectVisibility() {

        if ($('#subject-sort option').length == 0) {
            hideSubjectDropDown();
        } else {
            showSubjectDropDown();
        }

    }

    function showSubjectDropDown()
    {
        $(SubjectSelectBox).parent().parent().removeClass('not-visible');
        $(SubjectSelectBox).parent().parent().addClass('is-visible');
    }

    function hideSubjectDropDown()
    {
        $(SubjectSelectBox).parent().parent().removeClass('is-visible');
        $(SubjectSelectBox).parent().parent().addClass('not-visible');
    }



    /**
     * Subject Select
     */
    $(SubjectSelectBox).change(function(){
        var selectedVal = $(this).find('option:selected').val(),
            url = window.location.href,
            audienceID = $(ResearchSelectBox).find('option:selected').val();
        $.ajax({
            type:"POST",
            url: url + '/generateMedals',
            data: {SubjectID:selectedVal, AudienceID:audienceID},
            success: function (response) {
                $(MedalsContainer).html(response);
            },
            complete: function(){

            }
        });
    });

    /**
     * Fund search
     */

    var FundResearchSelectBox = $('#fund-member-sort'),
        FundTypeSelectBox   =   $('#fund-type-sort');

    $(FundResearchSelectBox).change(function(){
        var selectedVal = $(this).find('option:selected').val(),
            url = window.location.href;

        $(MedalsContainer).html('<div class="calc-list-item-container"></div>');

        $.ajax({
            type:"POST",
            url: url + '/generateTypes',
            data: {AUDIENCEID:selectedVal},
            success: function (response) {
                $(FundTypeSelectBox).html(response);
                setTypeVisibility();
            },
            complete: function(){

            }
        });

    });

    /**
     * Type Select
     */
    $(FundTypeSelectBox).change(function(){
        var selectedVal = $(this).find('option:selected').val(),
            url = window.location.href,
            audienceID = $(FundResearchSelectBox).find('option:selected').val();
        $.ajax({
            type:"POST",
            url: url + '/generateFundOpportunities',
            data: {TypeID:selectedVal, AudienceID:audienceID},
            success: function (response) {
                $(MedalsContainer).html(response);
            },
            complete: function(){

            }
        });
    });

    function setTypeVisibility() {

        if ($('#fund-type-sort option').length == 0) {
            hideTypeDropDown();
        } else {
            showTypeDropDown();
        }

    }

    function showTypeDropDown()
    {
        $(FundTypeSelectBox).parent().parent().removeClass('not-visible');
        $(FundTypeSelectBox).parent().parent().addClass('is-visible');
    }

    function hideTypeDropDown()
    {
        $(FundTypeSelectBox).parent().parent().removeClass('is-visible');
        $(FundTypeSelectBox).parent().parent().addClass('not-visible');
    }

    // $('#donateSuccessModal').modal({
    //     show: 'true'
    // });

});