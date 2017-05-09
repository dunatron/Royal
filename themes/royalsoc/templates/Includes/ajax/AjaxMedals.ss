<h2>List of Medals tailored to you</h2>

<% loop $Medals %>
    <div class="calc-list-item-container">
        <h3 class="calc-item-title">$MedalTitle</h3>
        <div class="content">
            <p class="calc-item-paragraph">$MedalContent.LimitCharacters(300)</p>
        </div>

        <a href="$MedalURL" class="calc-item-more-link">Find out more</a>
    </div>
<% end_loop %>
<div class="clear"></div>