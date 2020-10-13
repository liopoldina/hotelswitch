$(function() {
    $("select, input").change(function() {
        $(".error_message").remove();

        item_wrapper = $(this).parent();

        loading_gif = $(this)
            .siblings(".loading_wrapper")
            .children(".loading_gif");
        loading_text = $(this)
            .siblings(".loading_wrapper")
            .children(".loading_text")
            .text("Saving...");
        check = $(this)
            .siblings(".loading_wrapper")
            .children("i");

        loading_text.text("");
        check.removeClass("fas fa-check");

        loading_gif.show();
        loading_text.text("Saving...");

        var data = {};
        data["_token"] = $('input[name ="_token"]').val();
        data[$(this).attr("name")] = $(this).val();

        $.ajax({
            type: "PUT",
            url: "settings",
            dataType: "html",
            data: data,
            success: function(response) {
                console.log(response);
                loading_gif.hide();
                loading_text.text("Saved");
                check.addClass("fas fa-check");

                setTimeout(function() {
                    loading_text.text("");
                    check.removeClass("fas fa-check");
                }, 1000);
            },
            error: function(error) {
                if (error.status == 422) {
                    loading_gif.hide();
                    loading_text.text("");

                    message = JSON.parse(error.responseText);

                    span = $("<span></span>").text(message.name);
                    span.addClass("error_message");

                    $(item_wrapper).after(span);
                }
            }
        });
    });
});
