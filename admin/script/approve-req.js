// by Anupa

function approveRequest(req_id) {
    if (confirm("Are you sure you want to approve this request?")) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../blood-requests/approve-request.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const row = document.getElementById('request-row-' + req_id);
                    row.querySelector('td:nth-child(8)').innerHTML = "Approved";
                    row.querySelector('td:nth-child(11)').innerHTML = "";
                } else {
                    alert('Error approving request: ' + xhr.responseText);
                }
            }
        };
        xhr.send("req_id=" + req_id);
    }
    setTimeout(function() {
        window.location.reload();
    }, 100);
}