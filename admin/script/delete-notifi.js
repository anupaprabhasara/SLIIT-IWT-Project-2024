function deleteNotification(notifiId) {
    if (confirm('Are you sure you want to delete this notification?')) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./delete.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText === 'success') {
                    var row = document.getElementById('notifi-row-' + notifiId);
                    row.parentNode.removeChild(row);
                } else {
                    alert('Access denied! Contact the administrator.' + xhr.responseText);
                }
            }
        };

        xhr.send("notifi_id=" + notifiId);
    }
}