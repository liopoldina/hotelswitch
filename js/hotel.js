$(function () {
  // 1) Slideshow left and right
  h.image_index = 0;

  $("#slide").attr("src", h.images[0]);

  $(".arrow_right ", this).click(function () {
    if (h.image_index == h.images.length - 1) {
      h.image_index = 0;
    } else {
      h.image_index++;
    }
    $(".hp_min_slide").removeClass("hp_min_slide_selected");
    $(".hp_slide_img[index=" + h.image_index + "]")
      .parent()
      .addClass("hp_min_slide_selected");
    $("#slide").attr("src", h.images[h.image_index]);
  });

  $(".arrow_left", this).click(function () {
    if (h.image_index == 0) {
      h.image_index = h.images.length - 1;
    } else {
      h.image_index--;
    }
    $(".hp_min_slide").removeClass("hp_min_slide_selected");
    $(".hp_slide_img[index=" + h.image_index + "]")
      .parent()
      .addClass("hp_min_slide_selected");
    $("#slide").attr("src", h.images[h.image_index]);
  });

  // 2) Slideshow index
  $(".hp_slide_img", this).click(function () {
    $(".hp_min_slide").removeClass("hp_min_slide_selected");
    $(this).parent().addClass("hp_min_slide_selected");
    $("#slide").attr("src", $(this).attr("src"));
    h.image_index = parseInt($(this).attr("index"));
  });
});
