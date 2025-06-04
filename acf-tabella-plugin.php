<?php
/**
 * Plugin Name: ACF Tabella Shortcode
 * Description: Crea uno shortcode [acf_tabella] che mostra una tabella ACF stilizzata. usare "tab" come slug
 * Version: 1.0
 * Author: Angelo
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Blocca accessi diretti
}

// Shortcode
function acf_tabella_shortcode_output() {
    $table = get_field( 'tab' );

    if ( empty( $table ) ) {
        return '';
    }

    ob_start();

    echo '<div class="acf-table-wrapper">';
    echo '<table class="acf-table">';

    if ( ! empty( $table['caption'] ) ) {
        echo '<caption>' . esc_html( $table['caption'] ) . '</caption>';
    }

    if ( ! empty( $table['header'] ) ) {
        echo '<thead><tr>';
        foreach ( $table['header'] as $th ) {
            echo '<th>' . esc_html( $th['c'] ) . '</th>';
        }
        echo '</tr></thead>';
    }

    echo '<tbody>';
    foreach ( $table['body'] as $tr ) {
        echo '<tr>';
        foreach ( $tr as $td ) {
            echo '<td>' . esc_html( $td['c'] ) . '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody>';

    echo '</table>';
    echo '</div>';

    return ob_get_clean();
}
add_shortcode( 'acf_tabella', 'acf_tabella_shortcode_output' );

// Enqueue stile
function acf_tabella_enqueue_styles() {
    wp_enqueue_style(
        'acf-tabella-style',
        plugin_dir_url( __FILE__ ) . 'style.css',
        array(),
        '1.0'
    );
}
add_action( 'wp_enqueue_scripts', 'acf_tabella_enqueue_styles' );
