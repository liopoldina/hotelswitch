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

  // 9) Open and close map
  //open map
  $(".map_wrapper").click(function () {
    $("#map_overlay").addClass("display_map_overlay");
    $("body").css("overflow", "hidden"); //disable scroll
  });
  //close map on cross
  $(".map_close").click(function () {
    $("#map_overlay").removeClass("display_map_overlay");
    $("body").css("overflow", "auto"); //enable scroll
  });
  //close map on clicked outside
  $(document).mouseup(function (e) {
    if ($("#map_overlay").hasClass("display_map_overlay")) {
      var container = $("#map_popup");
      if (!container.is(e.target) && container.has(e.target).length === 0) {
        $("#map_overlay").removeClass("display_map_overlay");
        $("body").css("overflow", "auto"); //enable scroll
      }
    }
  });

  //end jquery
});

// JUST JAVASCRIPT
//10) Google Maps

// Map options
var options = {
  center: { lat: 38.715, lng: -9.142685 },
  zoom: 15,
  gestureHandling: "greedy", //no need to press ctrl to mouse zoom
};
// New map
function initMap() {
  var map = new google.maps.Map(document.getElementById("map"), options);
  // Add Marker Function
  function addMarker(props) {
    var marker = new google.maps.Marker({
      position: props.coords,
      map: map,
    });
    //Info Window
    var infoWindow = new google.maps.InfoWindow({
      content: props.content,
    });
    marker.addListener("click", function () {
      infoWindow.open(map, marker);
    });
  }
  //Array of markers
  var markers = [
    {
      coords: { lat: 38.7156116, lng: -9.1404987 },
      content: "<h1>Rossio Garden Hotel</h1>",
    },
    {
      coords: { lat: 38.714954, lng: -9.1404965 },
      content: "<h1>Rossio Boutique Hotel</h1>",
    },
    {
      coords: { lat: 38.7153571, lng: -9.1471453 },
      content: "<h1>Bairro Alto Suite</h1>",
    },
  ];

  // Loop through markers
  for (var i = 0; i < markers.length; i++) {
    addMarker(markers[i]);
  }
}

// var country = "Germany";
// var geocoder;

// geocoder.geocode({ address: country }, function (results, status) {
//   if (status == google.maps.GeocoderStatus.OK) {
//     map.setCenter(results[0].geometry.location);
//   }
// });
