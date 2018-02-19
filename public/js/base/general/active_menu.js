$(document).ready(function () {
    // get menu id
    var active_menu =  $('meta[name=active-menu]').attr('content');
    // search and add active class
    $('#mn-'+active_menu).addClass('active');
    // search parent
    $('#mn-'+active_menu).closest(".treeview").addClass('active').addClass('menu-open');
});