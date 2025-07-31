( function( api ) {

	// Extends our custom "creative-gem" section.
	api.sectionConstructor['real-estate-elementor'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );