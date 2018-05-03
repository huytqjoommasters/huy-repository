<?php
/**
 * Created by PhpStorm.
 * User: Tran Huy
 * Date: 5/3/2018
 * Time: 2:20 PM
 */

class Jms_Customize {
    public function __construct() {
        add_action( 'customize_register', array( $this, 'initialize' ) );
    }
}