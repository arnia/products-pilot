<a href='<?php
        if(isset($user_key)) echo Router::buildPath(array($controller,'logout',$user_key));
        else echo Router::buildPath(array($controller,'logout'));?>'
   type='button' class='btn btn-default btn-md'>Log Out</a>

<a href='<?php
        if(isset($user_key)) echo Router::buildPath(array($controller,'changepass',$user_key));
        else echo Router::buildPath(array($controller,'changepass'));?>'
   type='button' class='btn btn-default btn-md'>Change Password</a>