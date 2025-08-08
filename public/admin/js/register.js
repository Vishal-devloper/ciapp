
    document.querySelector('form').addEventListener('submit',function(event){
        let signup_password=document.querySelector('.signup_password').value;
    let signup_confirm=document.querySelector('.signup_confirm').value;
    if(signup_password !== signup_confirm){
        event.preventDefault();
        alert('password does not match!');
    }
    });
    
