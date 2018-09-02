let Person = (function() {

    // コンストラクタ
    let Person = function(name, age) {
        if(!(this instanceof Person)) {
            return new Person(name, age);
        }

        this.name = name;
        this.age  = age;
    }

    const This = Person.prototype;

    // プロトタイプ内でメソッドを定義
    This.setName = function(name) {
        this.name = name;
    }

    This.getName = function() {
        console.log(This);
        console.log(this);
        return "name: " + this.name;
    }

    return Person;

})();

let taro = new Person('太郎', 20);

// プロトタイプ内のメソッド呼び出し
taro.setName('日本太郎');
console.log(taro.getName()); // 日本太郎