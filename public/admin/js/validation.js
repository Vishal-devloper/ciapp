$('#registerForm').on('submit',function(e){
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
        url:ajaxRequestUrl,
        data:$(this).serialize() ,
        method:"post",
        dataType:"JSON",
        success:function(response){
            if(response.status==='success'){
                alert("User Registration Successful");
            }
            else{
                alert('Error'+response.message);
            }
        },
        error:function(xhr,error){
            console.debug(xhr);
            console.debug(error);
            console.log("Error in admin register");
        }
    });
});