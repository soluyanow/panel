// ================
//
// Custom methods
//
// used in public/templates/default/assets/js/core/app.js
//
// ================
function importIssues()
{
    $.ajax({
        method: "POST",
        url: '/ajax/ImportIssues.php',
        data: { param1: "1", param2: "2" }
    })
    .done(function(data) {
        console.log(data);
    })
    .error(function(errors) {
        console.log(errors);
    });
}
