$('#registerForm').on('submit', function (e) {
    e.preventDefault();
    let password = $('.signupPassword').val().trim();
    let confirmPassword = $('.signupConfirm').val().trim();

    let passwordPattern = /^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>]).{7,}$/;
    // 1. Check if empty
    if (password === '' || confirmPassword === '') {
        alert('Please fill in both password fields.');
        return;
    }
    if (!passwordPattern.test(password)) {
        alert('Password must be at least 7 characters, include 1 uppercase letter and 1 special character.');
        return;
    }

    // 3. Check match
    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return;
    }
    $.ajax({
        url: ajaxRequestUrl,
        data: $(this).serialize(),
        method: "post",
        dataType: "JSON",
        success: function (response) {
            if (response.status === 'success') {
                // console.log(response);
                window.location.href = response.redirect;
            }
            else {
                alert('Error : ' + response.message);
            }
        },
        error: function (xhr, error) {
            console.debug(xhr);
            console.debug(error);
            console.log("Error in vendor register ajax");
        }
    });
});

$('#loginForm').on("submit", function (e) {
    e.preventDefault();
    let password = $('.loginPassword').val().trim();

    let passwordPattern = /^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>]).{7,}$/;

    if (!passwordPattern.test(password)) {
        alert('Password must be at least 7 characters, include 1 uppercase letter and 1 special character.');
        return;
    }

    $.ajax({
        url: ajaxRequestUrlLogin,
        data: $(this).serialize(),
        method: "post",
        dataType: "json",
        success: function (response) {
            if (response.status === 'success') {
                window.location.href = response.redirect;
            }
            else {
                alert("Error : " + response.message);
            }
        },
        error: function (xhr, error) {
            console.debug(xhr);
            console.debug(error);
            console.log("Error in vendor login ajax");
        }
    });
});


// Code verification

$('#RegisterVerifyForm').on("submit", function (e) {
    e.preventDefault();
    const urlParams=new URLSearchParams(window.location.search);
    const email=urlParams.get('email');
    let code = $('#code').val().trim();

    // only numbers, exactly 6 digits
    let codePattern = /^\d{6}$/;

    if (!codePattern.test(code)) {
        alert('Code must be exactly 6 digits (numbers only).');
        return;
    }


    $.ajax({
        url: ajaxRequestUrlRegisterVerify,
        data: {
            'code':code,
            'email':email
        },
        method: "post",
        dataType: "json",
        success: function (response) {
            if (response.status === 'success') {
                // console.log(response);
                alert(response.message);
                window.location.href = response.redirect;
            }
            else {
                alert("Error : " + response.message);
            }
        },
        error: function (xhr, error) {
            console.debug(xhr);
            console.debug(error);
            console.log("Error in vendor verify ajax");
        }
    });
});