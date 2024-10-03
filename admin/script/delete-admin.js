function deleteAdmin(adminId) {
    if(confirm('If you delete this admin, records in other sections related to this admin will also be deleted!\n\nAre you sure you want to delete this admin?')) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./delete.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if(xhr.readyState === 4 && xhr.status === 200) {
                if(xhr.responseText === 'success') {
                    var row = document.getElementById('admin-row-' + adminId);
                    row.parentNode.removeChild(row);
                }
                else {
                    alert('You cannot delete yourself!' + xhr.responseText);
                }
            }
        };

        xhr.send("admin_id=" + adminId);
    }
}