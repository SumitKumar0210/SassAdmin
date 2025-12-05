// Increase Decrese Function of add room type
let getInputByClass = document.getElementsByClassName("input-touchspin");
Array.from(getInputByClass).forEach((elem, i) => {
  let inputData = elem.getAttribute("value");
  let isIncrement = elem.parentNode.querySelectorAll(".increment-touchspin");
  let isDecrement = elem.parentNode.querySelectorAll(".decrement-touchspin");
  if(isIncrement) {
    isIncrement[0].addEventListener("click", () => {
      inputData++;
      elem.setAttribute("value", inputData);
      checkinputStep2();
      checkOccupancy(elem.id,inputData); //for occupency validation of roomtype
    });
  }
  if(isDecrement) {
    isDecrement[0].addEventListener("click", () => {
      if (inputData > 0) {
        inputData--;
        elem.setAttribute("value", inputData);
        checkinputStep2();
        checkOccupancy(elem.id,inputData); //for occupency validation of roomtype
      }
    });
  }
});

// reservation table full screen start
$('#normalscreen').hide();
var elem = document.getElementById("fullscreen-table");
$('#fullscreen').click(function () {
 
  function openFullscreen() {
    if (elem.requestFullscreen) {
      elem.requestFullscreen();
      
    } else if (elem.webkitRequestFullscreen) {
      elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) {
      elem.msRequestFullscreen();
    }
  }

  openFullscreen();
  $('#fullscreen').hide();
  $('#normalscreen').show();
  // $(".full-screen-icon").addClass("full-screen-on");
  $(".page-body").addClass("full-screen-page-body");
  $(".page-sub-header").addClass("full-screen-page-sub-header");
  $(".page-header").addClass("full-screen-page-header");
  $(".footer").addClass("mt-0");
  $(".footer").removeClass("mt-4");
});

$('#normalscreen').click(function () {
  $('#fullscreen').show();
  $('#normalscreen').hide();
  // $(".full-screen-icon").removeClass("full-screen-on");
  $(".page-body").removeClass("full-screen-page-body");
  $(".page-sub-header").removeClass("full-screen-page-sub-header");
  $(".page-header").removeClass("full-screen-page-header");
  $(".footer").addClass("mt-4");
  $(".footer").removeClass("mt-0");
  function closeFullscreen() {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    }
  }
  closeFullscreen();
});
// reservation table full screen end

$('body').on('click', '.toggle-section, .room-title', function (e) {
  // Prevent duplicate triggers by ensuring the closest toggle-section is handled
  const toggleButton = $(this).closest('.room-title').find('.toggle-section');
  const section = toggleButton.data('section');
  const rows = $(`.${section}`);
  // Avoid extra DOM lookups by using toggle and cached data
  rows.toggleClass('hidden');
  
  // Update icon efficiently
  const icon = toggleButton.find('.expand-icon');
  icon.toggleClass('icofont-caret-down icofont-caret-up');
});
// ----------- Add Another room Function ------------//

  // Function to add a new room reservation
  var count = 1;
   $('.formclosebtn').hide();
  $("#addAnotherRoom").click(function () {
    if (count < 5) {
      $('.formclosebtn').show();
        var $addinput = $("#roomReserve");
        $("#addReservation").clone().prependTo($addinput);
        count++;
    } else {
        $("#add-cert").off("click");
    }
  });
  // Function to remove the room reservation
  $(document).on("click", ".formclosebtn", function () {
      if (count > 1) {
          $(this).closest(".room-type-bar").remove();
          count--;
      }
      if(count<=1){
        $('.formclosebtn').hide();
      }
  });
//-------------------------add rooms on edit page-------------------//
  let countt = 0;

  $('body').on('click', '#addAnotherRoomEdit', function () {
      if (countt === 0) {
          $('#roomReserveEdit').show();
      } else if (countt < 5) {
          let $addinput1 = $("#roomReserveEdit");
          $("#addRoomsEdit").clone().appendTo($addinput1);
      }
      countt++;
  });
  
  $('body').on('click', '.formclosebtnEdit', function () {
    $(this).closest(".room-type-bar-Edit").remove();
    countt--;
    if (countt === 0) {
        $('#roomReserveEdit').hide();
        $('#addAnotherRoomEdit').hide();
        $('#submitNewRooms').hide();
    }
});
// Function to remove the room reservation
 
