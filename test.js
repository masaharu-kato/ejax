//  test.js

function run() {

    let element = document.getElementsByClassName('prototype')[0];
    let params  = JSON.parse(document.getElementById('params').value);
    console.log('params:', params);

    document.body.appendChild(new Webin.Bind(params).to(element));
    console.log('Done.');

};
