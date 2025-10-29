export function togglePassword(passwordInput, toggleBtn) {
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.getElementById(toggleBtn);
        const pwdInput = document.getElementById(passwordInput);
        if (!toggleButton || !pwdInput) return;

        toggleButton.addEventListener('click', function () {
            const isPwd = pwdInput.getAttribute('type') === 'password';
            pwdInput.setAttribute('type', isPwd ? 'text' : 'password');
        });
    });
}
