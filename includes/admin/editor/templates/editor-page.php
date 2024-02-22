<?php
/**
 * Editor Page Template.
 *
 * @package  wp-configurator-pro/includes/admin/
 * @since  3.0
 * @version  3.1
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;
?>

<style type="text/css">

.update-nag, .updated, .error, .is-dismissible {
	display: none;
}

#wpc-editor {
	opacity: 0;
	visibility: hidden;
	transition: all ease .3s;
}

#wpc-editor[data-v-app] {
	opacity: 1;
	visibility: visible;
}

#wpc-editor[data-v-app] + .wpc-loader-wrap {
	opacity: 0;
	visibility: hidden;
}

#wpc-editor + .wpc-loader-wrap {
	opacity: 1;
	visibility: visible;
	position: fixed;
	top: 0;
	left: 0;
	background: #eaeaea;
	width: 100%;
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
	z-index: 99999;
	transition: all ease .3s;
}

.wpc-loader-inner {
	text-align: center;
}
.wpc-loader {
	width: 200px;
	height: 200px;
	background: #fff;
	padding: 30px;
	border-radius: 50%;
	box-shadow: 0 0 20px #00000008;
	display: flex;
}

.wpc-preloader-logo path {
	stroke: #000042;
	fill: #000042;
	fill-opacity: 0;
	stroke-width: 1;
	stroke-dasharray: 1200;
	stroke-dashoffset:1200;
	-moz-animation:DASH 3s ease-in-out 0s forwards infinite;
	-webkit-animation:DASH 3s ease-in-out 0s forwards infinite;
	animation: DASH 3s ease-in-out 0s forwards infinite;
}

.wpc-loader-text {
	display: inline-block;
	margin-top: 30px;
	font-family: "Nunito Sans";
	font-size: 16px;
	font-weight: 800;
	text-transform: uppercase;
	color: rgb(0 0 66 / 63%);
	letter-spacing: 3px;
}

@-webkit-keyframes DASH {
	0%  {stroke-dashoffset:1200;}
	60%  {stroke-dashoffset:0;fill-opacity:0;}
	100%{stroke-dashoffset:0;fill-opacity:1;}
}

@-moz-keyframes DASH {
	0%  {stroke-dashoffset:1200;}
	80%  {stroke-dashoffset:0;fill-opacity:0;}
	100%{stroke-dashoffset:0;fill-opacity:1;}
}

@keyframes DASH {
	0%  {stroke-dashoffset:1200;}
	60%  {stroke-dashoffset:0;fill-opacity:0;}
	100%{stroke-dashoffset:0;fill-opacity:1;}
}

</style>

<div class="wrap">
	<div id="wpc-editor"></div>	
	<div class="wpc-loader-wrap">
		<div class="wpc-loader-inner">
			<div class="wpc-loader">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 168 183" class="wpc-preloader-logo"><defs><style>.cls-1{fill:none;}</style></defs><path d="M133.92,104.82a23,23,0,0,0-13.14,4.07l-1.2,1-2.1,1.76a32.3,32.3,0,0,1-22.68,9.61h-.93a31.85,31.85,0,0,1-11.25-2.14c-.34-.12-.68-.25-1-.4a32.88,32.88,0,0,1-10.42-7h0v0a32.49,32.49,0,0,1-9.57-22.81v-.76a32,32,0,0,1,2.12-11.18A30.3,30.3,0,0,1,57,78.24h-.47c-.61,0-1.22.06-1.86.06h-.21a40.19,40.19,0,0,0-1.27,9.64c0,.25,0,.45,0,.57s0,.32,0,.57a40.71,40.71,0,0,0,12.09,28.55,14.86,14.86,0,0,1-20.5,21.5c-.36-.34-.7-.7-1.1-1.12A70.43,70.43,0,0,1,23.49,89.44v-.25c0-.21,0-.44,0-.68s0-.46,0-.68v-.25A70.27,70.27,0,0,1,28.12,63.2,71.72,71.72,0,0,1,32,54.75v0a0,0,0,0,0,0,0,.1.1,0,0,0,0,.07c.15.57.32,1.12.48,1.67l.2.51a13.64,13.64,0,0,0,.57,1.37c.25.6.53,1.15.82,1.72a0,0,0,0,0,0,0c.3.55.62,1.1,1,1.63a15.9,15.9,0,0,0,1,1.44.86.86,0,0,0,.19.26c.31.42.67.82,1,1.22s.62.64.94.94.44.44.65.63.6.55.91.79.55.44.83.65a25,25,0,0,0,2.67,1.74c.38.21.78.4,1.16.59s.68.32,1,.47.7.29,1.06.42a20.52,20.52,0,0,0,2.1.66,23.92,23.92,0,0,0,2.35.49c.4.06.78.1,1.16.14l.7.07c.21,0,.45,0,.68,0s.68,0,1,0c.56,0,1.11,0,1.66-.06h.19a23.34,23.34,0,0,0,14.63-6.8.18.18,0,0,0,.09-.07,32.49,32.49,0,0,1,22.68-9.57l.4,0,.49,0a32.43,32.43,0,0,1,21.9,8.83A23.31,23.31,0,0,0,153.15,35.8l-1-1.29-1.71-2a78.83,78.83,0,0,0-55-23.27,21.11,21.11,0,0,0-2.25,0,78.84,78.84,0,0,0-54.34,22.6c-.47.44-1,.91-1.4,1.41l-.11.11s-.08.11-.12.15l-.06.07a.18.18,0,0,1,.05-.07A79,79,0,0,0,15,87.39c0,.36,0,.72,0,1.12s0,.77,0,1.13a79,79,0,0,0,22.53,54.28c.44.46.91.93,1.38,1.37a.4.4,0,0,0,.12.11,23.35,23.35,0,0,0,21.37,5.36,21.21,21.21,0,0,0,2.06-.62c.36-.12.72-.27,1.06-.42a.91.91,0,0,0,.25-.11c.25-.1.53-.21.78-.33A4.92,4.92,0,0,0,65,149a6.89,6.89,0,0,0,1-.51.1.1,0,0,0,.07,0c.48-.25.93-.55,1.39-.84s.81-.55,1.21-.85a22.45,22.45,0,0,0,3.31-3c.33-.36.67-.76,1-1.16a.86.86,0,0,0,.15-.22c.17-.21.34-.42.49-.63a4,4,0,0,0,.44-.64c.21-.29.43-.61.62-.93l.69-1.2V139c.22-.4.43-.82.62-1.25s.4-.93.57-1.39.32-.85.45-1.28.21-.67.29-1,.19-.76.28-1.17.15-.78.21-1.18.1-.79.15-1.17a23.61,23.61,0,0,0,.12-2.39c0-.62,0-1.21-.06-1.8A39.7,39.7,0,0,0,84,128.41a41.12,41.12,0,0,0,9.76,1.27,3.49,3.49,0,0,0,1,0h0a40.61,40.61,0,0,0,25.5-9.25l.4-.34,2.75-2.5a14.83,14.83,0,0,1,21,21l-.19.19a3.66,3.66,0,0,1-.44.44l-.28.26a70.43,70.43,0,0,1-48.31,19.89H95c-.23,0-.45,0-.7,0s-.47,0-.7,0h-.23a70.05,70.05,0,0,1-24.91-4.85l0,0-1,0-.36.19-.89.38-.55.23c-.41.17-.81.32-1.23.47a24.27,24.27,0,0,1-2.65.8,27.82,27.82,0,0,1-6.76.83,78.47,78.47,0,0,0,38.13,10.38c.36,0,.74,0,1.12,0s.76,0,1.12,0a78.94,78.94,0,0,0,54-22.22l.17-.17c.36-.32.67-.63,1-1a23.31,23.31,0,0,0-16.64-39.63ZM43.61,39v0c.36-.41.72-.72,1.15-1.13a70.36,70.36,0,0,1,48.62-20.2h.26c.21,0,.44,0,.67,0s.47,0,.68,0h.26a70.08,70.08,0,0,1,47.2,18.85l2,2a14.84,14.84,0,1,1-21.58,20.35l-.23-.25A40.9,40.9,0,0,0,95,47.34a8.65,8.65,0,0,0-1.44,0,40.81,40.81,0,0,0-28.31,12l-.15.17A14.86,14.86,0,0,1,39.78,49,14.69,14.69,0,0,1,43.61,39Z"/></svg>
			</div>
			<span class="wpc-loader-text"><?php esc_html_e( 'Loading', 'wp-configurator-pro' ); ?></span>
		</div>
	</div>
	<div id="wpc-editor-external-addon">
		<?php
		/**
		 * Hook: After the Editor.
		 *
		 * * @since 3.1
		 */
		do_action( 'wpc_after_editor_area' );
		?>
	</div>
</div>
