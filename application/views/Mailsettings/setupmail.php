<?php
if($error) echo "<div class='alert alert-danger' style='margin-top:10px'>
        <strong>Error:</strong> " . $error ."
        </div>";
?>
<form role="form" action="<?php echo Router::buildPath(array($controller,'addsmtp')) ?>" method="post">
    <div class="form-group">
        <label for="text">SMTP Host</label>
        <input type="text" class="form-control" id="host" name="host" value="smtp.gmail.com" required>
    </div>
    <div class="form-group">
        <label for="text">Port</label>
        <input type="number" min="0" max="10000" step="1" placeholder="Type port…" name="port" value="587"required>
    </div>
    <div class="form-group">
        <label for="text">Security Type</label>
        <select name="stype">
            <option>TLS</option>
            <option>SSL</option>
        </select>
    </div>
    <div class="form-group">
        <label for="email">Email address:</label>
        <input type="email" class="form-control" id="email" name="email" value="testarnia@gmail.com"required>
    </div>
    <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" id="pwd1" name="password1" required>
    </div>
    <div class="form-group">
        <label for="pwd">Password Again:</label>
        <input type="password" class="form-control" id="pwd2" name="password2" required>
    </div>
    <button type="submit" class="btn btn-info">SETUP NEW CONFIGURATION</button>
</form>