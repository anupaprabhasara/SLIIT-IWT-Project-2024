function deleteDonation(donationId) {
    if(confirm('Are you sure you want to delete this donation?')) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./delete.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if(xhr.readyState === 4 && xhr.status === 200) {
                if(xhr.responseText === 'success') {
                    var row = document.getElementById('donation-row-' + donationId);
                    row.parentNode.removeChild(row);
                }
                else {
                    alert('Access denied! Contact the administrator.' + xhr.responseText);
                }
            }
        };

        xhr.send("donation_id=" + donationId);
    }
}