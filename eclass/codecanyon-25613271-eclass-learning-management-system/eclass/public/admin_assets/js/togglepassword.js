try{
    const togglePassword = document.querySelector('#togglePassword');
    const password1 = document.querySelector('#password1');
    togglePassword.addEventListener('click', function (e) {
        const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
        password1.setAttribute('type', type);
        this.classList.toggle('bi-eye');
    });
}catch(err){
}