function checkinputStep1() {
    let a = $("#rt_room_category").val();
    let b = $("#rt_roomtype_name").val();
    if (a != "" && b != "") {
        $("#nextBtn").removeClass("disabled");
    } else {
        $("#nextBtn").addClass("disabled");
    }
}

function checkinputStep2() {
    let maxOccupancy = $("#rt_maximumOccupancy").val();
    let maxAdults = $("#rt_maximumAdults").val();
    let maxChildren = $("#rt_maximumChildren").val();
    let maxInfants = $("#rt_maximumInfants").val();
    let cal =
        parseInt(maxOccupancy) +
        parseInt(maxAdults) +
        parseInt(maxChildren) +
        parseInt(maxInfants);
    if (parseInt(maxOccupancy) > 0 && parseInt(maxAdults) > 0 && cal > 0) {
        $("#nextBtn").removeClass("disabled");
    } else {
        $("#nextBtn").addClass("disabled");
    }
}

function checkinputStep3() {
    let rt_roomsize = $("#rt_roomsize").val();
    let rt_bathroom = $("#rt_bathroom").val();
    let smoking_category = $("#smoking_category").val();
    let rt_roomview = $("#rt_roomview").val();
    let rt_aminities_facilities = $("#rt_aminities_facilities").val();
    let bedType = $("#bedType").val();
    if (
        rt_roomsize != "" &&
        rt_bathroom != "" &&
        smoking_category != "" &&
        rt_roomview != "" &&
        rt_aminities_facilities != "" &&
        bedType != "" &&
        rt_aminities_facilities != ""
    ) {
        $("#nextBtn").removeClass("disabled");
    } else {
        $("#nextBtn").addClass("disabled");
    }
}

function checkinputStep4() {
    $("#nextBtn").removeClass("disabled");
}

// this function used for occupancy validation called from custom.js
function checkOccupancy(id_name, value) {
    let rt_maximumOccupancy = parseInt(document.getElementById("rt_maximumOccupancy").value);
    if (id_name === 'rt_maximumAdults') {
        if (value > rt_maximumOccupancy) {
            $('.rt_maximumAdults_class').html('The maximum limit for adults has been exceeded.').addClass('text-danger');
            $("#nextBtn").addClass("disabled");
        } else {
            $('.rt_maximumAdults_class').html('');
            $("#nextBtn").removeClass("disabled");
        }
    }else if(id_name === 'rt_maximumChildren'){
        if (value >= rt_maximumOccupancy) {
            $('.rt_maximumChildren_class').html('The maximum limit for childrens has been exceeded.').addClass('text-danger');
            $("#nextBtn").addClass("disabled");

        } else {
            $('.rt_maximumChildren_class').html('');
            $("#nextBtn").removeClass("disabled");

        }
    }else if(id_name === 'rt_maximumInfants'){
        if (value >= rt_maximumOccupancy) {
            $('.rt_maximumInfants_class').html('The maximum limit for infants has been exceeded.').addClass('text-danger');
            $("#nextBtn").addClass("disabled");
        } else {
            $('.rt_maximumInfants_class').html('');
            $("#nextBtn").removeClass("disabled");
        }
    }
}

function selectSmokingPolicy(smokingPolicy) {
    if (smokingPolicy === "Smoking") {
        document.getElementById("smoking_category").value = "Smoking";
    } else {
        document.getElementById("smoking_category").value = "Non-Smoking";
    }
}

