/**
 * Created by admin on 26/04/17.
 */
$(document).ready(function () {
    /**
     * Events panel filter
     */
    var EventLocationFilter = $('#event-location-filter'),
        EventDateFilter = $('#event-date-filter'),
        EventContainer = $('.content-event-box-container');

    $(EventDateFilter).change(function () {
        var selectedVal = $(this).find('option:selected').val();
        filterEvents("data-end", selectedVal);
    });

    $(EventLocationFilter).change(function () {
        var selectedVal = $(this).find('option:selected').val();
        filterEvents("data-region-type", selectedVal);
    });

    function filterEvents(filter, value) {
        $(EventContainer).each(function () {
            if (value == "ALL")
            {
                showEvent($(this));
                resetDropDown(EventLocationFilter);
                resetDropDown(EventDateFilter);
            }
            else
            {
                if ($(this).attr(filter) == value) {
                    showEvent($(this));
                }
                else
                {
                    hideEvent($(this))
                }
            }

        });
    }

    function showEvent(item) {
        $(item).css('display', 'block');
    }

    function hideEvent(item) {
        $(item).css('display', 'none');
    }

    function resetDropDown(item) {
        $(item).val($(item + "option:first").val());
    }

});