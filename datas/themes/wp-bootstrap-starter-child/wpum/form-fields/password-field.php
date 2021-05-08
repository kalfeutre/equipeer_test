<?php
/**
 * The template for displaying the password field.
 *
 * This template can be overridden by copying it to yourtheme/wpum/form-fields/password-field.php
 *
 * HOWEVER, on occasion WPUM will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @version 1.0.0
 */

 // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

global $wp_query;
$current_page_id = $wp_query->post->ID;

$time = uniqid();

?>

<input type="password" class="eq-password-mob input-text"<?php if ( isset( $data->autocomplete ) && false === $data->autocomplete ) { echo ' autocomplete="off"'; } ?> name="<?php echo esc_attr( isset( $data->name ) ? $data->name : $data->key ); ?>" id="<?php echo esc_attr( $data->key ); ?>" placeholder="<?php echo empty( $data->placeholder ) ? '' : esc_attr( $data->placeholder ); ?>" value="<?php echo isset( $data->value ) ? esc_attr( $data->value ) : ''; ?>" maxlength="<?php echo ! empty( $data->maxlength ) ? $data->maxlength : ''; ?>" <?php if ( ! empty( $data->required ) ) echo 'required'; ?> style="" />
<button type="button" id="eye-<?php echo esc_attr( $data->key ).'-'.$time; ?>" style="border: 1px solid grey; border-radius: 3px; float: right; line-height: 2.12em;">
    <img src="https://cdn0.iconfinder.com/data/icons/feather/96/eye-16.png" alt="eye" style="border: 0;" />
</button>
<?php if ( ! empty( $data->description ) ) : ?><br><small class="description"><?php echo $data->description; ?></small><?php endif; ?>
<?php if ($current_page_id == 8) { // If Register page ?>
<p id="password-description" style="display: inline-block;">
    <small class="description" style="font-style: italic;"><?php echo __('Password must be at least 8 characters long and contain at least 1 number and 1 uppercase letter and 1 special character.', 'wp-user-manager') ; ?></small>
</p>
<?php } ?>
<script>
	var pwShown = 0;
	document.getElementById("eye-<?php echo esc_attr( $data->key ).'-'.$time; ?>").addEventListener("click", function () {
        var p = document.getElementById('<?php echo esc_attr( $data->key ); ?>');
        console.log('pwShown: '+pwShown);
		if (pwShown == 0) {
			pwShown = 1;
            p.setAttribute('type', 'text');
		} else {
			pwShown = 0;
            p.setAttribute('type', 'password');
		}
    });
</script>
