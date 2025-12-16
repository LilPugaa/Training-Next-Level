function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeOpenIcon = document.getElementById('eyeOpen');
    const eyeClosedIcon = document.getElementById('eyeClosed');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeOpenIcon.classList.add('hidden');
        eyeClosedIcon.classList.remove('hidden');
    } else {
        passwordInput.type = 'password';
        eyeOpenIcon.classList.remove('hidden');
        eyeClosedIcon.classList.add('hidden');
    }
}

function toggleTokenField() {
    const roleSelect = document.getElementById('role').value;
    const tokenField = document.getElementById('tokenField');
    const tokenInput = document.getElementById('token');

    if (roleSelect && roleSelect !== 'participant') {
        tokenField.classList.remove('hidden');
        tokenInput.setAttribute('required', true);
    } else {
        tokenField.classList.add('hidden');
        tokenInput.removeAttribute('required');
        tokenInput.value = '';
    }
}