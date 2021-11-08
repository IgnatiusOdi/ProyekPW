$(() => {
    $("#search").on("keyup", function() {
        $("#container").load("ajax/search.php?keyword=" + $("#keyword").val());
    });
});