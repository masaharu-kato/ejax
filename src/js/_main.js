/*
 *  Script in first
 */

let main = null;
let forms = {};

//	when back / forward button on browser has pushed
window.onpopstate = function(event){

//	when first access
    if(!event.state) return;

    main.setState(event.state.page, event.state.params);
}


window.onload = function() {

    

}
