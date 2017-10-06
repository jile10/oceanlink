$.validator.addMethod( "nowhitespace", function( value, element ) {
	return this.optional( element ) || /^\S+$/i.test( value );
}, "No white space please" );

$.validator.addMethod("space", function(value, element) {          
    return this.optional(element) || $.trim(value) != "";
}, "No white spaces");
