/* class Ajax */
let Ajax = {

    /**
     * load
     *   load using AJAX
     * 
     * @param {string} page_url : page url to be loaded
     * @param {string} method   : method name to be used for loading
     * @param {Object.<stirng, string>} params : list of parameters to be used for loading
     * @param {Function.<*>:void} : function to be called after loading
     */
    load: function(page_url, method, params, func_done) {

    //    console.log('Ajax.load', page_url, method, params);

    //  JQuery.ajax
        $.ajax({
            type: method,
            url: page_url,
            data: params,
            success: func_done,

        //  Before sending : Add header indicating it is AJAX communication
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            },

        //	If communication fails : display error
            error: function(XMLHttpRequest, textStatus, errorThrown){
            	const message = "Error: Failed to load by Ajax.\n"
              		+ 'Error : ' + errorThrown + "\n"
            		+ 'XMLHttpRequest : ' + XMLHttpRequest.status + "\n"
            		+ 'textStatus : ' + textStatus + "\n"
            		+ 'errorThrown : ' + errorThrown + "\n"
            	;
                console.log(message);
                alert(message);
            }

        });

    },

};