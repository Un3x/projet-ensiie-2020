var clicks = 14;
var bool = false;
document.getElementById("clicks","bool").innerHTML = clicks,bool;

$('.like-counter').click(function() {
    clicks += 1;
    document.getElementById("clicks").innerHTML = clicks;
    $('.like-counter').addClass("liked");
});