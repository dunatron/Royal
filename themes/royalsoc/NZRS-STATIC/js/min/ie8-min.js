!function($){$(".hamburger").on("click",null,function(l){l.preventDefault(),alert("hamburger clicked"),$(".filling").addClass("filling-animate"),$(".filling").addClass("collapse-menu"),$(".nav-wrapper").addClass("burger-fade")}),$(".hamburger").click(function(){alert("hamburger clicked"),$(".filling").addClass("filling-animate"),$(".filling").addClass("collapse-menu"),$(".nav-wrapper").addClass("burger-fade")}),$(".hamburger-close").click(function(){$(".nav-wrapper").removeClass("burger-fade"),$(".filling").removeClass("filling-animate"),$(".filling").removeClass("collapse-menu")})}(jQuery_1_12_4);