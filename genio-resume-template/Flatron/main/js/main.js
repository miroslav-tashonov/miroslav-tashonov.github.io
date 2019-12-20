// carousel
$('.carousel').carousel();

// tooltips
$('[data-toggle="tooltip"]').tooltip();

// popovers
$('[data-toggle="popover"]').popover();

// collapse
$('.collapse').collapse();

// prevent dropdown from closing 
// when clicking on an item 
// that has sub-menu
// in case of nested menus
$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
    // Avoid following the href location when clicking
    event.preventDefault(); 
    // Avoid having the menu to close when clicking
    event.stopPropagation(); 
    // Re-add .open to parent sub-menu item
    $(this).parent().addClass('open');
    $(this).parent().find("ul").parent().find("li.dropdown").addClass('open');
});

// remove top navbar transparent 
// styles on scroll and retianing the
// original styles
$(window).scroll(function (event) {
    var scroll = $(window).scrollTop();
    
    if ( scroll > 100 ) {
      $('#page-navbar').removeClass('page-navbar');
    } else {
      $('#page-navbar').addClass('page-navbar');
    }
});