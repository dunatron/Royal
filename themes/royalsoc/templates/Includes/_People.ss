<div class="member-container" data-surname="$LastName">
    <a type="button" id="$ID" class="btn btn-info btn-lg member-click" data-toggle="modal" data-target="#memberModal">
        <% if $Photo %>
            <img class="member-image" src="$Photo.Fill(130,158).Link" />
        <% else %>
            <img class="member-image" src="mysite/icons/people-fallback.png" />
        <% end_if %>
        <p class="title">$Title</p>
        <p class="firstname">$FirstName</p>
        <p class="lastname">$LastName</p>
        <p class="honoraries">$Qualifications</p>
    </a>
</div>