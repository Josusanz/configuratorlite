<?php
/**
 * Customer new request a quote email
 *
 * @package  wp-configurator-pro/templates/
 * @since  2.5
 * @version  3.4.10
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;
?>
#wpc-mail-wrapper {
	padding: 30px 0;
	font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
	color: #0d0d1a;
	background: #f7f7fb;
}

#wpc-mail-wrapper h1,
#wpc-mail-wrapper h2,
#wpc-mail-wrapper h3 {
	font-size: 21px;
	font-weight: 400;
	color: #0d0d1a;
	margin: 0 0 10px 0;
	padding: 0;
}

#wpc-mail-wrapper > table {
	margin: 0px auto;
}

#wpc-mail-wrapper #wpc-mail-header-wrapper {
	padding: 25px 30px;
	background-color: #000042;
	border-bottom: 0;
	vertical-align: middle;
	border-radius: 3px 3px 0 0;
}

#wpc-mail-header-wrapper * {
	font-size: 30px;
	font-weight: 300;
	line-height: 150%;
	margin: 0;
	text-align: left;
	color: #ffffff;
	background-color: inherit;
}

#wpc-mail-header-wrapper #wpc-mail-header-title {
	margin: 0;
	color: #fff;
}

#wpc-mail-body-content #wpc-mail-info {
	font-size: 18px;
}

#wpc-mail-body-content p {
	font-size: 14px;
}

#wpc-mail-wrapper #wpc-mail-body-content {
	padding: 48px 30px 32px;
	background-color: #fff;
}

#wpc-mail-wrapper #wpc-mail-body-content p {
	margin-top: 0;
}

#wpc-mail-wrapper table,
#wpc-mail-wrapper th, 
#wpc-mail-wrapper td {
	border: 1px solid #dfdfe9;
	vertical-align: middle;
	padding: 10px;
	text-align: left;
	border-collapse: collapse;
}

#wpc-mail-wrapper th {
	width: 30%;
}

#wpc-mail-configured-options .wpc-summary-total-wrap {
	text-align: right;
	border-bottom: 1px solid #dfdfe9;
	padding-bottom: 14px;
	margin: 0 0 30px 0;
}

#wpc-mail-configured-options .wpc-summary-total-wrap .wpc-summary-list-title {
	margin: 0 15px 0 0;
}

#wpc-mail-configured-options ul li,
#wpc-mail-configured-options .wpc-summary-total-wrap .wpc-summary-total {
	clear: both;
	border-bottom: 1px solid #dfdfe9;
	margin: 0;
	padding: 4px 0;
	line-height: 1.8;
	list-style: none;
}

#wpc-mail-configured-options ul ul li {
	border-bottom: none;
	padding-bottom: 0;
}

#wpc-mail-configured-options .wpc-hide-item-price li > ul > li .wpc-summary-list-child-wrap span:last-child .wpc-sign {
    display: none;
}

#wpc-mail-configured-options ul li .wpc-summary-list-base-price, #wpc-mail-configured-options ul li .wpc-summary-list-group-price {
	float: right;
}

#wpc-mail-configured-options .wpc-summary-list-title,
#wpc-mail-configured-options .wpc-summary-list-total-price {
	font-size: 18px;
}

#wpc-mail-configured-options .wpc-summary-list-total-price {
	float: right;
}

#wpc-mail-configured-options .wpc-summary-total-wrap .wpc-summary-total {
	padding-top: 0;
	margin: 0;
	margin-bottom: 0;
}

#wpc-mail-configured-options {
	margin: 30px 0 0 0;
}

#wpc-mail-configured-options > ul {
	margin: 0 0 10px 0;
	padding-left: 0;
	padding-bottom: 9px;
}

#wpc-mail-configured-options ul ul { 
	padding-left: 10px;
}

#wpc-mail-configured-options ul li:last-child {
	padding-bottom: 0;
}

#wpc-mail-configured-options li > ul {
	flex-basis: 100%;
	margin-left: 0;
}

#wpc-mail-configured-options ul li .wpc-summary-list-title {
	color: #000;
	font-size: 14px;
}

#wpc-mail-configured-options .wpc-summary-list-child-wrap {
	font-size: 12px;
	padding-right: 10px;
}

#wpc-mail-wrapper .wpc-summary-total-wrap .wpc-sign,
#wpc-mail-configured-options > ul > li > .wpc-sign {
	display: none;
}

#wpc-mail-configured-options .wpc-summary-total-wrap .wpc-summary-total .wpc-sign + span {
	float: right;
}

#wpc-mail-configured-options li ul li {
	font-size: 14px;
	padding: 0 15px 0;
}

#wpc-mail-wrapper #wpc-mail-other-info {
	margin: 30px 0 0 0;
}

#wpc-mail-wrapper #wpc-mail-other-info table, 
#wpc-mail-wrapper #wpc-mail-other-info td {
	border: 0;
	padding: 0;
}

#wpc-mail-footer-text td {
	padding: 10px 30px;
}

#wpc-mail-wrapper #wpc-mail-other-info span {
	display: block;
}

#wpc-mail-footer-text p {
	margin: 0;
}

<?php

/**
 * Hook: Additional CSS for email.
 *
 * * @since 3.4.4
 *
 * @param integer $config_id Configurator ID.
 */
do_action( 'wpc_email_style', $config_id );
