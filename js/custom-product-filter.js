jQuery(document).ready(function($) {
    console.log("Category Filtering widget test")
    var urlParams = new URLSearchParams(window.location.search);
    var selectedCategories = urlParams.getAll('product_cat');
    console.log(selectedCategories);
    // Check the checkboxes based on the selected category values
    $('.category-filter-checkbox').each(function() {
        if (selectedCategories.includes($(this).val())) {
            $(this).prop('checked', true);
        }
    });
    $("#formname").on("change", "input:checkbox", function(){
        $("#formname").submit();
    });
});
