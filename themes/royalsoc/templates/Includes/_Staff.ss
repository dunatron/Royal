<div class="member-container">
    <a type="button" id="$ID" class="btn btn-info btn-lg staff-click" data-toggle="modal" data-target="#staffModal">
        <% if $StaffPhoto %>
            <img class="member-image" src="$StaffPhoto.Fill(130,158).Link" />
        <% else %>
            <img class="member-image" src="mysite/icons/people-fallback.png" />
        <% end_if %>
        <p class="title">$JobTitle</p>
        <p class="firstname">$FirstName</p>
        <p class="lastname">$Surname</p>
    </a>
</div>