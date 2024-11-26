<?php
/*
Plugin Name: Direct Password Setup
Description: Allows users to set their password during registration without requiring email verification.
Version: 1.0
Author: Your Name
*/

add_action('register_form','add_password_fields_to_registeration');
add_filter('register_errors','validate_password_on_registeration', 10, 3);
add_action('user_register','save_password_on_registeration');
add_filter('wp_new_user_notification_email','__return_false');

function add_password_fields_to_registeration() {
    ?>
    <p>
        <label for="password"><?php _e('Password');?><br>
        <input type="password" name="password" id="password" class="input" value="" size="25" /></label>
    </p>
    <p>
        <label for="confirm_password"><?php _e('Confirm Password'); ?><br />
        <input type="password" name="confirm_password" id="confirm_password" class="input" value="" size="25" /></label>
    </p>
    <?php
}

function validate_password_on_registeration($errors, $sanitized_user_login, $user_email) {
    if (empty($_POST['password']) || empty($_POST['confirm_password'])) {
        $errors->add('password_error', __('Password and Confirm Password are required.'));
    } elseif ($_POST['password'] !== $_POST['confirm_password']) {
        $errors->add('password_error', __('The passwords do not match.'));
    }
    return $errors;
}

function save_password_on_registeration($user_id) {
    if(!empty($_POST['password'])){
        wp_set_password($_POST['password'], $user_id);
    }
}