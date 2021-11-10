$(() => {
    $("#search").on("keyup", function() {
        // $('.loader').show();
        // alert($("#search").val());
        $("#container").load("barang.php?keyword="+$("#search").val());
        // $.get("barang.php?keyword=" + $("#keyword").val(), function(data) {
        //     $("#container").html(data);
        //     // $('.loader').hide();
        // });
    });
});