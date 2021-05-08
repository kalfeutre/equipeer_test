<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Email
 *
 * @class Email
 */
class Equipeer_Email extends Equipeer {

    /**
     * Load automatically when class initiate
     *
     * @since 1.0.1
     */
    public function __construct() {

    }

    /**
     * Initializes the Equipeer_Email() class
     *
     * Checks for an existing Equipeer_Email() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self;
        }

        return $instance;
    }
	
}