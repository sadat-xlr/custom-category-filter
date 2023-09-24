jQuery(document).ready(function($) {
    console.log("HELLO")
    $("#formname").on("change", "input:checkbox", function(){
        $("#formname").submit();
    });
});
