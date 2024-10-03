// by Anupa

function approveRequest(appo_id) {
    if (confirm("Are you sure you want to approve this appointment?")) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../appointments/approve-appo.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const row = document.getElementById('appo-row-' + appo_id);
                    row.querySelector('td:nth-child(8)').innerHTML = "Approved";
                    row.querySelector('td:nth-child(11)').innerHTML = "";
                } else {
                    alert('Error approving appointment: ' + xhr.responseText);
                }
            }
        };
        xhr.send("appo_id=" + appo_id);
    }
    setTimeout(function() {
        window.location.reload();
    }, 100);
}