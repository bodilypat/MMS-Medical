$(document).ready(function(){
    var w = window.innerWidth;

    if(w > 767) {
        /* Apply desktop behavior */
        $('#menu-md').scrollToFixed();
    } else {
        /* Apply mobile behavior (if any) */
        $('#menu-md').scrollToFixed();
    }
});
$(document).ready(function() {
    $(".filter-button").click(function() {
        var value = $(this).attr('data-filter');
        /* Hide or show elements based on filter value */
        if(value == "all") {
            $('filter').show('100'); // show all items
        } else {
            $('.filter').not('.' + value).hide('3000'); // Hide items not matching the filter
            $('.filter').filter('.' + value).show('300'); // show only matching filter items
        }
        /* Remove 'active' class from all filter buttons */
        $('.filter-button').removeClass("active");
        // Add 'active' class to the clicked button
        $(this).addClass("active");
    });
});
