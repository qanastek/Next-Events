<?php
/**
* @package NextEvents
* @author Labrak Yanis
* @version 1.0.0
*/
/*
Plugin Name: NEXT EVENTS
Description: Planifiez des évènements futur de façon simple et rapide à l'aide de NEXT EVENTS.
Version: 1.0.0
Author: Labrak Yanis
Author URI: https://www.facebook.com/yanislabrak
Author email: yanis.labrak.itec@gmail.com
License: MIT
*/

/*
MIT License

Copyright (c) 2018 Labrak Yanis

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

// Anti injection script
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );


if ( ! defined( 'NEXT_EVENTS_ABSPATH' ) )
{
	define( 'NEXT_EVENTS_ABSPATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'NEXT_EVENTS__FILE__' ) )
{
	define( 'NEXT_EVENTS__FILE__', __FILE__ );
}

if ( ! defined( 'NEXT_EVENTS_BASENAME' ) )
{
	define( 'NEXT_EVENTS_BASENAME', plugin_basename( NEXT_EVENTS__FILE__ ) );
}

/**
 * Charge le fichier avec toutes les class.
 */
require_once NEXT_EVENTS_ABSPATH . 'classes/class-next_events.php';

// Lance NextEvents
add_action( 'init', array( 'NextEvents', 'next_events_init' ) );