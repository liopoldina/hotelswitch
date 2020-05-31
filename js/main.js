$(function () {
  //
  //alterar cor selected sort
  $(".sort_item", this).click(function () {
    $(".sort_item").removeClass("sort_selected");
    $(this).addClass("sort_selected");
  });

  //initial loading
  $(".section_item, .sort_item, .switch, .hopping_select").click(function () {
    $(".hotel_boxes").addClass("hotelbox_loading");

    setTimeout(function () {
      $(".hotel_boxes").removeClass("hotelbox_loading");
    }, 1000);
  });

  //
  //end
});
