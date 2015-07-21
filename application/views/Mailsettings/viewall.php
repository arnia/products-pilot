<div id="toright">
    <div class="btn-group" role="group" aria-label="...">
        <a href='<?php echo Router::buildPath(array('users','logout'));?>' type='button' class='btn btn-default btn-md'>LogOut</a>
    </div>
</div>
<a href='<?php echo Router::buildPath(array('users','control_panel'));?>' type='button' class='btn btn-default btn-md'>Control Panel</a>
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
            <th>Delete</th>
            <th>Default</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($settings as $i => $setting) { ?>
            <tr>
                <td> <?php echo $setting->id ?> </td>
                <td> <?php $conf = json_decode($setting->smtp_config) ?>
                    <form class="form-horizontal" role="form" action="<?php echo Router::buildPath(array($controller,'update')) ?>" method="post">
                        <input type="hidden" name = "id" value="<?php echo $setting->id ?>" >
                        <div class="form-group">
                            <label class="form-label col-sm-2" for="text">SMTP Host</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="host" name="host" value="<?php echo $conf->host ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label col-sm-2" for="text">Port</label>
                            <div class="col-sm-5">
                                <input class="form-control" type="number" min="0" max="10000" step="1" placeholder="Type port…" name="port" value="<?php echo $conf->port ?>"required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label col-sm-2" for="text">Security Type</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="stype">
                                        <option <?php if($conf->stype=='TLS') echo "selected"?>>TLS</option>
                                        <option <?php if($conf->stype=='SSL') echo "selected"?>>SSL</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label col-sm-2" for="email">Email address:</label>
                            <div class="col-sm-5">
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $conf->email ?>"required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label col-sm-2" for="pwd">Password:</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" id="pwd1" name="password1" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label col-sm-2" for="pwd">Password Again:</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" id="pwd2" name="password2" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5">
                                <button type="submit" class="btn btn-info">Update</button>
                            </div>
                        </div>
                    </form>


                </td>
                <td>
                    <form  id='<?php echo "delForm$i" ?>' action='<?php echo Router::buildPath(array('mailsettings','delete')) ?>' onsubmit="validateForm('<?php echo "delForm$i" ?>')" method='post' >
                        <input type = 'hidden' name = 'id' value = <?php echo $setting->id ?> >
                        <input type='submit' class='btn btn-danger'  value='Delete'>
                    </form>
                </td>
                <td>
                    <?php if(!$setting->def) { ?>
                    <form  id='<?php echo "adForm$i" ?>' action='<?php echo Router::buildPath(array('mailsettings','setDefault')) ?>' onsubmit="validateForm('<?php echo "adForm$i" ?>')" method='post' >
                        <input type = 'hidden' name = 'id' value = <?php echo $setting->id ?> >
                        <input type='submit' class='btn btn-primary'  value='Make Default'>
                    </form>
                    <?php } else  { ?>
                        <button type="button" class="btn btn-primary disabled">Make Default</button>
                    <?php } ?>
                </td>

            </tr>
        <?php } ?>
        <tr>
            <td>
                New
            </td>
            <td>
                <form class="form-horizontal" role="form" action="<?php echo Router::buildPath(array($controller,'add')) ?>" method="post">
                    <input type="hidden" name = "id" >
                    <div class="form-group">
                        <label class="form-label col-sm-2" for="text">SMTP Host</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="host" name="host" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label col-sm-2" for="text">Port</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="number" min="0" max="10000" step="1" placeholder="Type port…" name="port" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label col-sm-2" for="text">Security Type</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="stype">
                                <option >TLS</option>
                                <option >SSL</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label col-sm-2" for="email">Email address:</label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label col-sm-2" for="pwd">Password:</label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="pwd1" name="password1" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label col-sm-2" for="pwd">Password Again:</label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="pwd2" name="password2" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-success">Add New</button>
                        </div>
                    </div>
                </form>
            </td>
            <td>
                New
            </td>
        </tr>
        </tbody>
    </table>
