//  test.js

function run() {

    let element = document.getElementById('prototypes').getElementsByClassName('prototype')[0];
    let params  = JSON.parse(document.getElementById('params').value);
    console.log('params:', params);

    let output = document.getElementById('output');

    let new_element = element.cloneNode(true);

    output.removeChild(output.firstChild);
    output.appendChild(new_element);
    new Webin.Bind(params).toElementInternal(new_element);
    console.log('Done.');

};
