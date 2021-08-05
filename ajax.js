const contactForm = document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener("submit", function(e) {
        e.preventDefault();

        const formData = document.getElementById('contact-form');
        let data = new FormData(formData); 

        const xhr = new XMLHttpRequest();
        xhr.open('POST', "contactform.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('contact-form').reset();
                document.querySelector('.response').innerHTML = '<p class="alert alert-success">Bedankt voor uw bericht. Ik neem zo snel mogelijk contact met u op!</p>';
            } else {
                document.querySelector('.response').innerHTML = '<p class="alert alert-danger">Er is iets misgegaan.</p>';
            }
        };
        xhr.send(data);
    })
})