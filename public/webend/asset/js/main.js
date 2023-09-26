// for the sidebar
// console.log("hello");
const sidebar = document.getElementById('sidebar');

const toggleSidebarMobile = (sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose) => {
    sidebar.classList.toggle('hidden');
    sidebarBackdrop.classList.toggle('hidden');
    toggleSidebarMobileHamburger.classList.toggle('hidden');
    toggleSidebarMobileClose.classList.toggle('hidden');
}

const toggleSidebarMobileEl = document.getElementById('toggleSidebarMobile');
const sidebarBackdrop = document.getElementById('sidebarBackdrop');
const toggleSidebarMobileHamburger = document.getElementById('toggleSidebarMobileHamburger');
const toggleSidebarMobileClose = document.getElementById('toggleSidebarMobileClose');




toggleSidebarMobileEl.addEventListener('click', () => {
    toggleSidebarMobile(sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose);
});

sidebarBackdrop.addEventListener('click', () => {
    toggleSidebarMobile(sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose);
});



// for the toggle password visibility

// const passwordVisibilityBtn = document.querySelector('#passwordVisibiltyIcon')
// const showPasswordVisibility = document.querySelector('#password')
// const showPassIcon = document.querySelector('#showEyeIcon')
//
// if(passwordVisibilityBtn!=null)
// {
//     passwordVisibilityBtn.addEventListener('click', ()=>{
//         if(showPasswordVisibility.type == "password"){
//             showPasswordVisibility.type ="text";
//             showPassIcon.name = "eye";
//         }
//         else{
//             showPasswordVisibility.type ="password";
//             showPassIcon.name = "eye-off"
//         }
//     })
// }

function passwordToggle(e1, e2, e3)
{
    const passwordVisibilityBtn = document.querySelector(e1)
    const showPasswordVisibility = document.querySelector(e2)
    const showPassIcon = document.querySelector(e3)

    if(passwordVisibilityBtn!=null)
    {
        if(showPasswordVisibility.type == "password"){
            showPasswordVisibility.type ="text";
            showPassIcon.name = "eye";
        }
        else{
            showPasswordVisibility.type ="password";
            showPassIcon.name = "eye-off"
        }
    }
}

// for the delete sweet alert




$('.deleteConfirmCategory').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    swal({
        title: 'Are you sure?',
        text: 'This record will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
        dangerMode: true,
    }).then(function(value) {
        if (value) {
            window.location.href = url;
        }
    });

});

$('.deleteConfirmTags').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    swal({
        title: 'Are you sure?',
        text: 'This record will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
        dangerMode: true,
    }).then(function(value) {
        if (value) {
            window.location.href = url;
        }
    });

});



$('.deleteConfirmAuthor').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    swal({
        title: 'Are you sure?',
        text: 'This record will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
        dangerMode: true,
    }).then(function(value) {
        if (value) {
            window.location.href = url;
        }
    });

});


$('.deleteConfirmUser').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    swal({
        title: 'Are you sure?',
        text: 'This record will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
        dangerMode: true,
    }).then(function(value) {
        if (value) {
            window.location.href = url;
        }
    });

});



$('.deleteConfirmPost').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    swal({
        title: 'Are you sure?',
        text: 'This record will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
        dangerMode: true,
    }).then(function(value) {
        if (value) {
            window.location.href = url;
        }
    });

});
