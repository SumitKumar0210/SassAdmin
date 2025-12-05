//alert("hello");
// document.addEventListener("DOMContentLoaded", function () {
//     var menuItems = document.querySelectorAll('.has-submenu');
//     console.log(menuItems);
//     menuItems.forEach(function (item) {
//         item.addEventListener('click', function () {
//             this.querySelector('.submenu').classList.toggle('active');
//             this.querySelector('.toggle-icon').innerHTML = (this.querySelector('.submenu').classList.contains('active')) ? '<i class="fa-solid fa-minus"></i>' : '<i class="fa-solid fa-plus"></i>';
//         });
//     });
// });

$(document).ready(function() {
    $(document).on('click', '.has-submenu', function() {
        var submenu = $(this).find('.submenu');
        var toggleIcon = $(this).find('.toggle-icon');

        submenu.toggleClass('active');
        if (submenu.hasClass('active')) {
            toggleIcon.html('<i class="fa-solid fa-minus"></i>');
        } else {
            toggleIcon.html('<i class="fa-solid fa-plus"></i>');
        }
    });
});

function showVeg() {
   // alert("veg");
    let vegItems = document.querySelectorAll(".veg-item");
    let vegMenu = document.querySelector('.veg-menu');
    let nonvegItems = document.querySelectorAll(".nonveg-item");
    let nonvegMenu = document.querySelector('.nonveg-menu');

    vegMenu.classList.add('active');
    nonvegMenu.classList.remove('active');

    nonvegItems.forEach(function (el) {
        el.classList.add("d-none");
    });

    vegItems.forEach(function (el) {
        el.classList.remove("d-none");
    });

};

function showNonveg() {
 //   alert("non veg");
    let vegItems = document.querySelectorAll(".veg-item");
    let vegMenu = document.querySelector('.veg-menu');
    let nonvegItems = document.querySelectorAll(".nonveg-item");
    let nonvegMenu = document.querySelector('.nonveg-menu');

    vegMenu.classList.remove('active');
    nonvegMenu.classList.add('active');

    nonvegItems.forEach(function (el) {
        el.classList.remove("d-none");
    });

    vegItems.forEach(function (el) {
        el.classList.add("d-none");
    });

};

function showDiv() {
    var showItem = document.getElementById("show");
    //   var btnText = document.getElementById("notification");
    var expandText = document.getElementById("expandtext");

    if (showItem.style.display === "block") {
        showItem.style.display = "none";
        expandText.innerHTML = "Show <i class='fa-solid fa-chevron-down ml-2'></i>";
        // showItem.style.display = "none";

    } else if (showItem.style.display === "none") {
        showItem.style.display = "block";
        expandText.innerHTML = "Hide <i class='fa-solid fa-chevron-up ml-2'></i>";

    }
}

const toggleSearchBtn = document.getElementById('toggleSearchBtn');
const searchBarDiv = document.getElementById('searchBarDiv');
const searchIcon = document.getElementById('searchIcon');
let searchOpen = false;

  toggleSearchBtn.addEventListener('click', () => {
    searchOpen = !searchOpen;
    if (searchOpen) {
      searchBarDiv.classList.remove('d-none');
      searchIcon.classList.remove('ri-search-line');
      searchIcon.classList.add('ri-close-line');
      // Optional: Focus the input field
      searchBarDiv.querySelector('input').focus();
    } else {
      searchBarDiv.classList.add('d-none');
      searchIcon.classList.remove('ri-close-line');
      searchIcon.classList.add('ri-search-line');
      searchBarDiv.querySelector('input').value = '';
    }
});