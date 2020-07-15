var h = new Object();

$(function () {
  // 1) Slideshow
  h.image_index = 0;
  h.images = [];

  h.images[0] =
    "https://r-cf.bstatic.com/images/hotel/max1024x768/228/228385161.jpg";
  h.images[1] =
    "https://q-cf.bstatic.com/images/hotel/max1280x900/228/228385038.jpg";
  h.images[2] =
    "https://q-cf.bstatic.com/images/hotel/max1280x900/337/33716742.jpg";

  $("#slide").attr("src", h.images[0]);

  $(".arrow_right ", this).click(function () {
    if (h.image_index == h.images.length - 1) {
      h.image_index = 0;
    } else {
      h.image_index++;
    }

    $("#slide").attr("src", h.images[h.image_index]);
  });

  $(".arrow_left", this).click(function () {
    if (h.image_index == 0) {
      h.image_index = h.images.length - 1;
    } else {
      h.image_index--;
    }

    $("#slide").attr("src", h.images[h.image_index]);
  });
});
