$(document).ready(function () {
    // Handle toggle click
    $(".room-type-toggle").on("click", function () {
        // Find the closest parent container
        const parent = $(this).closest(".room-type-wrapper");
        // Hide the sibling room-type-gallery
        parent.find(".room-type-gallery").toggle();

        // Toggle the visibility of the related room-type-toggle-container
        parent.next(".room-type-toggle-container").slideToggle();
        // Change the icon in the toggle
        const icon = $(this).find("i");
        if (icon.hasClass("icofont-thin-down")) {
            icon.removeClass("icofont-thin-down").addClass("icofont-thin-up");
            $(".room-type-wrapper").addClass("rounded-top");
            $(".room-type-wrapper").removeClass("border-radius-4");
        } else {
            icon.removeClass("icofont-thin-up").addClass("icofont-thin-down");
            $(".room-type-wrapper").addClass("border-radius-4");
        }
    });

    // ----------start display order---------//
    // Initialize the selectpicker
    $("#rte_facilities").selectpicker();
    // Event listener for when the selection changes
    $("#rte_facilities").change(function () {
        // Clear the existing list items before adding new ones
        $("#facilities-list").empty();
        // Loop through all selected options
        $("#rte_facilities option:selected").each(function () {
            var selectedText = $(this).text(); // Get the text of the selected option
            $("#facilities-list").append(
                '<li class="list-group-item py-2 border my-1">' +
                    '<i class="ri-draggable"></i>' +
                    selectedText +
                    "</li>"
            ); // Append the text as <li> to the <ul>
        });
    });

    // start list shortable--------//
    $("#facilities-list").sortable({
        cursor: "move",
        placeholder: "ui-state-highlight",
    });
    // end list shortable--------//
});

// ----------end display order---------//
// ---------- start edit Bed type configuration  -------//

// function editAddroom() {
//     // Get the bedroom container
//     const bedroomContainer = document.getElementById("edit-bedroom-container");
//     // Clone the bedroom container
//     const newBedroom = bedroomContainer.cloneNode(true);
//     // Modify the new bedroom's content, if necessary
//     const newBedroomNumber = newBedroom.querySelector("h5");
//     const bedroomCount = document.querySelectorAll("#edit-bedroom-container").length;
//     bedroomContainer.style.display = "block";
//     newBedroomNumber.textContent = `Bedroom ${bedroomCount}`;
//     // Append the new bedroom to the container
//     bedroomContainer.parentElement.insertBefore(
//         newBedroom,
//         document.querySelector(".edit-add-extra-rooms").parentElement
//     );

//     const bedType = document.querySelector(".edit-bedtype-containers");
//     bedType.style.display = "none";
// }

// Remove the bedroom when 'Delete' is clicked
// function editRemoveBedrooms(button) {
//     const bedroom = button.closest(".edit-bedroom-containers");
//     bedroom.remove();
//     const bedroomCount = document.querySelectorAll("#edit-bedroom-container").length;
//     const bedType = document.querySelector(".edit-bedtype-containers");
//     if (bedroomCount === 1) {
//         bedType.style.display = "block";
//     } else {
//         bedType.style.display = "none";
//     }
// }

function editRemoveBedSizes(button) {
    const bedSize = button.closest(".edit-bedsize-containers");
    if (bedSize) {
        bedSize.classList.add("d-none"); // Correctly adds the "d-none" class in plain JavaScript
    }
}

$(".edit-bedsize-containers").hide();
$("#edit-bedType").on("change", function () {
    var selectopt = $(this).val();
    $(".edit-bedsize-containers").show();
    $("#edit-bedTypeSelected").text(selectopt);
});

// ----------end edit Bed type configuration -------//

$(document).ready(function () {
    // Make only the rows with class "sortable-row" sortable
    $("tbody").sortable({
        items: ".room-title",
        helper: "clone",
    });
    $(".single-room").sortable();
    $(".double-room").sortable();
});

// $('.assign-gallery').on('click', '.close-images', function() {
//   var wrapper = $(this).closest('.assign-gallery'); // Find the parent gallery
//   var elements = wrapper.find('.assgin-images'); // Find all images inside the gallery

//   if (elements.length > 0) {
//       $(this).closest('.assgin-images').remove(); // Remove the clicked image
//   }

//   // Check if there are no more images left
//   if (wrapper.find('.assgin-images').length === 0) {
//       wrapper.hide(); // Hide the gallery
//   }
// });

(function ($) {
    "use strict";
    $(".gallery-media").slick({
        slidesToShow: 1, // Show 1 slide at a time
        slidesToScroll: 1, // Scroll 1 slide at a time
        arrows: true,
        dots: false, // Enable navigation arrows
        autoplay: true, // Optional: enable autoplay
        autoplaySpeed: 3000,
        nextArrow:
            '<div class="left-arrow"><i class="ri-arrow-left-s-line"></i></div>',
        prevArrow:
            '<div class="right-arrow"><i class="ri-arrow-right-s-line"></i></div>',
    });
})(jQuery);

(function ($) {
    "use strict";
    $(".room-type-gallery").slick({
        slidesToShow: 1, // Show 1 slide at a time
        slidesToScroll: 1, // Scroll 1 slide at a time
        arrows: true,
        dots: true, // Enable navigation arrows
        autoplay: true, // Optional: enable autoplay
        autoplaySpeed: 3000,
        nextArrow:
            '<div class="left-arrow"><i class="ri-arrow-left-s-line"></i></div>',
        prevArrow:
            '<div class="right-arrow"><i class="ri-arrow-right-s-line"></i></div>',
    });
})(jQuery);
