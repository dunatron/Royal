/**
 * Created by admin on 4/04/17.
 */
/**
 * Created by admin on 21/03/17.
 */
$( document ).ready(function() {
    /**
     * Field Research Search Awards
     */
    var FieldResearchSelectBox = $('#field-research-sort'),
        SubCategoriesSelectBox    = $('#sub-cats-sort'),
        ResearchCodesDropdown   =   $('#research-codes-dropdown'),
        ResearchCodesContainer =   $('.calc-full-list-container');

    $(FieldResearchSelectBox).change(function(){
        var selectedVal = $(this).find('option:selected').val(),
            url = window.location.href;

        $(ResearchCodesContainer).html('<div class="calc-list-item-container"></div>');
        hideResearchCodesDropDown();

        $.ajax({
            type:"POST",
            url: url + '/generateSubCats',

            data: {Value:selectedVal},
            success: function (response) {
                $(SubCategoriesSelectBox).html(response);
                setSubCategoriesVisibility();
            },
            complete: function(){

            }
        });

    });

    /**
     * Sub Categories Select
     */
    $(SubCategoriesSelectBox).change(function(){
        var selectedVal = $(this).find('option:selected').val(),
            url = window.location.href;
            //subCatID = $(FieldResearchSelectBox).find('option:selected').val();
        $.ajax({
            type:"POST",
            url: url + '/generateFieldResearchCodes',
            data: {SubCatID:selectedVal},
            success: function (response) {
                $(ResearchCodesDropdown).html(response);
                setCodesDropDownVisibility()
            },
            complete: function(){

            }
        });
    });

    /**
     * Research Codes DropDown
     */
    $(ResearchCodesDropdown).change(function(){
        var selectedVal = $(this).find('option:selected').val(),
            url = window.location.href;
        //subCatID = $(FieldResearchSelectBox).find('option:selected').val();
        $.ajax({
            type:"POST",
            url: url + '/generateFinalResearchCode',
            data: {CodeID:selectedVal},
            success: function (response) {
                $(ResearchCodesContainer).html(response);
            },
            complete: function(){

            }
        });
    });

    function setSubCategoriesVisibility() {
        if ($('#sub-cats-sort option').length == 0) {
            hideSubCategoriesDropDown();
        } else {
            showSubCategoriesDropDown();
        }
    }

    function showSubCategoriesDropDown()
    {
        $(SubCategoriesSelectBox).parent().parent().removeClass('not-visible');
        $(SubCategoriesSelectBox).parent().parent().addClass('is-visible');
    }

    function hideSubCategoriesDropDown()
    {
        $(SubCategoriesSelectBox).parent().parent().removeClass('is-visible');
        $(SubCategoriesSelectBox).parent().parent().addClass('not-visible');
    }

    // Research codes DropDown visibility and hide functions
    function setCodesDropDownVisibility() {
        if ($('#sub-cats-sort option').length == 0) {
            hideResearchCodesDropDown();
        } else {
            showResearchCodesDropDown();
        }
    }

    function showResearchCodesDropDown()
    {
        $(ResearchCodesDropdown).parent().parent().removeClass('not-visible');
        $(ResearchCodesDropdown).parent().parent().addClass('is-visible');
    }

    function hideResearchCodesDropDown()
    {
        $(ResearchCodesDropdown).parent().parent().removeClass('is-visible');
        $(ResearchCodesDropdown).parent().parent().addClass('not-visible');
    }


});