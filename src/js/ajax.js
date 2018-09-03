/* 
 * AJAXを読み込む関数のJavaScript
 */

let Ajax = {

//  パラメータの情報の入った連想配列に基づき、AJAXでコンテンツを読み込み反映させる
    load: function(page_url, method, params, func_done) {

        console.log('Ajax.load', page_url, method, params);

        $.ajax({
            type: method,
            url: page_url,
            data: params,
            success: func_done,

        //	送信前：AJAXによる読み込みであることの情報を付加する
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            },

        //	受信後、失敗したとき：エラーを表示させる
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