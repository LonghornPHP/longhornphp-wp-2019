<?php 

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('ACF_Blocks') ) :

class ACF_Blocks {
	
	/** @var array Storage for registered blocks */
	var $blocks = array();
	
	/** @var array Storage for the current block */
	var $block = false;
	
	var $preview_values = array();
	var $preview_fields = array();
		
	/**
	*  __construct
	*
	*  description
	*
	*  @date	10/4/18
	*  @since	5.6.9
	*
	*  @param	void
	*  @return	void
	*/
	function __construct() {
		
		// includes
		include('class-acf-location-block.php');
		
		// actions
		add_action('acf/enqueue_scripts', array($this, 'enqueue_scripts'));
		
		// ajax
		acf_register_ajax('render_block_edit', array($this, 'ajax_render_block_edit'));
		acf_register_ajax('render_block_preview', array($this, 'ajax_render_block_preview'));
	}
	
	/**
	*  add_block
	*
	*  Adds a new block to storage or returns false if already exists.
	*
	*  @date	10/4/18
	*  @since	5.6.9
	*
	*  @param	array $block The block settings
	*  @return	array|false
	*/
	function add_block( $block ) {
		
		// bail early if function does not exist
		if( !function_exists('register_block_type') ) {
			return false;
		}
		
		// vaidate
		$block = $this->validate_block( $block );
		
		// bail early if already exists
		if( $this->has_block($block['name']) ) {
			return false;
		}
		
		// append
		$this->blocks[ $block['name'] ] = $block;
		
		// register
		register_block_type( $block['name'], array(
			'attributes' => array(
				'className'	=> array(
					'type'		=> 'string',
					'default'	=> '',
				),
				'align'		=> array(
					'type'		=> 'string',
					'default'	=> '',
				),
				'data'		=> array(
					//'type'		=> 'string',
					'type'		=> 'object',
					'default'	=> '',
				),
				'id'		=> array(
					'type'		=> 'string',
					'default'	=> '',
				),
				'name'		=> array(
					'type'		=> 'string',
					'default'	=> '',
				),
				'mode'		=> array(
					'type'		=> 'mode',
					'default'	=> 'edit',
				),
			),
			'render_callback' => array($this, 'render_callback'),
		));
		
		// return
		return $block;
	}
	
	/**
	*  render_block_core_categories
	*
	*  description
	*
	*  @date	11/4/18
	*  @since	5.6.9
	*
	*  @param	type $var Description. Default.
	*  @return	type Description.
	*/
	
	function render_callback( $a, $content = '' ) {
		
		// bail ealry if is admin
		//if( is_admin() || acf_is_ajax() ) {
		//	return '';
		//}
		
		// get block
		$block = acf_get_block( $a['name'] );
		if( !$block ) {
			return '';
		} 
		
		// merge attributes into block
		$block = array_merge($block, $a);
		
		// setup postdata
		acf_setup_postdata( $block['data'], $block['id'], true );
		
		// call render_callback
		ob_start();
		if( is_callable( $block['render_callback'] ) ) {
			call_user_func( $block['render_callback'], $block );
		}
		$html = ob_get_contents();
		ob_end_clean();
		
		// reset postdata
		acf_reset_postdata( $block['id'] );
		
		// return
		return $html;
	}
	
	/**
	*  validate_block
	*
	*  Validates a block and ensures all settings exist
	*
	*  @date	10/4/18
	*  @since	5.6.9
	*
	*  @param	array $block
	*  @return	array
	*/
	
	function validate_block( $block ) {
		
		// validate
		$block = wp_parse_args($block, array(
			'name'			=> '',
			'title'			=> '',
			'description'	=> '',
			'category'		=> 'common',
			'icon'			=> 'welcome-widgets-menus',
			'data'			=> array(),
			'keywords'		=> array(),
			'useOnce'		=> false,
			'render_callback'	=> false
		));
		
		// generate name
		$block['name'] = acf_slugify( 'acf/' . $block['name'] );
		
		// return
		return $block;
	}
	
	/**
	*  has_block
	*
	*  Returns true if a block exists for the given name.
	*
	*  @date	10/4/18
	*  @since	5.6.9
	*
	*  @param	string $name The block name.
	*  @return	boolean
	*/
	
	function has_block( $name ) {
		return isset( $this->blocks[ $name ] );
	}
	
