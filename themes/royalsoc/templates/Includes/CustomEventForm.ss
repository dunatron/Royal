<% if $IncludeFormTag %>
    <div class="modal-body">
        <%--<h2>Create or edit an Event</h2>--%>
    <form $AttributesHTML>
<% end_if %>
<% if $Message %>
        <p id="{$FormName}_error" class="message $MessageType">$Message</p>
<% else %>
        <p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
<% end_if %>

    <fieldset>
        <% if $Legend %><legend>$Legend</legend><% end_if %>
        <% loop $Fields %>
            $FieldHolder
            <div class="clear clear-event-form"><!-- --></div>
        <% end_loop %>
        <div class="clear clear-event-form"><!-- --></div>
    </fieldset>

<% if $Actions %>
        <div class="Actions button-outer">
            <% loop $Actions %>
                $Field
            <% end_loop %>
        </div>
<% end_if %>
<% if $IncludeFormTag %>
    </form>
    </div>
    <div class="clear"></div>
<% end_if %>