$(function () {
  // 1) destination autocomplete
  $("#destination")
    .autocomplete(
      {
        select: function (event, ui) {
          event.preventDefault();
          $("#destination").val(ui.item.label); // display the label
          $("#destination_id").val(ui.item.value); // save value to hidden input
        },
        source: function (request, cb) {
          $.ajax({
            url: "autocomplete.php",
            method: "GET",
            dataType: "json",
            data: {
              name: request.term,
            },
            success: function (res) {
              cb(res);
            },
          });
        },
      },
      {
        //autocomplete options
        autoFocus: true,
        // delay: 200,
        minLength: 3,
      }
    )
    .bind("focus", function () {
      //make autocomplete open on click
      $(this).autocomplete("search");
    });

  // 2) submit when filter changes
  $(".section_item").click(function () {
    document.getElementById("search").submit();
  });

  // 3) alterar cor selected sort
  $(".sort_item", this).click(function () {
    $(".sort_item").removeClass("sort_selected");
    $(this).addClass("sort_selected");
  });

  // 4) loading
  $(".sort_item, .switch, .hopping_select").click(function () {
    $(".hotel_boxes_wrapper").addClass("hotelbox_loading");
    setTimeout(function () {
      $(".hotel_boxes_wrapper").removeClass("hotelbox_loading");
    }, 1000);
  });

  // 5) get today date to set in minDate in date_range_picker
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, "0");
  var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
  var yyyy = today.getFullYear();
  today = mm + "/" + dd + "/" + yyyy;

  // 6) date_range_picker
  $("#date_range").daterangepicker(
    {
      autoApply: true,
      minDate: today,
      maxDate: "12/31/2020",
      maxSpan: {
        days: 27,
      },
      locale: {
        // format: "DD/MM/YY",
      },
    },

    //change displays nights under range picket
    function (start, end, label) {
      nr_nights = (end - start) / (1000 * 3600 * 24);
      nr_nights = Math.round(Math.abs(nr_nights)) - 1;

      if (nr_nights == 1) {
        $("#nights").text(nr_nights + "-night stay");
      } else {
        $("#nights").text(nr_nights + "-nights stay");
      }
    }
  );

  // 7) Delete policy separator dot if payment policy doesn't exists
  if ($(".payment_policy").is(":empty")) {
    $(".policy_separator").children().text("");
  }

  // 8) Delete hotel reviews wrapper if there is no reviews
  $(".hotel_review").has(".score:empty").remove();

  //end
});
