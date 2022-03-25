<?php

class classLquizAdminRenderTemplate {

	public static function locate_template( $template_name, $template_path = '', $default_path = '' ) {
		if ( ! $template_path ) {
			$template_path = 'plugin-name-templates/';
		}
		if ( ! $default_path ) {
			$default_path = plugin_dir_path(__FILE__)  . 'partials/';
		}
		// Look within passed path within the theme - this is priority.
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name,
			)
		);

		// Get default template.
		if ( ! $template ) {
			$template = $default_path . $template_name;
		}

		if ( file_exists( $template ) ) {
			// Return what we found.
			return apply_filters( 'plugin_name_locate_template', $template, $template_name, $template_path );
		} else {
			return false;
		}
	}
	public static function render_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		if ( $args && is_array( $args ) ) {
			extract( $args ); // @codingStandardsIgnoreLine.
		}

		$located = static::locate_template( $template_name, $template_path, $default_path );
		if ( false == $located ) {
			return;
		}
		ob_start();
		do_action( 'plugin_name_before_template_render', $template_name, $template_path, $located, $args );
		include( $located );
		do_action( 'plugin_name_after_template_render', $template_name, $template_path, $located, $args );
		return ob_get_clean(); // @codingStandardsIgnoreLine.
	}
}