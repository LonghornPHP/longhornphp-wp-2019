(function($, undefined){
	
	// wp.data.select( 'core/editor' )
	// wp.data.dispatch( 'core/editor' )
	// wp.data.dispatch( 'core/editor' ).savePost()
	//wp.data.dispatch( 'core/editor' ).editPost({ foo: 'bar' });
	
	
	
/*
	} else {
		dispatch( removeNotice( SAVE_POST_NOTICE_ID ) );
		dispatch( removeNotice( AUTOSAVE_POST_NOTICE_ID ) );

		request = apiFetch( {
			path: `/wp/v2/${ postType.rest_base }/${ post.id }`,
			method: 'PUT',
			data: toSend,
		} );
	}
*/
	



/*


const { __ } = wp.i18n;
	const { registerBlockType } = wp.blocks;
	const { InspectorControls } = wp.editor;
	const { TextControl, PanelBody } = wp.components;

registerBlockType('jsforwpblocks/meta-box', {
	title: 'Example - Meta Box', 
	description: 'An example of how to build a block with a meta box field.', 
	category: 'common',       
	keywords: [
		'Meta',
		'Custom field',
		'Box'
	],    
	attributes: {        
		text: {            
			type: 'string',            
			source: 'meta',            
			meta: 'jsforwpblocks_gb_metabox'        
		}    
	},    
	edit: function edit(props) {        
		var text = props.attributes.text,            
		className = props.className,            
		setAttributes = props.setAttributes;        
		
		return wp.element.createElement(TextControl, {
						label: 'Meta box',                    
						value: text,  
						name: 'acftest',                  
						onChange: function onChange(text) {                        
							return setAttributes({ text: text });                    
						}                
					});
					
		return [
			wp.element.createElement(
				InspectorControls, 
				null, 
				wp.element.createElement(
					PanelBody,                
					null,                
					wp.element.createElement(TextControl, {
						label: 'Meta box',                    
						value: text,                    
						onChange: function onChange(text) {                        
							return setAttributes({ text: text });                    
						}                
					})            
				)        
			), 
			wp.element.createElement(
				'div',            
				{ className: className },            
				wp.element.createElement(                
					'p',                
					null,                
					'Check the meta'           
				)        
			)
		];    
	},    
	save: function save(props) {        
		return wp.element.createElement(            
			'p',            
			null,            
			'Check the meta'      
		);    
	}
});
	
*/
	
})(jQuery);