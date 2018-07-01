//  test.js

window.onload = function() {

    let element = document.getElementsByClassName('prototype')[0];
    let params  = JSON.parse(document.getElementById('params').value);
    console.log('params:', params);

    document.body.appendChild(Webin.bind(params).to(elm));
    console.log('Done.');

};
