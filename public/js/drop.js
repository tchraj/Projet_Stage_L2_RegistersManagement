$(document).ready(function () {
  // Add click event handler to the collapse links
  $('[data-toggle="collapse"]').click(function () {
    // Get the target collapse element from the 'href' attribute of the link
    var target = $(this).attr('href');

    // Toggle the collapse state of the target element
    $(target).collapse('toggle');
  });
})