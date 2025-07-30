<?php
/**
 * Plugin Name: Tomatillo Design ~ Staff Cards
 * Description: A custom ACF block for creating staff cards with bio, image, and details.
 * Version: 1.0
 * Author: Chris Liu-Beers, Tomatillo Design
 * Author URI: http://www.tomatillodesign.com
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Register block assets
add_action( 'enqueue_block_assets', function() {
    wp_enqueue_style(
        'td-staff-cards',
        plugin_dir_url( __FILE__ ) . 'staff-cards.css',
        array(),
        filemtime( plugin_dir_path( __FILE__ ) . 'staff-cards.css' )
    );
});

// Register custom block
add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    acf_register_block_type( array(
        'name'              => 'td-staff-card',
        'title'             => __( 'Staff Card', 'td-staff' ),
        'description'       => __( 'Displays a staff profile card.', 'td-staff' ),
        'render_callback'   => 'td_staff_card_render',
        'category'          => 'widgets',
        'icon'              => 'id-alt',
        'keywords'          => array( 'staff', 'person', 'profile' ),
        'supports'          => array(
            'align' => true,
        ),
        'enqueue_style'     => plugin_dir_url( __FILE__ ) . 'staff-cards.css',
    ) );
});






add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_671a53dbdf50a',
	'title' => 'BLOCK: Person',
	'fields' => array(
		array(
			'key' => 'field_671a53dcd8d0a',
			'label' => 'Name + Credentials',
			'name' => 'name',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'allow_in_bindings' => 0,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_671a5401d8d0b',
			'label' => 'Title(s)',
			'name' => 'titles',
			'aria-label' => '',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'allow_in_bindings' => 0,
			'rows' => 2,
			'placeholder' => '',
			'new_lines' => 'br',
		),
		array(
			'key' => 'field_6724e75087d68',
			'label' => 'Pronouns',
			'name' => 'pronouns',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'allow_in_bindings' => 0,
			'placeholder' => 'she/her',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_671a5437d8d0d',
			'label' => 'Featured Image',
			'name' => 'person_featured_image',
			'aria-label' => '',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
			'allow_in_bindings' => 0,
			'preview_size' => 'medium',
		),
		array(
			'key' => 'field_671a5412d8d0c',
			'label' => 'Bio',
			'name' => 'bio',
			'aria-label' => '',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'allow_in_bindings' => 0,
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
		array(
			'key' => 'field_6724e98e6a9a8',
			'label' => 'Accent Color',
			'name' => 'accent_color',
			'aria-label' => '',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'enable_opacity' => 0,
			'return_format' => 'string',
			'allow_in_bindings' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/td-staff-card',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );
} );





// Render callback
function td_staff_card_render( $block, $content = '', $is_preview = false, $post_id = 0 ) {
    $name     = get_field( 'name' );
    $titles   = get_field( 'titles' );
    $pronouns = get_field( 'pronouns' );
    $bio      = get_field( 'bio' );
    $accent   = get_field( 'accent_color' );
    $image_id = get_field( 'person_featured_image' );
    $image    = $image_id ? wp_get_attachment_image( $image_id, 'medium' ) : '';

    $block_to_publish = '';

    // Create class attribute allowing for custom "className" and "align" values.
    $class_name = 'yak-staff-card';
    if ( ! empty( $block['className'] ) ) {
        $class_name .= ' ' . esc_attr( $block['className'] );
    }
    if ( ! empty( $block['align'] ) ) {
        $class_name .= ' align' . esc_attr( $block['align'] );
    }

    // Build subfields
    if ( $name ) {
        $name = '<h2 class="yak-staff-card__name">' . esc_html( $name ) . '</h2>';
    }

    if ( $titles ) {
        $titles = '<div class="yak-staff-card__titles">' . nl2br( esc_html( $titles ) ) . '</div>';
    }

    if ( $pronouns ) {
        $pronouns = '<div class="yak-staff-card__pronouns">' . esc_html( $pronouns ) . '</div>';
    }

    if ( $bio ) {
        $bio = '<div class="yak-staff-card__bio">' . wp_kses_post( $bio ) . '</div>';
    }

    $person_featured_image = '';
    if ( $image_id ) {
        $person_featured_image = '<div class="yak-staff-card__image">' . wp_get_attachment_image( $image_id, 'medium' ) . '</div>';
    }

    if ( ! $accent ) {
        $accent = 'var(--yak-color-primary)';
    }

    // Assemble markup
    $block_to_publish .= $person_featured_image . '<div class="yak-staff-card__content">' . $name . $titles . $pronouns . $bio . '</div>';

    $block_to_publish = '<div class="' . $class_name . '" style="--person-accent-color: ' . esc_attr( $accent ) . ';">' . $block_to_publish . '</div>';

    echo $block_to_publish;
}
