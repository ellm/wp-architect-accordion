jQuery(document).ready(function($) {
    $( "div.accordion" ).accordion( {
        collapsible: true, //Whether all the sections can be closed at once. Allows collapsing the active section.
        active: false //Which panel is currently open.
    });
});