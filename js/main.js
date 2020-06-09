$(function () {
  //submit when filter changes
  $(".section_item").click(function () {
    document.getElementById("search").submit();
  });

  //alterar cor selected sort
  $(".sort_item", this).click(function () {
    $(".sort_item").removeClass("sort_selected");
    $(this).addClass("sort_selected");
  });

  // loading
  $(".sort_item, .switch, .hopping_select").click(function () {
    $(".hotel_boxes_wrapper").addClass("hotelbox_loading");
    setTimeout(function () {
      $(".hotel_boxes_wrapper").removeClass("hotelbox_loading");
    }, 1000);
  });

  //get today date to set in minDate in date_range_picker
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, "0");
  var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
  var yyyy = today.getFullYear();
  today = mm + "/" + dd + "/" + yyyy;

  //date_range_picker
  $("#date_range").daterangepicker(
    {
      autoApply: true,
      minDate: today,
      maxDate: "12/31/2020",
      locale: {
        // format: "DD/MM/YY",
      },
    },

    // change displays nights under range picket
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

  // Delete policy separator dot if payment policy doesn't exists

  if ($(".payment_policy").is(":empty")) {
    $(".policy_separator").children().text("");
  }
  //end
});
