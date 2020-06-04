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

  //date_range_pickser
  $('input[name="check-in"]').daterangepicker(
    {
      autoApply: true,
      startDate: "06/04/2020",
      endDate: "06/04/2020",
      minDate: "06/04/2020",
      maxDate: "12/31/2020",
    },
    function (start, end, label) {
      console.log(
        "New date range selected: " +
          start.format("YYYY-MM-DD") +
          " to " +
          end.format("YYYY-MM-DD") +
          " (predefined range: " +
          label +
          ")"
      );
    }
  );

  //end
});
