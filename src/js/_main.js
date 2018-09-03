/*
 * 最初に実行されるJavaScript (_main.phpで読み込まれる)
 */

let main = null;
let forms = {};

//	ブラウザの戻る/進むが押されたときの処理
window.onpopstate = function(event){

//	初回アクセス時
    if(!event.state) return;

    main.setState(event.state.page, event.state.params);
}

//	ページ読み込み時の処理
window.onload = function() {

    

}
