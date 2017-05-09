<!-- <div class="banner" style="background-image:url('http://placekitten.com/1200/600')">-->
<div class="banner" style="background-image:url($FindHeroImage.Fill(1170,420).Link)">
    <a href="/" class="logo">
    </a>
    <div class="banner-content">
        <div class="hamburger">
            <span class="filling"></span>
        </div>
        <div class="search">
            <span class="magnif"></span>
        </div>
        <div class="donate">
            <a href="#donate" data-toggle="modal" data-target="#donateModal">
                Donate
            </a>
        </div>
    </div>
    <div class="banner-text-container">
        <h1 class="banner-title lrg-col-8">$Title</h1>
        <p class="lrg-col-8">$Blurb</p>
    </div>
</div>
<% include Search %>

<% include Menu %>