<?php
    include '../../database/conn.php';
    include '../partials/forother/admin-session-my.php';
?>

<?php
    $profile_picture_base64 = base64_encode($user['profile_picture']);
?>

<?php include '../partials/forother/title-fav.php';?>
    <?php include '../partials/forother/nav-links.php';?>
    Access denied!
    <?php include '../partials/forother/pic-logout.php';?>
        <div class="content-area">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Can't create or update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> You don't have permission to create or update! <a href="mailto:it23556584@my.sliit.lk">Please contact the administrator.</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    setTimeout(function() {
        alert('Access denied! Contact the administrator.');
        history.back();
    }, 100);
</script>