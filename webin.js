//  webin.js

let Webin = {};

Webin.Bind = function(_params) {
    const self = this;

    /* element: target element object */
    self.to = function(element) {
        /* clone node recursively */
        let new_element = element.cloneNode(true);

        /* bind params to new_element */
        self.toElement(new_element);

        return new_element;
    };

    self.toText = function(text) {
        console.log('置換前:', text);
        let ret = text.replace(self.params_regexp);
        console.log('置換後:', ret);
        return ret;
    };

    self.toTextNode = function(node) {
        node.nodeValue = self.toText(node.nodeValue);
    };

    self.toAttributes = function(element) {

        let attrs = element.attributes;
        let n_attrs = attrs.length;
        for(let i=0; i<n_attrs; i++) {
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

    /* bind to attributes of element */
        self.toAttributes(element);

    /* bind to child nodes or elements */
        self.toChildNodes(element);

    };


    self.params_regexp = [];

//  正規表現の置換一覧表を作成する
    for(key in _params) {
       self.params_regexp.push([
            new RegExp('\\$'+key, 'gi'), _params[key]
       ]);
    }

    console.log(self.params_regexp);

};
