(function($, undefined){
	
	// vars
	var blocks = {};
	var onChangeTimeout = 0;
	var isSerializing = false;
	
	// WP vars
	var el = wp.element.createElement,
	    Fragment = wp.element.Fragment,
	    BlockControls = wp.editor.BlockControls,
	    BlockAlignmentToolbar = wp.editor.BlockAlignmentToolbar;
	var PanelBody = wp.components.PanelBody;
	var InspectorControls = wp.editor.InspectorControls;
	
	/**
	*  acf.getBlock
	*
	*  Returns a block instance.
	*
	*  @date	10/10/18
	*  @since	5.7.8
	*
	*  @param	mixed $el Either a jQuery element or the block clientId.
	*  @return	object
	*/
	acf.getBlock = function( cid ){
		return blocks[ cid ] || null;
	};
	
	/**
	*  acf.newBlock
	*
	*  Returns a new block instance for the given props.
	*
	*  @date	10/10/18
	*  @since	5.7.8
	*
	*  @param	object props The block properties.
	*  @return	object
	*/
	acf.newBlock = function( props ){
		
		// creat new
		var block = new acf.models.Block( props );
		
		// append
		blocks[ block.cid ] = block;
		
		// return
		return block;
	};
	
	/**
	*  registerBlockTypes
	*
	*  description
	*
	*  @date	11/4/18
	*  @since	5.6.9
	*
	*  @param	type $var Description. Default.
	*  @return	type Description.
	*/
	
	acf.registerBlockTypes = function( blocks ){
		blocks.map(acf.registerBlockType);
	};
	
	/**
	*  acf.registerBlockType
	*
	*  Registeres a JS block
	*
	*  @date	7/8/18
	*  @since	5.7.3
	*
	*  @param	object block The block settings localized from PHP
	*  @return	object
	*/
	acf.registerBlockType = function( blockType ){
		
		// extend block with default functionality
		$.extend(blockType, {
			
			// each block needs an id and data
			attributes: {
				id: { 
					type: 'string',
				},
				data: { 
					type: 'object',
				},
				name: { 
					type: 'string',
				},
				align: {
		            type: 'string',
		        },
		        mode: {
		            type: 'string',
		        },
			},
			
			// callback used when editing the block
			edit: function( props ) {
				
				// get block
				var block = acf.getBlock( props.clientId );
				
				// create new block if does not yet exist
				if( !block ) {
					block = acf.newBlock( props );
				}
				
				// edit
				block.edit( props );
				
				// edit selected / unselected
/*
				if( block.isSelected() ) {
					block.editSelected();
				} else {
					block.editUnselected();
				}
*/
				
				// return elements
				return el(
					Fragment,
					null,
					
					// block controls
					el(
	                    BlockControls,
	                    null,
	                    el(
	                        BlockAlignmentToolbar,
	                        {
		                        className: 'acf-block-toolbar acf-block-toolbar-' + block.get('id'),
	                            value: block.get('align'),
								onChange: function( val ){ 
									block.setAttributes({ align: val });
								},
	                        }
	                    )
	                ),
	                
	                // inspector controls
	                el(
	                    InspectorControls,
	                    null,
	                    el(
							'div',
							{
								id: 'acf-block-panel-' + block.get('id'),
								className: 'acf-block-panel'
							},
							el(
								'div',
								{
									className: 'acf-block-panel-actions'
								},
								el(
									'button',
									{
										type: 'button',
										id: 'acf-block-preview-button-' + block.get('id'),
										className: 'button acf-block-preview-button',
										onClick: function(){
											block.toggleMode();
										},
									},
									block.get('mode') == 'preview' ? acf.__('Switch to Edit') : acf.__('Switch to Preview')
								),
							),
							block.get('mode') == 'preview' ? 
							el(
								'div',
								{
									id: 'acf-block-fields-' + block.get('id'),
									className: 'acf-block-fields acf-fields',
								}
							) : false
						)
	                ),
	                
	                // block content
					el(
						'div',
						{
							id: 'acf-block-body-' + block.get('id'),
							className: 'acf-block-body is-' + block.get('mode')
						},
						block.get('mode') == 'edit' ? 
						el(
							'div',
							{
								id: 'acf-block-fields-' + block.get('id'),
								className: 'acf-block-fields acf-fields',
							}
						):
						el(
							'div',
							{
								id: 'acf-block-preview-' + block.get('id'),
								className: 'acf-block-preview'
							}
						)
					)
				);
				
				
				
				
				
				// create a loading placeholder
				return el(
					Fragment,
					null,
					
					// block controls
					el(
	                    BlockControls,
	                    null,
	                    el(
	                        BlockAlignmentToolbar,
	                        {
		                        className: 'acf-block-toolbar acf-block-toolbar-' + block.get('id'),
	                            value: block.get('align'),
								onChange: function( val ){ 
									block.setAttributes({ align: val });
								},
	                        }
	                    )
	                ),
	                
	                // inspector controls
	                el(
	                    InspectorControls,
	                    null,
	                    el(
							'div',
							{
								id: 'acf-block-panel-' + block.get('id'),
								className: 'acf-block-panel'
							}
/*
							,
							el(
								'button',
								{
									type: 'button',
									id: 'acf-block-preview-button-' + block.get('id'),
									className: 'acf-block-preview-button'
								}
							),
							el(
								'div',
								{
									id: 'acf-block-inspector-' + block.get('id'),
									className: 'acf-block-inspector'
								}
							)
*/
						)
	                ),
	                
	                // block content
					el(
						'div',
						{
							id: 'acf-block-body-' + block.get('id'),
							className: 'acf-block-body is-' + this.get('mode')
						},
						el(
							'div',
							{
								id: 'acf-block-fields-' + block.get('id'),
								className: 'acf-block-fields acf-fields',
							}
						),
						false,
						el(
							'div',
							{
								id: 'acf-block-preview-' + block.get('id'),
								className: 'acf-block-preview'
							}
						),
						el(
							'div',
							{
								id: 'acf-block-inspector-' + block.get('id'),
								className: 'acf-block-inspector'
							}
						)
					)
				);
			},
	
			// callback used when saving the block
			save: function( props ) {
				return null;
			},
			
			getEditWrapperProps: function( attributes ) {
				var align = attributes.align || '';
				if( align ) {
					return { 'data-align': align };
				}
			},
		});
		
		// register
		var result = wp.blocks.registerBlockType( blockType.name, blockType );
		
		// return
		return result;
	};
	
	/**
	*  blocksManager
	*
	*  description
	*
	*  @date	7/8/18
	*  @since	5.7.3
	*
	*  @param	type $var Description. Default.
	*  @return	type Description.
	*/
	var blocksManager = new acf.Model({
		wait: 'prepare',
		initialize: function(){
			acf.registerBlockTypes( acf.get('blocks') );
		}
	});
	
	
	/**
	*  acf.models.Block
	*
	*  The block model.
	*
	*  @date	10/10/18
	*  @since	5.7.8
	*
	*  @param	void
	*  @return	void
	*/
	acf.models.Block = acf.Model.extend({
		
		data: {
			id:		'',
			data:	{},
			name: 	'',
			align: 	'',
			mode:	'edit'
		},
		
		setup: function( block ){
			
			// if this is a new block
			if( !block.attributes.id ) {
				block.attributes.id = acf.uniqid('block_');
				block.attributes.name = block.name;
			}
			
			// sync block
			this.sync( block );
		},
		
		sync: function( block ){
			
			// set cid
			this.cid = block.clientId;
			
			// extend data
			$.extend(this.data, block.attributes);
			
			// store reference of block
			this.block = block;
		},
		
		$block: function(){
			return $('#block-' + this.cid);
		},
		
		$inspector: function(){
			return $('#acf-block-inspector-' + this.get('id'));
		},
		
		$previewButton: function(){
			return $('#acf-block-preview-button-' + this.get('id'));
		},
		
		$panel: function(){
			return $('#acf-block-panel-' + this.get('id'));
		},
		
		$body: function(){
			return $('#acf-block-body-' + this.get('id'));
		},
		
		$fields: function(){
			return $('#acf-block-fields-' + this.get('id'));
		},
		
		$preview: function(){
			return $('#acf-block-preview-' + this.get('id'));
		},
		
		$toolbar: function(){
			return $('.editor-block-toolbar');
		},
		
		initialize: function(){
			
			// block DOM does not yet exist. Use timeout.
			this.setTimeout(function(){
				
				// append preview button to inspector
/*
				this.$inspector().append(
					$('<div />').attr({
						'class': 'acf-block-inspector-actions'
					}).append(
						$('<button />').attr({
							'type': 'button',
							'class': 'button acf-block-preview-button',
							'id': 'acf-block-preview-button-' + this.get('id')
						})
					)
				);
*/
				
				// add events
				//this.on( this.$fields(), 'change keyup', 'onChange' );
				//this.on( this.$inspector(), 'mousedown', 'onMouseDown' );
				//this.on( this.$previewButton(), 'click', 'onClickPreview' );
				
				
				// fetch preview
				//if( this.get('mode') == 'preview' ) {
				//	this.$inspector().append( this.$fields() );
				//	this.fetchPreview();
				//}
			});
		},
		
		edit: function( block ){
			console.log('edit');
			// sync block
			this.sync( block );
			
			// block DOM does not yet exist. Use timeout.
			this.setTimeout(function(){
				
				// fetch fields if done exist
				if( this.$fields().length ) {
					this.fetchFields();
				}
				
				// fetch preview
				if( this.get('mode') == 'preview' ) {
					this.fetchPreview();
				}
			});
		},
		
		fetchFields: function(){
			
			// vars
			var $fields = this.$fields();
			
			// bail ealry if already loaded
			if( $fields.hasClass('is-loaded') ) {
				return;
			}
			
			// add class
			$fields.addClass('is-loading');
			
			// ajax
			$.ajax({
		    	url: acf.get('ajaxurl'),
				dataType: 'html',
				type: 'post',
				cache: false,
				data: acf.prepare_for_ajax({
					action:	'acf/ajax/render_block_edit',
					block: this.data
				}),
				context: this,
				success: function( html ){
					
					// update classes
					$fields.removeClass('is-loading').addClass('is-loaded');
					
					// append html
					$fields.html( html )
					
					// append html and do action
					acf.doAction('append', $fields.html( html ));
					
					// add event
					this.on( $fields, 'change keyup', 'onChange' );
				}
			});
		},
		
		fetchPreview: function(){
			
			// clear timeout
			if( this.timeoutPreview ) {
				clearTimeout(this.timeoutPreview);
			}
			
			// set new timeout
			this.timeoutPreview = this.setTimeout(function(){
				
				// ajax
				$.ajax({
			    	url: acf.get('ajaxurl'),
					dataType: 'html',
					type: 'post',
					cache: false,
					data: acf.prepare_for_ajax({
						action:	'acf/ajax/render_block_preview',
						block: this.data
					}),
					context: this,
					success: function( html ){
						this.$preview().html( html );
					}
				});
				
			}, 300);
		},
		
		toggleMode: function(){
			
			// toggle
			if( this.get('mode') == 'preview' ) {
				this.setAttributes({ mode: 'edit' });
			} else {
				this.setAttributes({ mode: 'preview' });
			}
		},
		
		onChange: function( e, $el ){
			
			// set local timeout used by this.edit()
			//clearTimeout(onChangeTimeout);
			//onChangeTimeout = this.setTimeout(this.serialize, 300);
			
			this.setAttributes({
				data: acf.serialize( this.$fields(), 'acf' ),
			});
		},
		
		serialize: function(){
			
			// update vars
			isSerializing = true;
			
			// update attributes
			this.setAttributes({
				data: acf.serialize( this.$fields(), 'acf' ),
			});
			
			// update vars
			isSerializing = false;
		},
		
		onClickPreview: function( e, $el ){
			
			// prevent default
			e.preventDefault();
			
			// toggle
			if( this.get('mode') == 'preview' ) {
				this.toggleMode('edit');
			} else {
				this.toggleMode('preview');
			}
		},
/*
		
		toggleMode: function( mode ){
			
			// defaults
			mode = mode || 'edit';
			
			// set attribute
			this.setAttributes({
				mode: mode,
			});
			
			// trigger sortable
			acf.doAction('sortstart', this.$fields());
				
			// preview
			if( mode == 'preview' ) {
				
				// move to inspector
				this.$inspector().append( this.$fields() );
				this.fetchPreview();
				
			// edit	
			} else {
				
				// move to body
				this.$body().append( this.$fields() );
			}
			
			// trigger sortable
			acf.doAction('sortstop', this.$fields());
		},
		
*/
		
		
		
		
		setAttributes: function( attributes ){
			return this.block.setAttributes( attributes );
		},
		
		isSelected: function(){
			return this.block.isSelected;
		}
	});

})(jQuery);