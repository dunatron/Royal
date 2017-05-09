<% if $StaffPhoto %>
    <img class="member-image" src="$StaffPhoto.Fill(130,158).Link" />
<% else %>
    <img class="member-image" src="mysite/icons/people-fallback.png" />
<% end_if %>
<h2 class="modal-member-title">$JobTitle</h2>
<h2 class="modal-member-firstname">$FirstName</h2>
<h2 class="modal-member-lastname">$Surname</h2>
<h2 class="modal-member-honoraries"><a href="mailto:$Email">$Email</a></h2>
<% if $DDI %>
<h2 class="modal-member-honoraries"><a href="tel:$DDI">$DDI</a></h2>
<% end_if %>
<div class="clear"></div>
<% if $Profile %>
<h2 class="title-modal-member-biography">Profile</h2>
<p class="modal-member-biography">$Profile</p>
<% end_if %>