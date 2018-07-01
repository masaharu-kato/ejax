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
        let ret = text.replace(self.params_pattern, self.getParams);
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


    self.getParams = function(key) {
        return self.params[key.slice(1)];
    }


    self.params = _params;

//  正規表現のパターンを作成する
    self.params_pattern = new RegExp('\\$(' + (Object.keys(self.params).join("|")) + ')',"gi");

    console.log(self.params_pattern);

};