function preview_steps() {
    let rt_room_category = document.getElementById("rt_room_category").value;
    let rt_description_guests = document.getElementById("rt_description_guests").value;
    let rt_maximumOccupancy = document.getElementById("rt_maximumOccupancy").value;
    let rt_maximumAdults = document.getElementById("rt_maximumAdults").value;
    let rt_maximumChildren = document.getElementById("rt_maximumChildren").value;
    let rt_maximumInfants = document.getElementById("rt_maximumInfants").value;
    let rt_roomsize = document.getElementById("rt_roomsize").value;
    let rt_bathroom = document.getElementById("rt_bathroom").value;
    let rt_roomview = $("select[name='rt_roomview[]']").map(function () {
        return $(this).find("option:selected").map(function () {
            return {
                id: $(this).val(),
                name: $(this).text()
            };
        }).get();
    }).get();
    let rt_aminities_facilities = $("select[name='rt_aminities_facilities[]']").map(function () {
        return $(this).find("option:selected").map(function () {
            return {
                id: $(this).val(),
                name: $(this).text()
            };
        }).get();
    }).get();
    let bedConfig = [];
    let rt_bedType = $("select[name='bedType[]']").map(function () {
        return $(this).find("option:selected").map(function () {
            return {
                id: $(this).val(),
                name: $(this).text()
            };
        }).get();
    }).get();
    let bedtype_count = $("input[name='rt_bedType_count[]']").map(function(){return $(this).val();}).get();
    rt_bedType.forEach(function(element,key){
        if(element.id != ''){
            bedConfig.push({
                'bed_type':element.name,
                'count' : bedtype_count[key]
            });
        }
    });
    let append_Data = "";
    append_Data += `<div class="row form-input-wrapper ">
                        <div class="col-12">
                            <h4 class="text-uppercase mb-3">Guest Preview</h4>
                            <div class="card" style="max-width: 400px;">
                                <div class="card-header card-no-border pb-0">
                                    <h3 class="mb-0">${rt_room_category}</h3> </div>
                                <div class="card-body">
                                    <p class="mb-0"><span></span> ${rt_maximumAdults} adults, ${rt_maximumChildren}-child, ${rt_maximumInfants}-infant (${rt_maximumOccupancy} max) </p>
                                </div>
                            </div>
                            <h4 class="text-uppercase mb-3">Room Details</h4>
                            <div class="mt-4">
                                <h4 class="text-uppercase mb-3">General Information</h4>
                                <table class="table table-borderless room-review">
                                    <tr>
                                        <td class="text-muted px-0">Room Category</td>
                                        <td class="px-0">${rt_room_category}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted px-0">Discription For Guest</td>
                                        <td class="px-0">${rt_description_guests}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0">
                                            <h4 class="text-uppercase mt-2 px-0">Occupancy</h4></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted px-0">Maximum Occupancy</td>
                                        <td class="px-0">${rt_maximumOccupancy}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted px-0">Maximum Adult/Child/Infant</td>
                                        <td class="px-0">${rt_maximumAdults}/${rt_maximumChildren}/${rt_maximumInfants}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0">
                                            <h4 class="text-uppercase mt-2 ">Features</h4></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted px-0">Room Size</td>
                                        <td class="px-0">${rt_roomsize} m<sup>2</sup></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted px-0">Bathroom</td>
                                        <td class="px-0">${rt_bathroom}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted px-0">Room View</td>`;
                                        let roomview='';
                                        rt_roomview.forEach(function (element,key) {
                                            roomview += element.name;
                                            if(rt_roomview.length != (key+1)){
                                                roomview +=',';
                                            }
                                        });
                                        append_Data += `<td class="px-0">${roomview}</td>`;
                                    append_Data += `</tr>
                                    <tr>
                                        <td class="text-muted px-0">Amenities and facilities</td>`;
                                        let amenities_facilities='';
                                        rt_aminities_facilities.forEach(function (element,key) {
                                            amenities_facilities += element.name;
                                            if(rt_aminities_facilities.length != (key+1)){
                                                amenities_facilities +=',';
                                            }
                                        });
                                        append_Data += `<td class="px-0">${amenities_facilities}</td>`;
                                    append_Data += `</tr>
                                    <tr>
                                        <td class="text-muted px-0">Bed Type configurtion</td>
                                        <td class="px-0">`;
                                        bedConfig.forEach(function(element,key){
                                            append_Data += element.bed_type+`-`+element.count;
                                            if(bedConfig.length != (key+1)){
                                                append_Data +=' / ';
                                            }
                                        });
                                        append_Data += `</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>`;
    let elements = document.getElementsByClassName("rt_preview_data");
    for (let i = 0; i < elements.length; i++) {
        elements[i].innerHTML = append_Data;
    }
}

function increaseDecreaseBed(type,that){
    let last_value = $(that).parent().children()[1].value;
    if(type > 0){
        last_value++;
    }else{
        last_value--;
        if(last_value < 0){
            last_value = 0;
        }
    }
    $(that).parent().children()[1].value = last_value;
}

