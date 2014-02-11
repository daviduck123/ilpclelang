<div class="container">
    <div>
        <?php echo form_open("login/panitia", array("class" => "form-signin")); ?>
        <h2 class="form-signin-heading text-center">LOGIN PANITIA</h2>
        <?php echo form_input(array('name' => 'username', 'class' => 'form-control', 'placeholder' => 'Username', 'required' => '', 'autofocus' => '')); ?>
        <?php echo form_password(array('name' => 'password', 'class' => 'form-control', 'placeholder' => 'Password', 'required' => '')); ?>
        <?php echo form_submit(array('name' => 'Submit', 'class' => 'form-control btn btn-lg btn-primary btn-block', 'value' => 'Sign In')); ?>
        <?php echo (isset($error)) ? "<br/><div class='alert alert-danger'><strong>$error</strong></div>" : ''; ?>
        <?php echo form_close(); ?>
    </div>
</div>
<div>
    <div>
        <div>