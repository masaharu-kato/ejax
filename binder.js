
let Ejax = {};

Ejax.Binder = (function() {

    /* constructor */
    let Binder = function(params) {
        if(!(this instanceof Binder)) return new Binder(params);

        this.params = new Ejax.BinderParams(params);
    };



    
    const ATTR_FOREACH = 'foreach';
    const ATTR_USE = 'use';
    const ATTR_IF = 'if';

    //  name of attributes which has special meaning of element
    const SPECIAL_ATTRS = [ATTR_FOREACH, ATTR_USE, ATTR_IF];



    // define prototype of this type
    const This = Binder.prototype;


    //  bind params to element cloned from model element;
    //  element: target element object
    This.to = function(elm_model) {
    
        // clone node recursively
        let new_element = elm_model.cloneNode(true);

        // bind params to new_element
        this.toElement(new_element);

        return new_element;
    };



    // bind params to element including special attributes
    This.toElement = function(element) {

        //  check value at 'if' attribute
        if(!this.checkIfText(element, ATTR_IF)) return;
        
        //  set value using specified at 'use' attribute
        this.params.tryUse(element, ATTR_USE);

        //  clone with value specified at 'foreach' attribute
        this.tryForeachTo(element);

        //  bind params to attributes of element
        this.toAttributes(element.attributes);

        //  bind params to child nodes or elements
        this.toNodes(element.childNodes);

    };

    

    // bind params to element including special attributes
    This.toElementInternal = function(element) {

        //  check value at 'if' attribute
        if(!this.checkIfText(element, ATTR_IF_INTERNAL)) return;
        
        //  set value using specified at 'use' attribute
        this.params.tryUse(element, ATTR_USE_INTERNAL);

        //  clone with value specified at 'foreach' attribute
        this.tryForeachTo(element);

        //  bind params to attributes of element
        this.toAttributes(element.attributes);

        //  bind params to child nodes or elements
        this.toNodes(element.childNodes);

    };


    //  bind params to attributes of element
    This.toAttributes = function(attrs) {
        if(!attrs) return null;

        let n_attrs = attrs.length;
        for(let i=0; i<n_attrs; i++) {

            //  if current attribute is special, skip
            if(SPECIAL_ATTRS.indexOf(attrs[i].name) >= 0) continue;

            //  bind params to value of current attribute
            attrs[i].value = this.toText(attrs[i].value);
        }

    };




    //  bind params to child nodes in element
    This.toNodes = function(nodes) {
        if(!nodes) return null;

        for(let i=0; i<nodes.length; i++){
            this.toNode(nodes[i]);
        }

    };


    /* bind params to various node */
    This.toNode = function(node) {

        switch(nodes[i].nodeType) {
        case Node.ELEMENT_NODE:
            return this.toElement(node);

        case Node.TEXT_NODE:
            return this.toTextNode(node);

        case Node.DOCUMENT_NODE:
            return this.toChildNodes(node);

        }

        return null;
    };



    /* bind params to text node */
    This.toTextNode = function(node) {
        node.nodeValue = this.toText(node.nodeValue);
    };



    /* bind params to text and returns it */
    This.toText = function(text) {

        text = text.trim();

        if(text){
            text = text.replace(

                /* 3 patterns ($hoge, {$hoge}, ${hoge}) with case sensitive*/
                /\$([\w.]+)|\{\$([\w.]+)\}|\$\{([^\}]+)\}/ig,

                /* replace with value of matched parameter key */
                function(match, p1) {
                    return this.params.getValue(p1);
                }.bind(this)

            );
        }

        return text;
    };

    This.getValueText = function(match, p1, p2, p3) {
        
    };


    //
    This.checkIfText = function(element, ATTR_NAME) {
        if(!element.hasAttribute(ATTR_NAME)) return true;

        return this.evaluateText(element.getAttribute(ATTR_NAME));
    };

    //
    This.evaluateText = function(text) {
        return Function('return ' + this.toText(text))();
    }


    // try `foreach`
    This.tryForeachTo = function(element) {
        if(!element.hasAttribute(ATTR_FOREACH)) return;

        let path = this.params.getFormattedPath(element.getAttribute(ATTR_FOREACH));
        if(!path) return;

        /* run foreach process to element */
        this.foreachTo(element, this.params.getPathValue(path));
    };


    /* generate elements from prototype with array of object  */
    This.foreachTo = function(elm_model, obj_info) {

        this.foreachToClone(elm_model, obj_info);

        /* remove original element */
        elm_model.parentNode.removeChild(elm_model);

    };


    /* foreach internal process */
    This.foreachToClone = function(elm_model, obj_info) {
        /* obj_info has .path .value attributes */
        const self = this;

        /* process foreach with each objects if obj_info is multiple */
        if(Array.isArray(obj_info)){
            return obj_info.forEach(function(c_obj_info){ self.foreachToClone(c_obj_info); });
        }

    //    console.log('foreachToClone', elm_model, obj_info);

        if(obj_info.value == undefined) return;

        // set `use` by curret object
        this.params.useByFullPath(obj_info.path);

        // process with each value in array
        obj_info.value.forEach(function(value, key) { self.cloneElement(elm_model, key); });

        // unset object `use`
        this.params.unsetLastUse();

    };


    /* create element cloned by model element with key */
    This.cloneElement = function(elm_model, key) {

    //    console.log('cloneElement', elm_model, key);

        /* clone original element recursively */
        let elm_instance = elm_model.cloneNode(true);
        
        /* remove 'foreach' attribute because element has been cloned */
        elm_instance.removeAttribute(ATTR_FOREACH);

        /* `use` current key when bind */
        this.params.use(key); 

        /* bind parameters to cloned element */
        this.toElementInternal(elm_instance);

        /* unset current key `use` */
        this.params.unsetLastUse();

        /* append cloned element to same level to original element */
        elm_model.parentNode.appendChild(elm_instance);

    };

    return Binder;
})();
