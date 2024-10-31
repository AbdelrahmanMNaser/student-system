function submitFormAndRedirect() {
    var form = document.getElementById('search');
    var formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if(response.ok) {
            location.href='../assessment/main.php'; // Redirect on successful form submission
        } else {
            throw new Error('Form submission failed');
        }
    })
    .catch(error => console.error('Error:', error));
}