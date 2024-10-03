// by Anupa

// to validate password and display error or success messages

document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var password = document.querySelector('input[name="password"]').value;
    var cpassword = document.querySelector('input[name="cpassword"]').value;
    var responseMessage = document.getElementById('responseMessage');

    responseMessage.innerHTML = "";

    if (password !== cpassword) {
        responseMessage.innerHTML = "<p style='color: red;'>Passwords do not match!</p>";
        return;
    }

    if (password.length < 8) {
        responseMessage.innerHTML = "<p style='color: red;'>Password must be at least 8 characters long!</p>";
        return;
    }

    if (!/[a-z]/.test(password)) {
        responseMessage.innerHTML = "<p style='color: red;'>Password must contain at least one lowercase letter!</p>";
        return;
    }

    if (!/[A-Z]/.test(password)) {
        responseMessage.innerHTML = "<p style='color: red;'>Password must contain at least one uppercase letter!</p>";
        return;
    }

    if (!/\d/.test(password)) {
        responseMessage.innerHTML = "<p style='color: red;'>Password must contain at least one number!</p>";
        return;
    }

    if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        responseMessage.innerHTML = "<p style='color: red;'>Password must contain at least one special character!</p>";
        return;
    }

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '');

    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    responseMessage.innerHTML = "<p style='color: green;'>" + response.message + "</p>";
                    document.getElementById('registerForm').reset();
                } else {
                    responseMessage.innerHTML = "<p style='color: red;'>" + response.message + "</p>";
                }
            } catch (e) {
                responseMessage.innerHTML = "<p style='color: red;'>Unexpected error occurred. Please try again.</p>";
            }
        } else {
            responseMessage.innerHTML = "<p style='color: red;'>Registration failed! Please check your inputs.</p>";
        }
    };

    xhr.onerror = function() {
        responseMessage.innerHTML = "<p style='color: red;'>Request failed. Please try again later.</p>";
    };

    xhr.send(formData);

    const delay = 2000;
    const url = '../login/';
    
    setTimeout(() => {
        window.location.href = url;
    }, delay);
});