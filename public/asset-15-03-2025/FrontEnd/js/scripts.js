// function requiredform(target){
//     let isValid = true;

//     // Check each required input
//     $(target +' .required').each(function() {
//         console.log('value: ' + $(this).val());
//         if ($(this).val() === '') {
//             isValid = false;
//             $(this).addClass('is-invalid');
//             if (!$(this).next('span.invalid-feedback').length) {
//                 $(this).after('<span class="invalid-feedback" role="alert"><strong>This field is required.</strong></span>');
//             }
//         } else {
//             $(this).removeClass('is-invalid');
//             $(this).next('span.invalid-feedback').remove();
//         }

//         if($(target + ' input[name="password_confirmation"]').is(':visible') && $(target + ' input[name="password_confirmation"]').val() != ''){
//             let passwordField = $(target + ' input[name="password"]');
//             let confirmPasswordField = $(target + ' input[name="password_confirmation"]');

//             if (passwordField.length && confirmPasswordField.length) {
//                 let password = passwordField.val();
//                 let confirmPassword = confirmPasswordField.val();
        
//                 if (password !== confirmPassword) {
//                     isValid = false;
//                     confirmPasswordField.addClass('is-invalid');
//                     if (!confirmPasswordField.next('span.invalid-feedback').length) {
//                         confirmPasswordField.after('<span class="invalid-feedback" role="alert"><strong>Passwords do not match.</strong></span>');
//                     }
//                 } else {
//                     confirmPasswordField.removeClass('is-invalid');
//                     confirmPasswordField.next('span.invalid-feedback').remove();
//                 }
//             }
//         }
//     });
//     return isValid;
// }

$(document).ready(function(){
    setTimeout(function () {
        $(".alert-success").alert('close');
    }, 10000);
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();

        if (scroll >= 90) {
            $(".navbar-expand-lg").addClass("darkHeader");
            $("body").addClass("fixed-postion");
        } else {
            $(".navbar-expand-lg").removeClass("darkHeader");
            $("body").removeClass("fixed-postion");
        }
    });
    
    $('.left-navbar .nav-item.active').find('img').attr('src',$(".left-navbar .nav-item.active img").attr("data-image")+ "_white.png");
    $('.left-navbar .nav-item').hover(function(){
        // On hover
        $(this).find('img').attr('src', $(this).find('img').attr("data-image")+ "_white.png"); // Replace 'new_image_url' with the URL of your new image
    }, function(){
        // On mouseout
        if(!$(this).hasClass("active"))
            $(this).find('img').attr('src', $(this).find('img').attr("data-image")+ "_grey.png"); // Replace 'original_image_url' with the URL of your original image
    });

    // $('.register-continue').on('click', function() {
    //     // If all fields are valid, you can proceed with form submission or further processing
    //     if (requiredform('#guestregisterform')) {
    //         $("#registerterms").modal('show');
    //     }
    // });
    // $('.user-register').on('click', function(){
    //     if (requiredform('#registerterms')) {
    //         $("#guestregisterform").submit();
    //     }
    // });
    
    if($(".rating-star").length > 0){
        
        $('.rating-star').starRating({
            readOnly: true,
            initialRating: function(index, el) {
                // Set the initial rating based on your data
                return parseFloat($(el).attr('data-rating'));
            },
            starSize: 15
        });
    }




});