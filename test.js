//  test.js

// function run() {

    let element = document.getElementById('prototypes').getElementsByClassName('prototype')[0];
    let params  = JSON.parse(document.getElementById('params').value);
    console.log('params:', params);

    let output = document.getElementById('output');

//    let new_element = element.cloneNode(true);

//    output.removeChild(output.firstChild);
//    output.appendChild(new_element);
//    new __EjaxInternal.Bind(params).to(new_element);

    let binder = new Ejax.Binder(params);

    output.removeChild(output.firstChild);

    let new_element = binder.to(element);
    output.appendChild(new_element);

    console.log(new_element);

    console.log('Done.');

// };

//window.onload = function() {
//    run();
//};
