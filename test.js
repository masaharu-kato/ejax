//  test.js

function run() {

    let element = document.getElementById('prototypes').getElementsByClassName('prototype')[0];
    let params  = JSON.parse(document.getElementById('params').value);
    console.log('params:', params);

    let output = document.getElementById('output');

    output.removeChild(output.firstChild);
    output.appendChild(new Webin.Bind(params).to(element));
    console.log('Done.');

};
