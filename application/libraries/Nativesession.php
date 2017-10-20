<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ( ! defined('BASEPATH') )
    exit( 'No direct script access allowed' );

class Nativesession
{
    public function __construct()
    {
        session_start();
    }

    public function set( $key, $value )
    {
        $_SESSION[$key] = $value;
    }

    public function get( $key )
    {
        return isset( $_SESSION[$key] ) ? $_SESSION[$key] : null;
    }

    public function regenerateId( $delOld = false )
    {
        session_regenerate_id( $delOld );
    }

    public function delete( $key )
    {
        unset( $_SESSION[$key] );
    }
}