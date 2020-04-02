<?php
/*
Plugin Name: Job Board Manager - Related Jobs
Plugin URI: http://pickplugins.com
Description: Display related jobs under single job page.
Version: 1.0.1
Text Domain: job-board-manager-related-jobs
Author: pickplugins
Author URI: http://pickplugins.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class JobBoardManagerRelatedJobs{
	
	public function __construct(){
	
		$this->_define_constants();	
		$this->_loading_script();
		$this->_loading_functions();
		
		//register_activation_hook( __FILE__, array( $this, '_activation' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ));
		
	
	}
	
	public function _activation() {


	
	}
	
	public function load_textdomain() {
		
		load_plugin_textdomain( 'job-board-manager-related-jobs', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
	}
	

	
	public function _loading_functions() {
		
		require_once( job_bm_rj_dir . 'includes/functions.php');
        require_once( job_bm_rj_dir . 'includes/functions-settings.php');

	}
	

	
	public function _loading_script() {
	

		add_action( 'wp_enqueue_scripts', array( $this, '_front_scripts' ) );

	}

	
	public function _define_constants() {

		$this->define('job_bm_rj_url', plugins_url('/', __FILE__)  );
		$this->define('job_bm_rj_dir', plugin_dir_path( __FILE__ ) );
		$this->define('job_bm_rj_plugin_name', __('Job Board Manager - Related Jobs', 'job-board-manager-related-jobs') );

	}
	
	private function define( $name, $value ) {
		if( $name && $value )
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}
	
	

		
		
	public function _front_scripts(){


	}

	
	
} new JobBoardManagerRelatedJobs();