	/**
	*  get_block
	*
	*  Returns a block for the given name.
	*
	*  @date	10/4/18
	*  @since	5.6.9
	*
	*  @param	string $name The block name.
	*  @return	array|false
	*/
	
	function get_block( $name ) {
		return isset( $this->blocks[ $name ] ) ? $this->blocks[ $name ] : false;
	}
	
	/**
	*  remove_block
	*
	*  Removes a block for the given name.
	*
	*  @date	10/4/18
	*  @since	5.6.9
	*
	*  @param	string $name The block name.
	*  @return	boolean
	*/
	
	function remove_block( $name ) {
		
		// return false if desn't exist
		if( !$this->has_block($name) ) {
			return false;
		
		// unset and return true
		} else {
			unset( $this->blocks[ $name ] );
			return true;
		}
	}
	
	/**
	*  get_blocks
	*
	*  Returns all block for the given args.
	*
	*  @date	10/4/18
	*  @since	5.6.9
	*
	*  @param	array $args
	*  @return	array
	*/
	
	function get_blocks() {
		return $this->blocks;
	}
	
	/**
	*  ajax_render_block_edit
	*
	*  description
	*
	*  @date	10/4/18
	*  @since	5.6.9
	*
	*  @param	type $var Description. Default.
	*  @return	type Description.
	*/
	
	function ajax_render_block_edit() {
		
		// validate
		if( !acf_verify_ajax() ) {
			 die();
		}
		
   		// get block
   		$block = acf_maybe_get_POST('block');
   		if( !$block ) {
	   		die();
   		}
   		
   		// unslash $_POST data
   		$block = wp_unslash($block);
   		
   		// get block type
		$block_type = acf_get_block( $block['name'] );
		if( !$block_type ) {
			die();
		}
		
		// merge together
		$block = array_merge($block_type, $block);
		
		// setup postdata
		acf_setup_postdata( $block['data'], $block['id'], true );
		   		
		// get field groups
		$field_groups = acf_get_field_groups( array(
			'block'	=> $block['name']
		));
				
		// loop
		foreach( $field_groups as $field_group ) {
			
			// vars
			$fields = acf_get_fields( $field_group );
			
			// render fields
			acf_render_fields( $fields, $block['id'], 'div', $field_group['instruction_placement'] );
		}
		
		// reset postdata
		acf_reset_postdata( $block['id'] );
		
		// return
		die;
	}
	
	/**
	*  ajax_render_block_preview
	*
	*  description
	*
	*  @date	11/10/18
	*  @since	5.7.8
	*
	*  @param	type $var Description. Default.
	*  @return	type Description.
	*/
	function ajax_render_block_preview() {
		
		// validate
		if( !acf_verify_ajax() ) {
			 die();
		}
		
   		// get block
   		$block = acf_maybe_get_POST('block');
   		if( !$block ) {
	   		die();
   		}
   		
   		// unslash $_POST data
   		$block = wp_unslash($block);
   		
   		// render
   		echo $this->render_callback( $block );
   		die;
	}
		
	/**
	*  enqueue_scripts
	*
	*  description
	*
	*  @date	10/4/18
	*  @since	5.6.9
	*
	*  @param	type $var Description. Default.
	*  @return	type Description.
	*/
	
	function enqueue_scripts() {
		
		// enqueue
		wp_enqueue_script('acf-blocks', acf_get_url('includes/gutenberg/assets/js/acf-blocks.js'), array('acf-input'), ACF_VERSION );
		wp_enqueue_style('acf-blocks', acf_get_url('includes/gutenberg/assets/css/acf-blocks.css'), array('acf-input'), ACF_VERSION );
		
		// localize
		acf_localize_data(array(
			'blocks'	=> array_values($this->get_blocks())
		));
	}
}

// instantiate
acf_new_instance('ACF_Blocks');

endif; // class_exists check

function acf_register_block( $block ) {
	return acf_get_instance('ACF_Blocks')->add_block( $block );
}

function acf_get_blocks() {
	return acf_get_instance('ACF_Blocks')->get_blocks();
}

function acf_get_block( $name ) {
	return acf_get_instance('ACF_Blocks')->get_block( $name );
}

function acf_has_block( $name ) {
	return acf_get_instance('ACF_Blocks')->has_block( $name );
}

function acf_remove_block( $name ) {
	return acf_get_instance('ACF_Blocks')->remove_block( $name );
}

?>