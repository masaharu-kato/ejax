//  webin.js

let Webin = {};

Webin.Bind = function(_params) {
    const self = this;

    /* element: target element object */
    self.to = function(element) {
        /* clone node recursively */
        let new_element = element.cloneNode(true);

        /* bind params to new_element */
        self.toElementInternal(new_element);

        return new_element;
    };

    self.toText = function(text) {
     //   console.log('Before:', text);
        if(!text.trim()){
        //    console.log('Skip...');
            return text;
        }
        let ret = text.replace(self.params_pattern, self.getParams);
    //    console.log('After:', ret);
        return ret;
    };

    self.toTextNode = function(node) {
        node.nodeValue = self.toText(node.nodeValue);
    };

    self.toAttributes = function(element) {

        let attrs = element.attributes;
        let n_attrs = attrs.length;
        for(let i=0; i<n_attrs; i++) {
            if(attrs[i].name == 'foreach') continue;
            attrs[i].value = self.toText(attrs[i].value);
        }

    };

    self.toChildNodes = function(element) {

        let nodes = element.childNodes;
        let n_nodes = nodes.length;
        
        for(let i=0; i<n_nodes; i++) {
            let node = nodes[i];
            if(node.nodeType == Node.TEXT_NODE) {
                self.toTextNode(node);
            }
            else if(node.nodeType == Node.ELEMENT_NODE) {
                self.toElement(node);
            }
        }

    };


    
    self.toElement = function(element) {


     //   console.log('toElement begin');

    /* check 'use' attribute */
    
        // let attr_use = element.getAttribute('use');
        // if(attr_use){
        //     /* remove first '$' */
        //     if(attr_use.charAt(0) == '$') attr_use = attr_use.slice(1);

        //     /* bind with params of attr_use */
        //     return new Webin.Bind(self.params[attr_use]).toElementInternal(element);
        // }

    /* check 'foreach' attribute */
        let attr_foreach = element.getAttribute('foreach');

        if(attr_foreach && !element.hasAttribute('foreached')){
        //    console.log('element:',element);

        //    console.log('attr_foreach begin');
            if(attr_foreach.charAt(0) == '$') attr_foreach = attr_foreach.slice(1);

            let carray = self.params[attr_foreach];
            if(typeof(carray) != 'object') throw '$'+attr_foreach+' is not object.';

            let length = carray.length;
        //    console.log('length:', length);
            for(let i=0; i<length; i++) {
                let new_element = element.cloneNode(true);
                new Webin.Bind(carray[i]).toElementInternal(new_element);
                element.parentNode.appendChild(new_element);
                new_element.removeAttribute('foreach');
            //    console.log(new_element);
            }

        //    console.log('element:',element);

            element.parentNode.removeChild(element);

        //    console.log('attr_foreach end');
            return;
        }

        self.toElementInternal(element);


    //    console.log('toElement end');
    };


    self.toElementInternal = function(element) {

    /* bind to attributes of element */
        self.toAttributes(element);

    /* bind to child nodes or elements */
        self.toChildNodes(element);

    };


    self.getParams = function(key) {
        return self.params[key.slice(1)];
    }


    self.params = _params;
    self.params_pattern = null;

    self.generatePattern = function() {

    //  オブジェクトのキー一覧を取得
        let object_keys = Object.keys(self.params);

    //  オブジェクトを降順にソートする
        object_keys.sort(function(a,b){ return a < b ? 1 : -1; });

    //  正規表現のパターンを作成する
        self.params_pattern = new RegExp('\\$(' + (object_keys.join("|")) + ')',"gi");

        console.log(self.params_pattern);
    }

    self.generatePattern();

};
