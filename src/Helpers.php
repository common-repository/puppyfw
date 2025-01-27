<?php
/**
 * Helper functions.
 *
 * @package PuppyFW
 */

namespace PuppyFW;

/**
 * Class Helpers
 */
class Helpers {

	/**
	 * Converts field type to camel case.
	 *
	 * @param  string $string String need to be converted.
	 * @return string
	 */
	public static function to_camel_case( $string ) {
		$string = str_replace( array( '-', '_' ), ' ', $string );
		$string = ucwords( $string );
		$string = str_replace( ' ', '', $string );
		return $string;
	}

	/**
	 * Converts field type to snake case.
	 *
	 * @since 0.3.0
	 *
	 * @param  string $string String need to be converted.
	 * @return string
	 */
	public static function to_snake_case( $string ) {
		$string = str_replace( array( '-', '_' ), ' ', $string );
		$string = ucwords( $string );
		$string = str_replace( ' ', '_', $string );
		return $string;
	}

	/**
	 * Gets field type mapping.
	 *
	 * @return array
	 */
	public static function field_type_mapping() {
		return apply_filters( 'puppyfw_field_type_mapping', array(
			'text'        => 'input',
			'number'      => 'input',
			'email'       => 'input',
			'tel'         => 'input',
			'post_select' => 'select',
		) );
	}

	/**
	 * Gets field vue component mapping.
	 *
	 * @return array
	 */
	public static function field_vue_component_mapping() {
		$mapping = self::field_type_mapping();
		return apply_filters( 'puppyfw_field_vue_component_mapping', $mapping );
	}

	/**
	 * Gets mapped type.
	 *
	 * @param  string $type Field type.
	 * @return string
	 */
	public static function get_mapped_type( $type ) {
		$types = self::field_type_mapping();

		if ( isset( $types[ $type ] ) ) {
			return $types[ $type ];
		}

		return $type;
	}

	/**
	 * Normalizes page data.
	 *
	 * @since 0.3.0
	 *
	 * @param  array $page_data Page data.
	 * @return array
	 */
	public static function normalize_page( $page_data ) {
		return wp_parse_args( $page_data, array(
			'parent_slug' => '',
			'page_title'  => '',
			'menu_title'  => '',
			'capability'  => 'manage_options',
			'menu_slug'   => '',
			'icon_url'    => '',
			'position'    => 100,
			'option_name' => '',
		) );
	}

	/**
	 * Loads vue components.
	 */
	public static function enqueue_components() {
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDuOALLadUZV06Yroa1SonBWh5coy-RNZc&libraries=places', array(), false, true );
		wp_enqueue_script( 'puppyfw-components', PUPPYFW_URL . 'assets/js/components.js', array( 'vue', 'jquery-ui-datepicker' ), '0.1.0', true );

		add_action( 'admin_footer', array( __CLASS__, 'components_templates' ) );
	}

	/**
	 * Prints components templates.
	 */
	public static function components_templates() {
		?>
		<script type="text/x-template" id="puppyfw-element-map-template">
			<div class="puppyfw-element-map">
				<input type="text" size="43" ref="search" :value="center.formatted_address">
				<button type="button" class="button button-secondary" @click="clearMap"><?php esc_html_e( 'Clear', 'puppyfw' ); ?></button>

				<div class="puppyfw-map-container" ref="map" style="height: 350px;">{{ error }}</div>
			</div>
		</script>
		<?php
	}
}