// Step script start
let currentStep = 1;
const totalSteps = 5;
let currentIndex = 0;
const contents = document.querySelectorAll('.content');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const submitBtn = document.getElementById('submitBtn');
const steps = document.querySelectorAll('.form-step');
function showStep(step) {
    // Hide all steps
    
    steps.forEach(step => step.style.display = 'none');
    
    // // Show the current step
     document.getElementById('step' + step).style.display = 'block';
    
    // Show or hide buttons based on the current step
 
        prevBtn.style.display = 'none';  
        nextBtn.style.display = 'none'; 
        submitBtn.style.display = 'none'; 

    if (step === 1) {
      prevBtn.style.display = 'none';
    } 
    else {
      prevBtn.style.display = 'block';
    }
    
    
    if (step === steps.length) {
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'block';
    } else {
        nextBtn.style.display = 'block';
        submitBtn.style.display = 'none';
    }
}
// Initially show the first step
// showStep(currentStep);

function nextStep() {
    if(currentStep < totalSteps) {
      document.getElementById(`step${currentStep}`).classList.remove('active');
      currentStep++;
    
      if(currentStep >=totalSteps){
        preview_steps();
      }
      document.getElementById(`step${currentStep}`).classList.add('active');
      document.querySelectorAll('.vertical-timeline .step')[currentStep - 1].classList.add('active');
      updateProgress();
      showStep(currentStep);
      currentIndex = (currentIndex + 1) % contents.length;
      showContent(currentIndex);
    }
    stepCheck(currentStep);
}

function prevStep() {
   
    if (currentStep > 1) {
      document.getElementById(`step${currentStep}`).classList.remove('active');
      document.querySelectorAll('.vertical-timeline .step')[currentStep - 1].classList.remove('active');
      
      currentStep--;
      document.getElementById(`step${currentStep}`).classList.add('active');
      document.querySelectorAll('.vertical-timeline .step')[currentStep - 1].classList.add('active');
      
      updateProgress();
      showStep(currentStep);
      currentIndex = (currentIndex - 1 + contents.length) % contents.length;
      showContent(currentIndex);
    }
    stepCheck(currentStep);
}

function stepCheck(currentStep){
  if(currentStep == 1){
    checkinputStep1();
  }else if(currentStep == 2){
    checkinputStep2();
  }else if(currentStep == 3){
    checkinputStep3();
  }else if(currentStep == 4){
    checkinputStep4();
  }
}

function updateProgress() {
    const percentage = (currentStep / totalSteps) * 100;
    document.querySelector('.circle').style.strokeDasharray = `${percentage}, 100`;
    // document.querySelector('.percentage').textContent = `${currentStep} OF ${totalSteps}`;
    document.querySelector('.percentage').innerHTML = '<tspan dy="0" class="step-color">'+`${currentStep}`+'</tspan> <tspan dy="0"> OF </tspan> <tspan dy="0">'+`${totalSteps}`+'</tspan>';

}

// document.addEventListener('DOMContentLoaded', () => {
//     document.getElementById('step1').classList.add('active');
//     document.querySelector('.vertical-timeline .step').classList.add('active');
//     updateProgress();
// });

function showContent(index) {
    contents.forEach((content, i) => {
        content.classList.toggle('active', i === index);
    });
}
  // /-------------- New Reservation start----------------------//
$('.wrapper').on('click', '.remove', function() {
$('.remove').closest('.wrapper').find('.element').not(':first').last().remove();
});
$('.wrapper').on('click', '.clone', function() {
$('.clone').closest('.wrapper').find('.element').first().clone().appendTo('.results');
});
//-------------- New Reservation end----------------------//

//-------------- New detail tab start----------------------//
$('.d-tab-wrapper').on('click', '.d-tab-remove', function() {
$('.d-tab-remove').closest('.d-tab-wrapper').find('.d-tab-element').not(':first').last().remove();
});
$('.d-tab-wrapper').on('click', '.d-tab-clone', function() {
$('.d-tab-clone').closest('.d-tab-wrapper').find('.d-tab-element').first().clone().appendTo('.d-tab-results');
});

$('body').on('click', '.cancelslide-Dtab', function(){
  $('.paymentRec-Dtab').css({"right":"0px", "opacity":"0"});
  $('#dtab-showbtn').css("opacity","1");
});

