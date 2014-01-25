$(".radio input").on("click",function(e){
    var radio = $(this);
    var pkg = radio.closest(".packages");
    pkg.find("label").removeClass("active");
    radio.closest("label").addClass("active");
});

$("#datepicker").datepicker();