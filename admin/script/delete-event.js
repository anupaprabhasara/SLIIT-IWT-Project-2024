function deleteEvent(eventId) {
    if(confirm('If you delete this event, records in other sections related to this event will also be deleted!\n\nAre you sure you want to delete this event?')) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./delete.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if(xhr.readyState === 4 && xhr.status === 200) {
                if(xhr.responseText === 'success') {
                    var row = document.getElementById('event-row-' + eventId);
                    row.parentNode.removeChild(row);
                }
                else {
                    alert('Access denied! Contact the administrator.' + xhr.responseText);
                }
            }
        };

        xhr.send("event_id=" + eventId);
    }
}