$('body').on('click', '.p-recordBtnShow', function(){
  checkroomchecked(); // if any room checked then only payment model open (custom_backend.js)
  // $('.paymentRec-Dtab').css({"right":"100%", "opacity":"1"});
  // $('#dtab-showbtn').css("opacity","0");
});

$('body').on('click', '#dtab-showbtn', function(){
  $('.paymentRec-Dtab').css({"right":"100%", "opacity":"1"});
  $('#dtab-showbtn').css("opacity","0");
});

$('body').on('click', '#dtab-hidebtn', function(){
  $('.paymentRec-Dtab').css({"right":"0%", "opacity":"0"});
  $('#dtab-showbtn').css("opacity","1");
});

// --Record Payment end//
$('.guestEmail').hide();
$('#Dtab-email').click(function(){
$('.guestEmail').show();
})

//-------------- New detail tab end----------------------//



//-------------- New Guest tab start----------------------//

$('body').on('click', '.g-tab-clone', function() {
  $('.g-tab-clone').closest('.g-tab-wrapper').find('.g-tab-element').first().clone().appendTo('.g-tab-results');
  });
  $('body').on('click', '.g-tab-remove', function() {
    var wrapper = $(this).closest('.g-tab-wrapper');
    var elements = wrapper.find('.g-tab-element');
    // Check if there is more than one element
    if (elements.length > 1) {
        // Remove the closest element to the clicked remove button
        $(this).closest('.g-tab-element').remove();
    }
    // Hide the remove button if there's only one element left
    if (elements.length <= 1) {
        wrapper.find('.g-tab-remove').hide();
    }
  });

// -----------------add guest start ----------//
$('#guestTabCol').hide();
$('#g-tabAddroom').click(function(){
$('#guestTabCol').show();
$('.addGuestsTitle').hide();
});
// -----------------add guest end ----------//

//-------------- New Guest tab end----------------------//
//---------------new room add----------------------//

// Event listener for cloning room rows
$('body').on('click', '.g-tab-clone-room', function() {
  $('.g-tab-results-room').find('.d-tab-element').first().clone().appendTo('.g-tab-results-room');
});

// Event listener for removing room rows
$('body').on('click', '.g-tab-remove', function() {
  // var wrapper = $(this).closest('.g-tab-wrapper');
  var elements = $('.g-tab-results-room').find('.d-tab-element');
  // Check if there is more than one element
  if (elements.length > 1) {
    // Remove the closest element to the clicked remove button
    $(this).closest('.d-tab-element').remove();
  }
  // Hide the remove button if there's only one element left
  if(elements.length <= 1) {
    elements.find('.g-tab-remove').hide();
  }
});
//---------------new room add end----------------------//

// -------------payment tab start-----------------//
$('.cancelslide-Paytab').click(function(){
  $('.paymentRec-Paytab').css({"right":"0px", "opacity":"0"});
  $('#paytab-showbtn').css("opacity","1");
})

$('.p-recordBtnShow-Paytab').click(function(){
  $('.paymentRec-Paytab').css({"right":"100%", "opacity":"1"});
  $('#paytab-showbtn').css("opacity","0");

})

$('#paytab-showbtn').click(function(){
  $('.paymentRec-Paytab').css({"right":"100%", "opacity":"1"});
  $('#paytab-showbtn').css("opacity","0");
});

$('#paytab-hidebtn').click(function(){
  $('.paymentRec-Paytab').css({"right":"0%", "opacity":"0"});
  $('#paytab-showbtn').css("opacity","1");
});

$('.payEmail').hide();
$('#Paytab-email').click(function(){
  $('.payEmail').show();
})
// -------------payment tab end-----------------//

// -------------notes tab start-----------------//
$('.cancelslide-Notetab').click(function(){
  $('.paymentRec-Notetab').css({"right":"0px", "opacity":"0"});
  $('#notetab-showbtn').css("opacity","1");
})

$('.p-recordBtnShow-Notetab').click(function(){
 $('.paymentRec-Notetab').css({"right":"100%", "opacity":"1"});
 $('#notetab-showbtn').css("opacity","0");
})

$('#notetab-showbtn').click(function(){
  $('.paymentRec-Notetab').css({"right":"100%", "opacity":"1"});
  $('#notetab-showbtn').css("opacity","0");
});

$('#notetab-hidebtn').click(function(){
  $('.paymentRec-Notetab').css({"right":"0%", "opacity":"0"});
  $('#notetab-showbtn').css("opacity","1");
});

