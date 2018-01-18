import axios from 'axios'

class gdax {
    constructor() {
        this.BTCUSD = { asks: [[0]] }
        this.BCHUSD = { asks: [[0]] }
        this.ETHUSD = { asks: [[0]] }
    }

    getBook(left, right) {
        var bookname = left + '-' + right;
        axios.get('https://api.gdax.com/products/' + bookname + '/book')
            .then(response => {
                this[left + right] = response.data
                document.querySelector('#' + bookname + '-price .bid').innerHTML = this[left + right].bids[0][0];
                document.querySelector('#' + bookname + '-price .ask').innerHTML = this[left + right].asks[0][0];
            })
    }

    update() {
        var book = ['BTC', 'USD']
        this.getBook('BTC', 'USD')
        this.getBook('BCH', 'USD')
        this.getBook('ETH', 'USD')

        document.querySelector('#BCH-USD-price .btc').innerHTML = (this.BCHUSD.asks[0][0] / this.BTCUSD.asks[0][0]).toFixed(8);
        document.querySelector('#ETH-USD-price .btc').innerHTML = (this.ETHUSD.asks[0][0] / this.BTCUSD.asks[0][0]).toFixed(8);
        document.querySelector('title').innerHTML = '$' + this.BCHUSD.asks[0][0];
    }
}

class account{
	constructor()
	{
		this.BALANCE = 0
		this.START = 0
	}

	setStart(value){
		this.START = value
	}

	getStart(){
		return this.START
	}

	check(bookCheck){
	var currValue = bookCheck.BTCUSD.asks[0][0]
		if (this.BALANCE < currValue + (currValue * .1)){
		//some shit
			this.BALANCE = currValue
		}
		document.querySelector('#account-Info .accBalance').innerHTML = '$' + this.BALANCE;
	}

}


function update() {

    setTimeout(function () {
        gdax.update()
	    if (QueryString.method !== undefined){
				callMethod();
	    }

	      update()
    }, 2000)
}
function callMethod() {
		if (connection.readyState == 4 && connection.status == 200){
			document.getElementById("accBalance").innerHTML = "blah blah blah";
		};
		connection.open("GET", "methodMap.php?method=" + QueryString.method, true);
		connection.send();
}




gdax = new gdax()
account = new account()
var connection = new XMLHttpRequest();
var QueryString = function () {
	// This function is anonymous, is executed immediately and
	// the return value is assigned to QueryString!
	var query_string = {};
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
		// If first entry with this name
		if (typeof query_string[pair[0]] === "undefined") {
			query_string[pair[0]] = pair[1];
			// If second entry with this name
		} else if (typeof query_string[pair[0]] === "string") {
			var arr = [ query_string[pair[0]], pair[1] ];
			query_string[pair[0]] = arr;
			// If third or later entry with this name
		} else {
			query_string[pair[0]].push(pair[1]);
		}
	}
	return query_string;
} ();

var mapURL = "/gdax-trader-master/static/php/methodMap.php?method="

update()