// bed configuration
function addroom(type='') {
  
  let ddlArray= new Array();
  let ddl = document.getElementById('bedType');
  for (i = 0; i < ddl.options.length; i++) {
    if(ddl.options[i].value != ''){
      ddlArray.push ({
       'id' : ddl.options[i].value,
       'name' : ddl.options[i].text,
      });
    }
  }
  let bedRoom ='';
  bedRoom +=`<div class="mb-2 p-3 bg-white border rounded">
          <div class=" d-flex justify-content-between align-items-center mb-2 rounded-touchspin" id="bedroom_numbers">
            <h5 class="mb-0">Bed </h5>
            <div class="d-flex justify-content-between align-items-center">
              <div class="touchspin-wrapper"> 
                  <button type="button" class="decrement-touchspin btn-touchspin touchspin-primary" onClick="increaseDecreaseBed(0,this)"><i class="icon-minus"></i></button>
                  <input class="input-touchspin spin-outline-primary" name="rt_bedType_count[]" type="number" value="1">
                  <button type="button" class="increment-touchspin btn-touchspin touchspin-primary" onClick="increaseDecreaseBed(1,this)"><i class="icon-plus"></i>
                  </button>
              </div>
            </div>
          </div>
          <select class="form-select form-select-sm" id="rt_room_category_types" name="bedType[]" required="" onchange="checkinputStep3()">`;
          bedRoom +=` <option value="">Select</option>`;
          ddlArray.forEach(element => {
            bedRoom +=` <option value="`+element.id+`">`+element.name+`</option>`;
          });
          bedRoom +=`</select>
    </div>`;
    if(type != ''){
      $('.edit-bedtype-container').append(bedRoom);
    }else{
      $('#bedroom-container').append(bedRoom);
    }
}

// Remove the bedroom when 'Delete' is clicked
function removeBedroom(button) {
  const bedroom = button.closest('.bedroom-container');
  bedroom.remove();
  const bedroomCount = document.querySelectorAll('#bedroom-container').length;
  const bedType = document.querySelector('.bedtype-container');
  if(bedroomCount === 1){
    bedType.style.display = "block";
  } else {
    bedType.style.display = "none";
  }
}

function removeBedSize(button,type = 1) {
  if(type > 0){
    $(button).parent().parent().parent().remove();
  }else{
    $(button).parent().parent().parent().parent().remove();
  }
}

let room_numbers = [];
function getRoomNumberCategory(x){

    room_numbers = [];
    $('#category_type_id').val(x);
    $('#addRoomNumberCategory').modal('show');
    $('#room_number_value').val('');
    $('.room-number-list').empty();
    $('.room-number-list-head').addClass('d-none');

    $.ajax({
        url: getCategoryRoom,
        type: "POST",
        data: {
            room_specification_id: x
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            
            if(response.rooms.length > 0){
                $('.room-number-list-head').removeClass('d-none');
                let output = '';
                response.rooms.forEach(function(element){
                    room_numbers.push(element.room_number);
                    if(element.category_id == x){
                        
                        output +=`<div class="input-group mb-3">
                            <input class="form-control" type="text" placeholder="Room Number" aria-label="Room Number" name="roomNumberList[]" value="${element.room_number}"`;
                            if(element.current_status == -1){
                                output +=` ><span class="input-group-text bg-danger" onClick="removeRoom(${element.room_number},this)"><i class="icon-minus txt-white" > </i></span>`;
                            }else{
                                output +=` readonly >`;
                            }
                        output +=`</div>`;

                    }

                });
                $('.room-number-list').append(output);
            }
        }
    });
    
}

function addNumber(){
    let room = $('#room_number_value').val();
    if(room == ''){
        $('.room-number-error').html('Room Number is Required');
    }else{
        let chk = room_numbers.includes(room);
        if(chk){
            $('.room-number-error').html('Room Number Already Exists');
        }else{
            room_numbers.push(room);
            $('.room-number-error').html('');
            $('.room-number-list-head').removeClass('d-none');
            $('.room-number-list').append(`
                <div class="input-group mb-3">
                    <input class="form-control" type="text" placeholder="Room Number" aria-label="Room Number" name="roomNumberList[]" value="${room}"><span class="input-group-text bg-danger" onClick="removeRoom(${room},this)"><i class="icon-minus txt-white" > </i></span>
                </div>
            `);
            $('#room_number_value').val('');
        }
    }
}

function removeRoom(x,that){
    room_numbers = room_numbers.filter((item) => item != x);
    $(that).parent().remove();
}

function addRoomData(){
    let roomNumber = $("input[name='roomNumberList[]']").map(function(){return $(this).val();}).get();
    let allroomNumber = [];
    roomNumber.forEach(function(element,key){
        if(element != ''){
            allroomNumber.push(element);
        }
    });

    if(allroomNumber.length > 0){
        let room_specification_id = $('#category_type_id').val();
        $.ajax({
            url: addRoom,
            type: "POST",
            data: {
                room_specification_id: room_specification_id,room_num: allroomNumber
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#addRoomNumberCategory').modal('hide');
                    toastSuccessAlert(response.success);
                    setTimeout(() => {
                        location.reload();
                    }, 2500); // Delay in milliseconds
                }else if(response.alreadyfound_error){
                    toastErrorAlert(response.alreadyfound_error);
                } else {
                    // alert(response.error_success);
                }
            }
        });

    }else{
        toastErrorAlert("Atleast one rooms is required");
    }
}