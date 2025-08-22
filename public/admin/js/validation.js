$('#registerForm').on('submit', function (e) {
    e.preventDefault();
    let $this = $('#RegisterForm button[type="submit"]');
        $this.text("Registering...");
        $this.css("pointer-events", "none"); // disable clicks
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
                $this.text("Register");
                $this.css("pointer-events", "auto");
            }
        },
        error: function (xhr, error) {
            console.debug(xhr);
            console.debug(error);
            console.log("Error in vendor register ajax");
            $this.text("Register");
                $this.css("pointer-events", "auto");
        }
    });
});

$('#loginForm').on("submit", function (e) {
    e.preventDefault();
    let $this = $('#loginForm button[type="submit"]');
        $this.text("Logging In...");
        $this.css("pointer-events", "none"); // disable clicks
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
                $this.text("Login");
                $this.css("pointer-events", "auto");
            }
        },
        error: function (xhr, error) {
            console.debug(xhr);
            console.debug(error);
            console.log("Error in vendor login ajax");
            $this.text("Login");
                $this.css("pointer-events", "auto");
        }
    });
});


// Code verification

$('#RegisterVerifyForm').on("submit", function (e) {
    e.preventDefault();
    let $this = $('#RegisterVerifyForm button[type="submit"]');
        $this.text("Verifying...");
        $this.css("pointer-events", "none"); // disable clicks
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
                $this.text("Verify");
                $this.css("pointer-events", "auto");
            }
        },
        error: function (xhr, error) {
            console.debug(xhr);
            console.debug(error);
            console.log("Error in vendor verify ajax");
            $this.text("Verify");
                $this.css("pointer-events", "auto");
        }
    });
});
// Resend code
let maxResend = 4;
let resendCount = 0;

$('.resend').on('click',function(){
    if (resendCount >= maxResend) {
        alert("You can only resend the code 4 times.");
        return;
    }

    let $this = $('.resend');
        $this.text('Sending...');
        $this.css("pointer-events", "none");
    const urlParams=new URLSearchParams(window.location.search);
    const email=urlParams.get('email');
    $.ajax({
        url: ajaxRequestUrlRegisterVerifyResend,
        data: {
            'email':email
        },
        method: "post",
        dataType: "json",
        success: function (response) {
            if (response.status === 'success') {
                $this.text('Sent');
                resendCount++;
                alert(response.message + " Remaining: " + (maxResend - resendCount));
                startResendTimer(60);
            }
            else {
                alert("Error : " + response.message);
                $this.text("resend code");
                $this.css("pointer-events", "auto");
            }
        },
        error: function (xhr, error) {
            $this.text("Resend code");
            $this.css("pointer-events", "auto");
            console.debug(xhr);
            console.debug(error);
            console.log("Error in vendor verify resend code ajax");
        }
    });

    // function to start countdown
    function startResendTimer(duration) {
        let timer = duration;
        let $resend = $(".resend");
        let $timer = $("#timer");

        $resend.addClass("disabled").css({
            "pointer-events": "none",
            "color": "grey"
        });

        let interval = setInterval(function () {
            let minutes = Math.floor(timer / 60);
            let seconds = timer % 60;
            $timer.text("Wait " + minutes + ":" + (seconds < 10 ? "0" : "") + seconds);

            if (--timer < 0) {
                clearInterval(interval);
                $timer.text("");
                $resend.text('resend code')
                $resend.removeClass("disabled").css({
                    "pointer-events": "auto",
                    "color": "blue",
                });
            }
        }, 1000);
    }
});

// Profile Update

$('#profile').on("submit", function (e) {
    e.preventDefault();
    let $this = $('#profile button[type="submit"]');
        $this.text("Updating Profile...");
        $this.css("pointer-events", "none"); // disable clicks
    let password = $('.password').val().trim();
    let newPassword = $('.newPassword').val().trim();
    if(password=='' && newPassword==''){
       $.ajax({
        url: ajaxUserUpdateUrl,
        data: $(this).serialize(),
        method: "post",
        dataType: "json",
        success: function (response) {
            if (response.status === 'success') {
                alert(response.message);
                location.reload();
                $this.text("Update Profile");
                $this.css("pointer-events", "auto");
                
            }
            else {
                alert("Error : " + response.message);
                $this.text("Update Profile");
                $this.css("pointer-events", "auto");
            }
        },
        error: function (xhr, error) {
            console.debug(xhr);
            console.debug(error);
            console.log("Error in vendor Update Profile ajax");
            $this.text("Update Profile");
                $this.css("pointer-events", "auto");
        }
    }); 
    }
    else{
    let passwordPattern = /^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>]).{7,}$/;

    if (!passwordPattern.test(password) || !passwordPattern.test(newPassword)) {
        alert('Password must be at least 7 characters, include 1 uppercase letter and 1 special character.');
        $this.text("Update Profile");
        $this.css("pointer-events", "auto");
        return;
    }
    if(password===newPassword){
        alert("Password should be different");
        $this.text("Update Profile");
        $this.css("pointer-events", "auto");
        return;
    }
    $.ajax({
        url: ajaxUserUpdateUrl,
        data: $(this).serialize(),
        method: "post",
        dataType: "json",
        success: function (response) {
            if (response.status === 'success') {
                alert(response.message);
                location.reload();
                $this.text("Update Profile");
                $this.css("pointer-events", "auto");
            }
            else {
                alert("Error : " + response.message);
                $this.text("Update Profile");
                $this.css("pointer-events", "auto");
            }
        },
        error: function (xhr, error) {
            console.debug(xhr);
            console.debug(error);
            console.log("Error in vendor Update Profile ajax");
            $this.text("Update Profile");
                $this.css("pointer-events", "auto");
        }
    });
}
});