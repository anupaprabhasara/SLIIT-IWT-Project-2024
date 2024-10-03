function deleteAppo(appoId) {
    if(confirm('Are you sure you want to delete this appointment?')) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./delete.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if(xhr.readyState === 4 && xhr.status === 200) {
                if(xhr.responseText === 'success') {
                    var row = document.getElementById('appo-row-' + appoId);
                    row.parentNode.removeChild(row);
                }
                else {
                    alert('Access denied! Contact the administrator.' + xhr.responseText);
                }
            }
        };

        xhr.send("appo_id=" + appoId);
    }
}