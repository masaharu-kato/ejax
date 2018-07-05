//  webin.js
let __EjaxInternal;

__EjaxInternal.Bind = (function() {

    const This = __EjaxInternal.Bind.prototype;


    /* constructor */
    let Bind = function(params) {
        this.params = {};
        this.params.data = params;
        this.params.uses = [];
        this.params.uses_numbers = [];
    }


    /* element: target element object */
    This.to = function(element) {

        /* clone node recursively */
        let new_element = element.cloneNode(true);

        /* bind params to new_element */
        This.toElement(new_element);

        return new_element;
    };

    /* bind params to element including special attributes */
    This.toElement = function(element) {

        This.tryUse(element);

        This.tryForeachTo(element);

        This.toElementInternal(element);

    };



    /* bind params to element itself and its attributes */
    This.toElementInternal = function(element) {

    /* bind to attributes of element */
        This.toAttributes(element);

    /* bind to child nodes or elements */
        This.toChildNodes(element);
    
    };


    /* bind params to attributes of element */
    This.toAttributes = function(element) {

        let attrs = element.attributes;
        let n_attrs = attrs.length;
        for(let i=0; i<n_attrs; i++) {
            if(attrs[i].name == 'foreach') continue;
            attrs[i].value = This.toText(attrs[i].value);
        }

    };


    /* bind params to child nodes in element */
    This.toChildNodes = function(element) {

        let nodes = element.childNodes;
        let n_nodes = nodes.length;
        
        for(let i=0; i<n_nodes; i++) {
            let node = nodes[i];
            if(node.nodeType == Node.TEXT_NODE) {
                This.toTextNode(node);
            }
            else if(node.nodeType == Node.ELEMENT_NODE) {
                This.toElement(node);
            }
        }

    };




    /* bind params to node */
    This.toTextNode = function(node) {
        node.nodeValue = This.toText(node.nodeValue);
    };



    /* bind params to text and returns it */
    This.toText = function(text) {

        /* remove white spaces at both ends */
        let text = text.trim();

        /* replace if text is not empty */
        if(text) text = text.replace(/\$([\w.]+)|\{\$([\w.]+)\}|\$\{([^\}]+)\}/ig, This.getPathValue);

        return text;
    };



    /* try `use` path */
    This.tryForeachTo = function(element) {
        if(!element.hasAttribute('foreach')) return;

        let path;
        if(!(path = This.params.getFormattedPath(raw_path_text))) return;

        /* run foreach process to element */
        This.foreachTo(element, This.params.getPathValue(path));
    }


    /* generate elements from prototype with array of object  */
    This.foreachTo = function(elm_model, obj_info) {

        foreachToClone(elm_model, obj_info);

        /* remove original element */
        elm_model.parentNode.removeChild(elm_model);

    };


    /* foreach internal process */
    This.foreachToClone = function(elm_model, obj_info) {
        /* obj_info has .path .value attributes */

        if(Array.isArray(obj_info)){
            
            /* process foreach with each objects */
            obj_info.forEach(function(c_obj_info){ This.foreachToClone(c_obj_info); });

            return;

        }

        /* if value not set */
        if(obj_info.value != undefined) return;

        /* set `use` by curret object */
        This.params.useByFullPath(obj_info.path);

        /* process with each value in array */
        array.forEach(function(value, key) { This.cloneElement(elm_model, key) });

        /* unset object `use` */
        This.params.unsetLastUse();

    };


    /* create element cloned by model element with key */
    This.cloneElement = function(elm_model, key) {

        /* clone original element recursively */
        let elm_instance = elm_model.cloneNode(true);
        
        /* remove 'foreach' attribute because element has been cloned */
        elm_instance.removeAttribute('foreach');

        /* `use` current key when bind */
        This.params.use(key); 

        /* bind parameters to cloned element */
        This.toElementInternal(elm_instance);

        /* unset current key `use` */
        This.params.unsetLastUse();

        /* append cloned element to same level to original element */
        elm_model.parentNode.appendChild(elm_instance);

    }



    /* try `use` path */
    This.params.tryUse = function(element) {
        if(!element.hasAttribute('use')) return;
        let path;
        if(path = This.params.getFormattedPath(element.getAttribute('use'))) return This.params.use(path);
    }


    /* `use` path */
    This.params.use = function(path) {

        /* TODO: Process if path is array here... */

        This.params.useByFullPath(This.params.getFullPath(path));
    }


    /* set current level of key */
    This.params.useByFullPath = function(path) {

        if(Array.isArray(path)){
            path.forEach(function(cpath){ This.params.uses.path(cpath); });
            This.params.uses_numbers.push(cpath.length);
        }

        This.params.uses.push(path);
        This.params.uses_numbers.push(1);
    }


    /* unset last use */
    This.params.unsetLastUse = function() {

        /* number of last uses */
        let last_uses_number = This.params.uses_numbers[This.params.uses_numbers.length-1];

        /* remove uses `number` times */
        for(let i=0; i<last_uses_number; i++) This.params.uses.pop();

        /* remove number of last uses */
        This.params.uses_numbers.pop();

    }




    /* get value of dot-leveled key (e.g. 'user.address.city') from root in parameters */
    This.params.getByFullPath = function(path) {

        /* split text of key by levels */
        let keys = path.split('.');

        /* value of result */
        let value;

        /* set and check */
        for(let i=0; i<keys.length; i++) {

            /* `this` not `This` */
            value = this.params.data[keys[i]];

            /* returns if specified key is not exists */
            if(value == undefined){
                return undefined;
            }

        }

        return value;
    };


    /* retrun full path from relative path */ 
    This.params.getFullPath = function(path) {

        let ret = This.params.getPathValue(path);

    /*
        if(Array.isArray(ret)){
            let result = [];
            ret.forEach(function(cret) { result.push(cret.path); })
            return result;
        }
    */

        return ret.path;
    }

    
    /* return value at (relative) path */
    This.params.getValue = function(path) {

        let ret = This.params.getPathValue(path);

    /*
        if(Array.isArray(ret)){
            let result = [];
            ret.forEach(function(cret) { result.push(cret.value); })
            return result;
        }
    */

        return ret.value;
    }


    /* get value in parameters with levels specified in 'use' */
    This.params.getPathValue = function(path) {

    /*
        // case when relative path is multiple 
        if(typeof(path) == 'object'){

            let results = [];
            path.forEach(function(cpath){
                results.push(This.params.getPathValue(cpath));
            })
    
            return results;
        }
    */

        /* try with `using` levels */
        for(let i=This.params.uses.length-1; i >= 0; i--) {

            let path_full = This.params.uses[i] + '.' + path;
            let value = This.params.getByRoot(path_full);

            if(value != undefined){
                return {
                    path: path_full,
                    value: value
                };
            }

        }

        return This.params.getByFullPath(path);
    };








    /* return formatted path text */
    This.params.getFormattedPath = function(path) {

        /* remove white spaces at both ends */
        path = trim(path);

        /* remove leading '$' in path */
        if(path.charAt(0) == '$') path = path.slice(1);

        return path;
    };


    return Bind;
})();