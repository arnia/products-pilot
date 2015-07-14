<form role="form" action="rpass.php" method="post">
    <div class="form-group">
        <label for="email">Email address:</label>
        <input type="email" class="form-control" id="email" name="email" value="
                     <?php
        session_start();
        if (isset($_COOKIE['user_auth']) && !empty($_COOKIE['user_auth'])) echo $_COOKIE['user_auth'];
        elseif (isset($_SESSION['user_auth']) && !empty($_SESSION['user_auth'])){
            echo $_SESSION['user_auth'];
        }
        else echo "";
        ?>"
               required>
    </div>

    <button type="submit" class="btn btn-default" style="margin-top:15px;">Send mail</button>

</form>