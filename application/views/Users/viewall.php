<?php if ($users) {    ?>

    <table class='table table-bordered'>
        <caption>Users</caption>
        <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Verified</th>
            <th>Admin</th>
        </tr>
        </thead>
        <tbody>
<?php foreach($users as $i => $user) { ?>
    <tr>
        <td> <?php echo $user->id ?> </td>
        <td> <?php echo $user->email ?> </td>
        <td> <?php echo $user->verified ?></td>
        <td> <?php echo $user->admin_id ?> </td>
    </tr>
<?php } ?>
        </tbody>
    </table>

<?php } else  echo "No rows found!" ?>