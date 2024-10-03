// by Anupa

function approveRequest(fb_id) {
    if (confirm("Are you sure you want to approve this feedback?")) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../feedbacks/approve-feedback.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const row = document.getElementById('feedback-row-' + fb_id);
                    row.querySelector('td:nth-child(8)').innerHTML = "Approved";
                    row.querySelector('td:nth-child(11)').innerHTML = "";
                } else {
                    alert('Error approving feedback: ' + xhr.responseText);
                }
            }
        };
        xhr.send("fb_id=" + fb_id);
    }
    setTimeout(function() {
        window.location.reload();
    }, 100);
}