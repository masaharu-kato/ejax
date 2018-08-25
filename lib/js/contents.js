let Contents = function(elm, page, params){

	let self = this;

	this.data = {};

	//	今の状態をブラウザに記録する
	//	ブラウザ上のURLを更新し、履歴に追加する(戻る/進むボタンで遷移できるようにする)
	this.pushState = function() {
	//	console.log('self.page: ', self.page);

		let data_text = $.param(self.data);

		history.pushState(
			{page:self.page, params:self.data}, '',
			'/' + self.page + (data_text ? '?' + data_text : '')
		);

	};

//  差分パラメタを指定してコンテンツを実行する
//	temp_diff_params: 一時的な差分パラメタ
//	func_done: 完了時の関数
    this.run = function(temp_page, temp_diff_params, func_done) {

        return Ajax.load(
			temp_page,
			'POST',
			$.extend(this.params.get(), temp_diff_params),
			func_done
		);
		
	}.bind(this);

	this.setHTML = function(data) {
		return this.elm.innerHTML = data;
	}.bind(this);

	this.apply = function() {

	//	ブラウザ上のURL/履歴を変更
		self.pushState();

	//	AJAXで読み込む
		return Ajax.load(
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

	this.to = function(page, diff_params) {
		if(page !== null) self.page = page;
		$.merge(self.data, diff_params);
		return self.apply();
	};
	
	this.setState = function(page, params) {
		if(page !== null) self.page = page;
		self.data = new_params;
		return self.apply();
	};

	this.refresh = function() {
		return self.to(null, {});
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
