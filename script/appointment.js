document.getElementById('requestForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '');

    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('responseMessage').innerHTML = "<p style='color: green;'>Successfully Booked An Appointment!</p>";
            document.getElementById('requestForm').reset();
        } else {
            document.getElementById('responseMessage').innerHTML = "<p style='color: red;'>Request failed!</p>";
        }
    };

    xhr.send(formData);
});