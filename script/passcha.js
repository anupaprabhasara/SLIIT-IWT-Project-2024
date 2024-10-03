document.querySelector('#passwordChangeForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let currentPass = document.getElementById('cpass').value;
    let newPass = document.getElementById('npass').value;
    let confirmNewPass = document.getElementById('cnpass').value;

    document.getElementById('error-message').textContent = "";
    document.getElementById('success-message').textContent = "";

    const passwordStrength = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    if (!passwordStrength.test(newPass)) {
        document.getElementById('error-message').textContent = 
            "Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        return;
    }

    if (newPass !== confirmNewPass) {
        document.getElementById('error-message').textContent = 
            "New Password and Confirm New Password do not match!";
        return;
    }

    let formData = new FormData();
    formData.append('cpass', currentPass);
    formData.append('npass', newPass);
    formData.append('update', true);

    fetch('password_update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.includes("Error")) {
            document.getElementById('error-message').textContent = data;
            document.getElementById('success-message').textContent = "";
        } else {
            document.getElementById('success-message').textContent = data;
            document.getElementById('error-message').textContent = "";
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('error-message').textContent = "An error occurred while updating the password.";
    });
});