// by Anupa

document.getElementById('fbForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '');

    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('responseMessage').innerHTML = "<p style='color: green;'>Successfully submitted!</p>";
            document.getElementById('requestForm').reset();
        } else {
            document.getElementById('responseMessage').innerHTML = "<p style='color: red;'>Submit failed!</p>";
        }
    };

    xhr.send(formData);

    const delay = 2000;

    const url = '../events/';

    setTimeout(() => {
        window.location.href = url;
    }, delay);
});