<?php if(isset($error)) { ?>
    <div class='alert alert-danger' style='margin-top:10px'>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong></strong> <?php echo $error ?>
    </div>
<?php } ?>

<?php if(isset($success)) { ?>
    <div class='alert alert-success' style='margin-top:10px'>
        <strong>Info:</strong> <?php echo $success ?>
    </div>
<?php } ?>

    <table class='table table-bordered'>
        <caption>MailSettings</caption>
        <thead>
        <tr>
            <th>ID</th>
            <th>Settings</th>
            <th>Default</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($settings as $i => $setting) { ?>
            <tr>
                <td> <?php echo $setting->id ?> </td>
                <td> <?php $conf = json_decode($setting->smtp_config) ?>
                    <form class="form-inline" role="form" action="<?php echo Router::buildPath(array($controller,'add')) ?>" method="post">
                        <div class="form-group">
                            <label for="text">SMTP Host</label>
                            <input type="text" class="form-control" id="host" name="host" value="<?php echo $conf->host ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="text">Port</label>
                            <input class="form-control" type="number" min="0" max="10000" step="1" placeholder="Type port…" name="port" value="<?php echo $conf->port ?>"required>
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
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $conf->email ?>"required>
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control" id="pwd1" name="password1" required>
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password Again:</label>
                            <input type="password" class="form-control" id="pwd2" name="password2" required>
                        </div>
                        <button type="submit" class="btn btn-info">Update</button>
                    </form>


                </td>
                <td>
                    delete
                </td>

            </tr>
        <?php } ?>
        <tr>
            <td>
                New
            </td>
            <td>
            <form class="form-inline" role="form" action="<?php echo Router::buildPath(array($controller,'add')) ?>" method="post">
                <div class="form-group">
                    <label for="text">SMTP Host</label>
                    <input type="text" class="form-control" id="host" name="host" value="smtp.gmail.com" required>
                </div>
                <div class="form-group">
                    <label for="text">Port</label>
                    <input class="form-control" type="number" min="0" max="10000" step="1" placeholder="Type port…" name="port" value="587"required>
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
                <button type="submit" class="btn btn-info">Add New</button>
            </form>
            </td>
            <td>
                New
            </td>
        </tr>
        </tbody>
    </table>

<a href='<?php echo Router::buildPath(array('users','control_panel'));?>' type='button' class='btn btn-default btn-md'>Control Panel</a>