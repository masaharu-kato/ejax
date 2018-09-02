/*
 *	JavaScriptの文字列と配列の相互変換処理
 */

const JS_ARRAY_SEPARATOR = '&';
const JS_PAIR_SEPARATOR = '=';

function convertArrayToText(arr) {
	let ret = '';
	let isfirst = true;

	for(let key in arr){
		if(isfirst) isfirst = false; else ret += JS_ARRAY_SEPARATOR;
		ret += key + JS_PAIR_SEPARATOR + arr[key];
	}

	return ret;
}

function convertTextToArray(text) {
	let pairs = text.split(JS_ARRAY_SEPARATOR);
	let ret = {};

	for(let pair of pairs) {
		let vidx = pair.indexOf(JS_PAIR_SEPARATOR);
		if(vidx >= 0) {
			ret[pair.slice(0, vidx)] = pair.slice(vidx+1);
		}else{
			ret[pair] = '';
		}
	}

	return ret;
}