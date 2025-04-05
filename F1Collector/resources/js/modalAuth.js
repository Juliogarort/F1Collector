document.addEventListener('DOMContentLoaded', function () {
    const loginModalElement = document.getElementById('loginModal');
    const registerModalElement = document.getElementById('registerModal');

    if (loginModalElement && registerModalElement) {
        const loginModal = new bootstrap.Modal(loginModalElement);
        const registerModal = new bootstrap.Modal(registerModalElement);

        const openLoginBtn = document.getElementById('openLoginModal');
        const openRegisterBtn = document.getElementById('openRegisterModal');

        if (openLoginBtn) {
            openLoginBtn.addEventListener('click', () => loginModal.show());
        }

        if (openRegisterBtn) {
            openRegisterBtn.addEventListener('click', () => registerModal.show());
        }
    }
});
