<?php /*
Plugin Name: Standard Employee List
Plugin URI: http://batch24.xyz/demo/plugins
Author: Sujan
Author URI: http://mtmsujan.com 
Version: 1.0 
Description: Standard and Easy to Use Employee List Plugin
*/



class Employee {
	public function __construct(){
		add_action('init', array($this, 'employee_default_init'));
		add_action('add_meta_boxes', array($this, 'employee_metabox_callback'));
		add_action('save_post', array($this, 'employee_metabox_save'));
		add_action('admin_enqueue_scripts', array($this, 'jquery_ui_tabs') );
	}

	public function jquery_ui_tabs(){
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('employee_script', PLUGINS_URL('js/custom.js', __FILE__), array('jquery', 'jquery-ui-tabs') );

		wp_enqueue_style('employee-custom', PLUGINS_URL('css/custom.css', __FILE__));
	}

	public function employee_default_init(){
		$labels = array(
			'name'               => _x( 'Employee', 'Employee Admin Menu Name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Employee', 'Employee Admin Menu singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Employee', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Employee', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'Employee', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Employee', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Employee', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Employee', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Employee', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Employee', 'your-plugin-textdomain' ),
			'search_items'       => __( 'Search Employee', 'your-plugin-textdomain' ),
			'parent_item_colon'  => __( 'Parent Employee:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No Employee found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No Employee found in Trash.', 'your-plugin-textdomain' )
		);

		$args = array(
			'labels'             => $labels,
	                'description'        => __( 'Employee list.', 'your-plugin-textdomain' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'employee' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon' 		 => 'dashicons-groups',
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'employee_list', $args );

		// employee types 

		$labels = array(
			'name'              => _x( 'Employee Types', 'taxonomy general name' ),
			'singular_name'     => _x( 'Employee Type', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Employee Types' ),
			'all_items'         => __( 'All Employee Types' ),
			'parent_item'       => __( 'Parent Employee Type' ),
			'parent_item_colon' => __( 'Parent Employee Type:' ),
			'edit_item'         => __( 'Edit Employee Type' ),
			'update_item'       => __( 'Update Employee Type' ),
			'add_new_item'      => __( 'Add New Employee Type' ),
			'new_item_name'     => __( 'New Employee Type Name' ),
			'menu_name'         => __( 'Employee Type' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'type' ),
		);

		register_taxonomy( 'employee_type', array( 'employee_list' ), $args );


	}

	public function employee_metabox_callback(){
		// metabox for employees 
		
		add_meta_box('employee-info', 'Employee Information', array($this, 'employee_information'), 'employee_list', 'normal', 'high');
	}
	public function employee_information(){

		$value = get_post_meta(get_the_id(), 'employee-info', true);

		?>

		<div id="tabs">
		  <ul>
		    <li><a href="#personal">Personal Information</a></li>
		    <li><a href="#official">Official Information</a></li>
		    <li><a href="#academic">Academic Information</a></li>
		    <li><a href="#experience">Experience</a></li>
		  </ul>
		  <div id="personal">
		    <p><label for="father">Father's Name</label></p>
		    <p><input type="text" class="widefat" name="father" value="" id="father"></p>
		    <p><label for="mother">Mother's Name</label></p>
		    <p><input type="text" class="widefat" name="mother" value="" id="mother"></p>

		    <p>
		    	<input type="radio" class="widefat" name="gender" value="male" id="male">
		    	<label for="male"> Male</label> <br>
		    	<input type="radio" class="widefat" name="gender" value="female" id="female">
		    	<label for="female">Female</label>
		    </p>
		  </div>


		  <div id="official">
		    <p><label for="designation">Designation</label></p>
		    <p><input type="text" class="widefat" name="designation" value="" id="designation"></p>
		  </div>


		  <div id="academic">
		    <p><label for="sscyear">SSC Year</label></p>
		    <p><input type="text" class="widefat" name="sscyear" value="" id="sscyear"></p>
		  </div>


		  <div id="experience">
		    <p><label for="skills">Skills:</label></p>
		    <p><input type="text" class="widefat" name="skills" value="" id="skills"></p>
		  </div>

		</div>
		<?php 
	}

	public function employee_metabox_save($post_id){

		$designation = $_POST['employee_designation'];
		update_post_meta($post_id, 'employee-info', $designation);
	}


}


$employee = new Employee();