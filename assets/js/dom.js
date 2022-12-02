const DOM = function( ){
    this.id = id => document.getElementById(id);
    this.query = selector => document.querySelector(selector);
    this.queryAll = selector => document.querySelectorAll(selector);
    this.create = ( tag, obj = {} ) => Object.assign( document.createElement(tag), obj );
    this.append = ( element, parent = document.body ) => {
        Array.isArray( element ) ? 
            element.map( e => parent.appendChild(e) ) : 
            parent.appendChild( element );
    }
}