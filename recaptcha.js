function recaptcha_callback() {
    const submit = document.querySelector('#submit');

    submit.removeAttribute('disabled');
}