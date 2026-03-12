$(document).ready(function () {

    // $( ".site_datepiker").datepicker();
    var myCarousel = $(".carousel");
    $(".carousel-control-prev, .carousel-control-next").hover(
        function () {
            myCarousel.carousel('pause');
        },
        function () {
            myCarousel.carousel('cycle');
        }
    );

});

$('.carousel').removeAttr('data-bs-ride');

$('.carousel').carousel({ interval: 4000 });

// Function to start the carousel
function startCarousel(carousel) {
    carousel.carousel('cycle');
}

// Function to stop the carousel
function stopCarousel(carousel) {
    carousel.carousel('pause');
}

// Attach hover event handlers to each carousel
$('.carousel').hover(
    function () {
        startCarousel($(this));
    },
    function () {
        stopCarousel($(this));
    }
);





function submitContactForm() {
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var email = $('#email').val();
    var phone=$('#phone_number').val();
    var message = $('#message').val();
    var reason = $('#reason').val();

    if (phone.trim() == '') {
        $('#phone_number').focus();
        $('.statusMsg').html('<div class="alert alert-danger" role="alert">Phone number is required.</div>');
        return false;
    }
    if (fname.trim() == '') {
        $('#fname').focus();
        $('.statusMsg').html('<div class="alert alert-danger" role="alert">First name is required.</div>');
        return false;
    }
    else if (lname.trim() == '') {
        $('#lname').focus();
        $('.statusMsg').html('<div class="alert alert-danger" role="alert">Last name is required.</div>');
        return false;
    }

    else if (email.trim() == '') {
        $('#email').focus();
        $('.statusMsg').html('<div class="alert alert-danger" role="alert">Email is required.</div>');
        return false;
    } else if (email.trim() != '' && !reg.test(email)) {
        $('#email').focus();
        $('.statusMsg').html('<div class="alert alert-danger" role="alert">Email is not valid.</div>');
        return false;
    }
    else if (message.trim() == '') {
        $('#message').focus();
        $('.statusMsg').html('<div class="alert alert-danger" role="alert">Message is required.</div>');
        return false;
    }
    else if (reason.trim() == '') {
        $('#reason').focus();
        $('.statusMsg').html('<div class="alert alert-danger" role="alert">Reason is required.</div>');
        return false;
    }

    else {
    console.log('submitted form running ajax');

        $.ajax({
            type: 'POST',
            url: 'https://www.villafabulosa.com/contact.php',
            data: 'contactFrmSubmit=1&fname=' + fname + '&lname=' + lname + '&email=' + email + '&phone=' +phone+ '&message=' + message+ '&reason=' + reason,
            beforeSend: function () {
                $('.submitBtn').attr("disabled", "disabled");
                $('.modal-body').css('opacity', '.5');
            },
            success: function (msg) {
                if (msg == 'ok') {
                    $('.statusMsg').html('<div class="alert alert-success" role="alert">Thanks for contacting us, we\'ll get back to you soon.</div>');
                    $("#requestform")[0].reset();


                } else {
                    $('.statusMsg').html('<div class="alert alert-danger" role="alert">Some problem occurred, please try again!</div>');
                }
                $('.submitBtn').removeAttr("disabled");
                $('.modal-body').css('opacity', '');
                let person={
                    first_name:fname,
                    last_name:lname,
                    email:email,
                    phone:phone,
                    message:message,
                    reason:reason
                }

                saveContact(person);
            },
            error: function (xhr, status, error) {
                console.log(error);
                if (xhr.status == 500) {
                    $('.statusMsg').html('<div class="alert alert-danger" role="alert">Internal Server Error. Please try again later.</div>');
                } else {
                    $('.statusMsg').html('<div class="alert alert-danger" role="alert">An error occurred. Please try again.</div>');
                }
                $('.submitBtn').removeAttr("disabled");
                $('.modal-body').css('opacity', '');
            }
        });
    }
}



/* ================= Book Now Form start ======================== */

function submitBookForm() {
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var email = $('#email').val();
    var about = $('#about').val();
    var occasion = $('#occasion').val();
    var fdate = $('#fdate').val();
    var ldate = $('#ldate').val();
    var people = $('#people').val();
    var hearabout = $('#hear-about-villa').val();
    var message = $('#message').val();

    if (fname.trim() == '') {
        $('#fname').focus();
        return false;
    }
    else if (lname.trim() == '') {
        $('#lname').focus();
        return false;
    }

    else if (email.trim() == '') {
        $('#email').focus();
        return false;
    } else if (email.trim() != '' && !reg.test(email)) {
        $('#email').focus();
        return false;
    }

    else if (about.trim() == '') {
        $('#about').focus();
        return false;
    }

    else if (occasion.trim() == '') {
        $('#occasion').focus();
        return false;
    }

    else if (fdate.trim() == '') {
        $('#fdate').focus();
        return false;
    }

    else if (ldate.trim() == '') {
        $('#ldate').focus();
        return false;
    }

    else if (people.trim() == '') {
        $('#people').focus();
        return false;
    }

    else if (hearabout.trim() == '') {
        $('#hear-about-villa').focus();
        return false;
    }

    else if (message.trim() == '') {
        $('#message').focus();
        return false;
    }


    else {
        $.ajax({
            type: 'POST',
            url: 'book.php',
            data: 'contactFrmSubmit=1&fname=' + fname + '&lname=' + lname + '&email=' + email + '&about=' + about + '&occasion=' + occasion + '&fdate=' + fdate + '&ldate=' + ldate + '&people=' + people + '&hearabout=' + hearabout + '&message=' + message,
            beforeSend: function () {
                $('.submitBtn').attr("disabled", "disabled");
                $('.modal-body').css('opacity', '.5');
            },
            success: function (msg) {
                if (msg == 'ok') {
                    $('.statusMsg').html('<div class="alert alert-success" role="alert">Thanks for contacting us, we\'ll get back to you soon.</div>');
                    $("#booknowform")[0].reset();


                } else {
                    $('.statusMsg').html('<div class="alert alert-danger" role="alert">Some problem occurred, please try again.</div>');
                }
                $('.submitBtn').removeAttr("disabled");
                $('.modal-body').css('opacity', '');
            }
        });
    }
}

function checkCookie() { }

/* ================= Book Now Form end ======================== */
