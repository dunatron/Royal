/**
 * Created by admin on 4/04/17.
 */
$( document ).ready(function() {
    /**
     * Field Research Search Awards
     */
    var SocialEconomicCategorySelectBox = $('#socio-economic-sort'),
        EconomicSubCategoriesSelectBox    = $('#economic-sub-cats-sort'),
        EconomicCodesDropDown   = $('#economic-codes-dropdown'),
        SocialEconomicCodesContainer =   $('.calc-full-list-container');

    $(SocialEconomicCategorySelectBox).change(function(){
        var selectedVal = $(this).find('option:selected').val(),
            url = window.location.href;

        $(SocialEconomicCodesContainer).html('<div class="calc-list-item-container"></div>');
        hideCodeDropDown();

        $.ajax({
            type:"POST",
            url: url + '/generateSubCats',

            data: {Value:selectedVal},
            success: function (response) {
                $(EconomicSubCategoriesSelectBox).html(response);
                console.log(response);
                setSubCategoriesVisibility();
            },
            complete: function(){

            }
        });

    });

    /**
     * Sub Categories Select
     */
    $(EconomicSubCategoriesSelectBox).change(function(){
        var selectedVal = $(this).find('option:selected').val(),
            url = window.location.href;
        //subCatID = $(FieldResearchSelectBox).find('option:selected').val();
        $.ajax({
            type:"POST",
            url: url + '/generateEconomicCodes',
            data: {SubCatID:selectedVal},
            success: function (response) {
                $(EconomicCodesDropDown).html(response);
                setCodesDropDownVisibility();
            },
            complete: function(){

            }
        });
    });

    $(EconomicCodesDropDown).change(function(){
        var selectedVal = $(this).find('option:selected').val(),
            url = window.location.href;
        //subCatID = $(FieldResearchSelectBox).find('option:selected').val();
        $.ajax({
            type:"POST",
            url: url + '/generateFinalEconomicCodes',
            data: {CodeID:selectedVal},
            success: function (response) {
                $(SocialEconomicCodesContainer).html(response);
            },
            complete: function(){

            }
        });
    });

    function setSubCategoriesVisibility() {
        if ($('#economic-sub-cats-sort option').length == 0) {
            hideSubCategoriesDropDown();
        } else {
            showSubCategoriesDropDown();
        }
    }

    function showSubCategoriesDropDown()
    {
        $(EconomicSubCategoriesSelectBox).parent().parent().removeClass('not-visible');
        $(EconomicSubCategoriesSelectBox).parent().parent().addClass('is-visible');
    }

    function hideSubCategoriesDropDown()
    {
        $(EconomicSubCategoriesSelectBox).parent().parent().removeClass('is-visible');
        $(EconomicSubCategoriesSelectBox).parent().parent().addClass('not-visible');
    }

    // Codes Dropdown Reveal and Hide
    function setCodesDropDownVisibility() {
        if ($('#economic-codes-dropdown option').length == 0) {
            hideCodeDropDown();
        } else {
            showCodeDropDown();
        }
    }

    function showCodeDropDown()
    {
        $(EconomicCodesDropDown).parent().parent().removeClass('not-visible');
        $(EconomicCodesDropDown).parent().parent().addClass('is-visible');
    }

    function hideCodeDropDown()
    {
        $(EconomicCodesDropDown).parent().parent().removeClass('is-visible');
        $(EconomicCodesDropDown).parent().parent().addClass('not-visible');
    }


});