$('.NoteEmail').hide();
$('#Notetab-email').click(function(){
  $('.NoteEmail').show();
})
// -------------notes tab end-----------------//

$('#emailaAlert').hide();
$('#emailInvoice').click(function(){
  $('#emailaAlert').show();
});
// ------------invoice Tab end ----------------------//

// -----------------confirmStatus start------------------//

$('.confirmStatus').click(function(){
  $(this).html('Checkin');
});

// -----------------confirmStatus end------------------//
// ------------footer start--------------//

$('#payment-tab').click(function(){
  $('#footerC-btn').hide();
});
$('#Notes-tabs').click(function(){
  $('#footerC-btn').hide();
});
$('#guestsTab').click(function(){
  $('#footerC-btn').hide();
});
$('#invoice-tab').click(function(){
  $('#footerC-btn').hide();
});
$('#detailTab').click(function(){
  $('#footerC-btn').show();
});
// ------------footer end--------------//

// Remove the bedroom when 'Delete' is clicked
function editRemoveBedrooms(button) {
  const bedroom = button.closest('.edit-bedroom-containers');
  bedroom.remove();
  const bedroomCount = document.querySelectorAll('#edit-bedroom-container').length;
  const bedType = document.querySelector('.edit-bedtype-containers');
  if(bedroomCount === 1){
    bedType.style.display = "block";
  } else {
    bedType.style.display = "none";
  }
}

function editRemoveBedSizes(button) {
  const bedSize = button.closest('.edit-bedsize-containers');
  if (bedSize) {
    bedSize.classList.add("d-none"); // Correctly adds the "d-none" class in plain JavaScript
  }
}
// ----------end edit Bed type configuration -------//

$('.results').on('click', '.remove', function() { $(this).closest('.element').remove(); });

// ---------------- row view reservation js------------------------------
 
$('.grid-number').on('scroll', function() {
  $('.chart-container').scrollLeft($(this).scrollLeft());
});

$('.chart-container').on('scroll', function() {
  $('.grid-number').scrollLeft($(this).scrollLeft());
});

$(document).ready(function() {
  function handleScroll(scrollContainer, rowSelector, upButton, downButton) {
    var rowsIndex = 0;
    var rows = $(rowSelector);

    function scrollToRow(index) {
      var row = $(rows[index]);
      $(scrollContainer).animate({
        scrollTop: row.offset().top - $(scrollContainer).offset().top + $(scrollContainer).scrollTop()
      }, 900);
    }

    $(upButton).click(function() {
      if (rowsIndex > 0) {
        scrollToRow(--rowsIndex);
        // console.log("Scrolling up, current index:", rowsIndex);
      }
    });

    $(downButton).click(function() {
      if (rowsIndex < rows.length - 1) {
        scrollToRow(++rowsIndex);
        // console.log("Scrolling down, current index:", rowsIndex);
      }
    });
  }

  // Apply the scroll behavior to both containers
  handleScroll('.chart-container', '.grid-row', '.up-grids', '.down-grids');
  handleScroll('.grid-date', '.grid-rowss', '.up-grids', '.down-grids');
});

$('.grid-date').on('scroll', function() {
  $('.chart-container').scrollTop($(this).scrollTop());
});

$('.chart-container').on('scroll', function() {
  $('.grid-date').scrollTop($(this).scrollTop());
});

// toast success alert start---------
function toastSuccessAlert(message){
  $('.toast-alert-success-msg').html('');
  $('.toast-alert-success-msg').html(message);
  var toastElement = document.getElementById('liveToastSuccessAlert');
  var toast = new bootstrap.Toast(toastElement);
  toast.show();
}
// toast alert ends---------
// toast warning alert start---------
function toastWarningAlert(message){
  $('.toast-alert-warning-msg').html('');
  $('.toast-alert-warning-msg').html(message);
  var toastElement = document.getElementById('liveToastWarningAlert');
  var toast = new bootstrap.Toast(toastElement);
  toast.show();
}
// toast alert ends---------
// toast failed alert start---------
function toastErrorAlert(message){
  $('.toast-alert-error-msg').html('');
  $('.toast-alert-error-msg').html(message);
  var toastElement = document.getElementById('liveToastErrorAlert');
  var toast = new bootstrap.Toast(toastElement);
  toast.show();
}
// toast alert ends---------