<?php
/**
 * Customer new request a quote email
 *
 * @package  wp-configurator-pro/templates/
 * @since  2.5
 * @version  3.4.4
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?></title>
		<style type="text/css">
			<?php
			WPC_Utils::get_template(
				'email/email-styles.php',
				array(
					'config_id' => $config_id,
				)
			);
			?>
		</style>
	</head>
	<body id="wpc-mail-body" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<div id="wpc-mail-wrapper">
			<table id="<?php echo esc_attr( 'wpc-mail-content-' . $config_id ); ?>" border="0" cellpadding="0" cellspacing="0" width="600" id="wpc-mail-template-body">
				<tr>
					<td id="wpc-mail-header-wrapper">
						<h1 id="wpc-mail-header-title"><?php echo esc_html( $email_heading ); ?></h1>
					</td>
				</tr>
				<tr>
					<td id="wpc-mail-body-content" valign="top">
						<div id="wpc-mail-body-content-inner">
