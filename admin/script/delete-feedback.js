function deleteFeedback(feedbackId) {
    if(confirm('Are you sure you want to delete this feedback?')) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./delete.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if(xhr.readyState === 4 && xhr.status === 200) {
                if(xhr.responseText === 'success') {
                    var row = document.getElementById('feedback-row-' + feedbackId);
                    row.parentNode.removeChild(row);
                }
                else {
                    alert('Access denied! Contact the administrator.' + xhr.responseText);
                }
            }
        };

        xhr.send("fb_id=" + feedbackId);
    }
}