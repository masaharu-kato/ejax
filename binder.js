
let Binder = (function() {

    /* constructor */
    let Binder = function(params) {
        if(!(this instanceof Binder)) return new Binder(params);

        this.params = new BinderParams(params);
    }



    /* define prototype of this type */
    const This = Binder.prototype;


    /* element: target element object */
    This.to = function(element) {
    
        // clone node recursively
        let new_element = element.cloneNode(true);

        // bind params to new_element
        this.toElement(new_element);

        return new_element;
    };



    /* bind params to element including special attributes */
    This.toElement = function(element) {

        this.params.tryUse(element);

        this.tryForeachTo(element);

        this.toElementInternal(element);

    };



    /* bind params to element itself and its attributes */
    This.toElementInternal = function(element) {

    /* bind to attributes of element */
        this.toAttributes(element);

    /* bind to child nodes or elements */
        this.toChildNodes(element);
    
    };


    /* bind params to attributes of element */
    This.toAttributes = function(element) {

        let attrs = element.attributes;
        let n_attrs = attrs.length;
        for(let i=0; i<n_attrs; i++) {
            let name = attrs[i].name;
            if(name == 'foreach' || name == 'use') continue;
            attrs[i].value = this.toText(attrs[i].value);
        }

    };


    /* bind params to child nodes in element */
    This.toChildNodes = function(element) {

        let nodes = element.childNodes;
        let n_nodes = nodes.length;

    //    console.log('nodes:', nodes);
    //    console.log('n_nodes:', n_nodes);
        
        for(let i=0; i<nodes.length; i++) {
        //    console.log('index:', i);
            let node = nodes[i];
        //    console.log('current node:', node);

            if(node.nodeType == Node.TEXT_NODE) {
                this.toTextNode(node);
            }
            else if(node.nodeType == Node.ELEMENT_NODE) {
                this.toElement(node);
            }

        }

    };




    /* bind params to node */
    This.toTextNode = function(node) {
        node.nodeValue = this.toText(node.nodeValue);
    };



    /* bind params to text and returns it */
    This.toText = function(text) {

        /* remove white spaces at both ends */
        text = text.trim();

        /* replace if text is not empty */
        if(text){
            const self = this;
        //    console.log('self:', self);
            text = text.replace(
                /\$([\w.]+)|\{\$([\w.]+)\}|\$\{([^\}]+)\}/ig,
                function(pathtext) {
                    return self.params.get(pathtext);
                }
            );
        }

        return text;
    };



    /* try `use` path */
    This.tryForeachTo = function(element) {
        if(!element.hasAttribute('foreach')) return;

        console.log('tryForeachTo (2)');

        let path = this.params.getFormattedPath(element.getAttribute('foreach'));
        
        console.log('tryForeachTo (3)', path);
        if(!path) return;

        console.log('tryForeachTo (4)');

        /* run foreach process to element */
        this.foreachTo(element, this.params.getPathValue(path));
    }


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

        if(Array.isArray(obj_info)){
            
            /* process foreach with each objects */
            obj_info.forEach(function(c_obj_info){ self.foreachToClone(c_obj_info); });

            return;

        }

        /* if value not set */
        if(obj_info.value != undefined) return;

        /* set `use` by curret object */
        this.params.useByFullPath(obj_info.path);

        /* process with each value in array */
        obj_info.value.forEach(function(value, key) { self.cloneElement(elm_model, key) });

        /* unset object `use` */
        this.params.unsetLastUse();

    };


    /* create element cloned by model element with key */
    This.cloneElement = function(elm_model, key) {

        /* clone original element recursively */
        let elm_instance = elm_model.cloneNode(true);
        
        /* remove 'foreach' attribute because element has been cloned */
        elm_instance.removeAttribute('foreach');

        /* `use` current key when bind */
        this.params.use(key); 

        /* bind parameters to cloned element */
        this.toElementInternal(elm_instance);

        /* unset current key `use` */
        this.params.unsetLastUse();

        /* append cloned element to same level to original element */
        elm_model.parentNode.appendChild(elm_instance);

    }

    return Binder;
})();
