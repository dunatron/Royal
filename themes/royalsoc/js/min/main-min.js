$(document).ready(function(){function e(){$(".bottom-share").find(".right-share").css("background-position","left "+$(".right-share").find(".rstitle").outerWidth()+"px center"),$(window).width()>=768?$(".bottom-share").find(".left-share").css("max-width",$(".container").width()-$(".right-share").width()):($(".bottom-share").find(".left-share").css("max-width",$(".container").width()),$(".left-share").find(".lstitle").css("max-width",$(".container").width()-40),$(".bottom-share").find(".left-share").css("height",$(".left-share").find(".lstext").outerHeight()+$(".left-share").find(".lstitle").outerHeight()))}function t(e){var t=e.val(),a=t.split("\\").reverse();$(e).parent().find(".file-button").val(a[0]),""===$(e).parent().find(".file-button").val()&&$(e).parent().find(".file-button").val("Upload a file...")}function a(){$(".member-click").click(function(){var e=$(this).attr("id");$.ajax({url:"/members/Person",data:"ID="+e,method:"POST",async:!1}).done(function(e){$("#memberModal .modal-body").html(e)}),$("memberModal").modal("show")})}var i=$(window).width();$(window).resize(function(){$(window).width()!=i&&e()}),e(),$(".bad-amount").length&&($("#donateModal").modal({show:"true"}),$("#Form_DonateForm_action_doSubmitDonateForm").on("click",function(){$(".bad-amount").remove()})),$(".hamburger").click(function(){$(".filling").addClass("filling-animate"),$(".filling").addClass("collapse-menu"),$(".nav-wrapper").addClass("burger-fade")}),$(".hamburger-close").click(function(){$(".nav-wrapper").removeClass("burger-fade"),$(".filling").removeClass("filling-animate"),$(".filling").removeClass("collapse-menu")}),$(".search").click(function(){$(".search-wrapper").addClass("search-fade")}),$(".close-button").click(function(){$(".search-wrapper").removeClass("search-fade")}),$(".filter-trigger").click(function(){$(this).hasClass("filter-trigger-active")?($(this).removeClass("filter-trigger-active"),$(".filter-wrap").removeClass("filter-wrap-active"),$(".container").css("min-height","auto"),$(".results-container").css("opacity","1")):($(this).addClass("filter-trigger-active"),$(".filter-wrap").addClass("filter-wrap-active"),$(".container").css("min-height",$(".filter-wrap").height()),$(".results-container").css("opacity","0.35"))}),$(".file-button").click(function(){$(this).prop("readonly",!1),$(this).parent().find(".uploadtrig").click(),$(this).prop("readonly",!0)}),$(".uploadtrig").on("change",function(){t($(this))}),$(".inactive").click(function(e){"block"===$(this).css("display")||$(this).hasClass("active")||(e.preventDefault(),$(".children").removeClass("children-active"),$(".parent").find(".arrow-container").removeClass("arrow-rotate-nav"),$(".parent").find(".inactive").removeClass("active"),$(this).parent().find(".children").addClass("children-active"),$(this).parent().find(".arrow-container").addClass("arrow-rotate-nav"),$(this).addClass("active"))}),$("#member-sort").on("change",function(){var e=$(this).val();$(".content-wrapper #list-title span").html(e+"s"),$(".container .member-list-container").html('<img src="/mysite/icons/royalloader.gif" />'),$.ajax({url:"/members/People",data:"Grade="+e,method:"POST"}).done(function(e){$(".container .member-list-container").html(e),a()})}),a(),$(".event-create").find("a").click(function(){$("#eventModal").modal("show")}),$("#SuccessModal").modal({show:"true"})});