/* class Contents */
let Contents = function(elm, page, params){

	let self = this;

	this.data = {};


	/**
	 * pushState
	 *	 save the current state into browser
	 *	 update the URL on the browser and push it to the history
	 *   (this make it possible to transition with the back / forward button on browser)
	 * 
	 * @return {void}
	 */
	this.pushState = function() {

		let data_text = $.param(self.data);

		history.pushState(
			{page:self.page, params:self.data}, '',
			'/' + self.page + (data_text ? '?' + data_text : '')
		);

	};


//  差分パラメタを指定してコンテンツを実行する
	/**
	 * execute
	 *   差分パラメタを指定してコンテンツを実行する
	 * 
	 * @param {string} page_to_run
	 * 		: Page name to be execute
	 * 
	 * @param {Object.<string, string>} params_to_run
	 * 		: List of parameters to be used for execution
	 * 
	 * @param {Function():void} func_done
	 * 		: Proccessing to call after execution
	 * 
	 * @return {void}
	 */
    this.execute = function(page_to_exec, params_to_exec, func_after_exec) {

        Ajax.load(
			page_to_exec,
			'POST',
			$.extend(this.params.get(), params_to_exec),
			func_after_exec
		);
		
	}.bind(this);


	/**
	 * setHTML
	 * 
	 * @param {string} : HTML markup text to set self content
	 * @return {void}
	 */
	this.setHTML = function(data) {
		this.elm.innerHTML = data;
	}.bind(this);


	/**
	 * apply
	 * 
	 * @return {void}
	 */
	this.apply = function() {

	//	ブラウザ上のURL/履歴を変更
		self.pushState();

	//	AJAXで読み込む
		Ajax.load(
			'/.ajax/'+self.page,
			'POST',
			self.data,

		//	読み込み後の処理
			function(data, dataType){

			//	離脱時関数が設定されていればそれを実行
				const ufunc = self.unload[self.page];
				if(typeof(ufunc) == 'function') ufunc();

			//	全体の離脱時間数を実行
				self.unloadOf(self.page);

			//	取得したHTMLを設定
				self.setHTML(data);

			//	全体の読み込み時関数を実行
				self.onloadOf(self.page);

			//	読み込み時関数が設定されていればそれを実行
				const ofunc = self.onload[self.page];
				if(typeof(ofunc) == 'function') ofunc();

			}
		);

	};



	/**
	 * to
	 *   go to new page with page name and difference parameter
	 * 
	 * @param {string} page : page name
	 * @param {Object.<string, string>} diff_params : difference parameter
	 * @return {void}
	 */
	this.to = function(page, diff_params) {
		if(page !== null) self.page = page;
		$.merge(self.data, diff_params);
		self.apply();
	};
	

	/**
	 * setState
	 *   go to new page with page name and full parameter
	 * 
	 * @param {string} page : page name
	 * @param {Object.<string, string>} new_params : new full parameter
	 * @return {void}
	 */
	this.setState = function(page, new_params) {
		if(page !== null) self.page = page;
		self.data = new_params;
		self.apply();
	};
	

	/**
	 * refresh
	 *   refresh current page
	 * 
	 * @return {void}
	 */
	this.refresh = function() {
		self.to(null, {});
	};



//	特定のページから離れた時の処理 (任意の処理を指定する)
	this.unloadOf = function(pagename) {};

//	特定のページを読み込んだ時の処理 (任意の処理を指定する)
	this.onloadOf = function(pagename) {};

//	特定のページから離れた時の処理を、ページ名をキーとする連想配列で指定する
	this.unload = {};

//	特定のページを読み込んだ時の処理を、ページ名をキーとする連想配列で指定する
	this.onload = {};

//	初期化処理
	this.elm = elm;
	this.setState(page, params);





//	GoogleAnalyticsでの集計とともに新しいウィンドウを開く
//	this.newWindowWithGA = function(url) {
//		window.open(url);
//		google_analytics_with_url(url);
//	}

};
