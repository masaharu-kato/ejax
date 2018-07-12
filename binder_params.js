
Ejax.BinderParams = (function() {

    /* constructor */
    let BinderParams = function(params) {
        if(!(this instanceof BinderParams)) return new BinderParams(params);

        this.data = params;
        this.uses = [];
        this.uses_numbers = [];
    }

    /* define prototype of this type */
    const This = BinderParams.prototype;


    /* try `use` path */
    This.tryUse = function(element) {
        if(!element.hasAttribute('use')) return;
        let path = this.getFormattedPath(element.getAttribute('use'));
        if(path) return this.use(path);
    }


    /* `use` path */
    This.use = function(path) {

        /* TODO: Process if path is array here... */

        this.useByFullPath(this.getFullPath(path));
    }


    /* set current level of key */
    This.useByFullPath = function(path) {

        if(Array.isArray(path)){
            path.forEach(function(cpath){ this.uses.path(cpath); });
            this.uses_numbers.push(cpath.length);
        }

        this.uses.push(path);
        this.uses_numbers.push(1);
    }


    /* unset last use */
    This.unsetLastUse = function() {

        /* number of last uses */
        let last_uses_number = this.uses_numbers[this.uses_numbers.length-1];

        /* remove uses `number` times */
        for(let i=0; i<last_uses_number; i++) this.uses.pop();

        /* remove number of last uses */
        this.uses_numbers.pop();

    }


    /* return value at raw path text */
    This.get = function(pathtext) {
        return this.getValue(this.getFormattedPath(pathtext));
    }

    
    /* return value at (relative) path */
    This.getValue = function(path) {

        let ret = this.getPathValue(path);

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
    This.getPathValue = function(path) {

    /*
        // case when relative path is multiple 
        if(typeof(path) == 'object'){

            let results = [];
            path.forEach(function(cpath){
                results.push(this.getPathValue(cpath));
            })
    
            return results;
        }
    */
    //    console.log('EjaxBinderParam::get', path);

        /* try with `using` levels */
        for(let i=this.uses.length-1; i >= 0; i--) {

            let path_full = this.uses[i] + '.' + path;
            let value = this.getByFullPath(path_full);

            if(value != undefined){
                return {
                    path: path_full,
                    value: value
                };
            }

        }

        return {
            path: path,
            value: this.getByFullPath(path)
        };

    };


    /* return formatted path text */
    This.getFormattedPath = function(path) {

        /* remove white spaces at both ends */
        path = path.trim();

        /* remove leading '$' in path */
        if(path.charAt(0) == '$') path = path.slice(1);

        return path;
    };




    /* get value of dot-leveled key (e.g. 'user.address.city') from root in parameters */
    This.getByFullPath = function(path) {

        /* split text of key by levels */
        let keys = path.split('.');

        /* current value */
        let value = this.data;

        /* set and check */
        for(let i=0; i<keys.length; i++) {

            /* returns if specified key is not exists */
            if(value == undefined){
                console.log("[Ejax.Binder] Key '" + path + "' not found.");
                return undefined;
            }

            /* `this` not `This` */
            value = value[keys[i]];

        }

        return value;
    };


    /* retrun full path from relative path */ 
    This.getFullPath = function(path) {

        let ret = this.getPathValue(path);

    /*
        if(Array.isArray(ret)){
            let result = [];
            ret.forEach(function(cret) { result.push(cret.path); })
            return result;
        }
    */

        return ret.path;
    }

    return BinderParams;
})();
