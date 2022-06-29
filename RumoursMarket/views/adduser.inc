<?php $render('partial/header', $data); ?>

<h1>Add User</h1>

<?php $beginForm('User', 'AddUser', method: 'post'); ?>
<div class="mb-3">
    <label for="login" class="form-label">Login</label>
    <input class="form-control" id="login" name="ln" value="<?php $htmlOut($data['login']); ?>">
</div>
<div class="mb-3">
    <label for="userName" class="form-label">Nickname</label>
    <input class="form-control" id="userName" name="un" value="<?php $htmlOut($data['userName']); ?>">
</div>
<div class="mb-3">
    <label for="password" class="form-label">Enter password</label>
    <input type="password" class="form-control" id="password" name="pwd">
</div>
<div class="mb-3">
    <label for="password" class="form-label">Confirm password</label>
    <input type="password" class="form-control" id="confirmPassword" name="cfpwd">
</div>
<button class="btn btn-primary">Add User</button>
<?php $endForm(); ?>

<?php $render('partial/footer', $data); ?>