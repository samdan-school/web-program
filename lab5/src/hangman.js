// Style
import './hangman.scss';

// HTML
var hImage = document.getElementById("image");
var wordDiv = document.getElementById("word");
var start = document.getElementById("start");

var alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

var fruits = ['apple', 'banana', 'pineapple'];
var times = [10, 12, 15];

var nth = 0;
var oth = 0;
var lives = 0;
var gameState = false;
var guess = 0;
var skip = '';


insertInputValues(wordDiv, fruits[nth].length);

start.addEventListener('click', () => {
	countdown(times[nth], (sec, interval) => {
		interval.clearInterval();
		if (oth != nth) {
			oth = nth;
			countdown(times[nth], (sec, interval) => {
				interval.clearInterval();
				if (oth != nth) {
					oth = nth;

				}
			}, () => {
				alert("You Lose!");
				location.reload();
			});
			return;
		}
	}, () => {
		alert("You Lose!");
		location.reload();
	});

	document.onkeypress = function (evt) {
		evt = evt || window.event;
		var charCode = evt.keyCode || evt.which;
		var charStr = String.fromCharCode(charCode);
		if (alphabet.indexOf(charStr) > -1) {
			if (skip.indexOf(charStr) > -1) {
				console.log(skip);
			}
			else if (checkCharInWord(charStr, fruits[nth])) {
				guess += getOccurrence(fruits[nth], charStr);
				skip += charStr;
				console.log("g " + guess);
				console.log(fruits[nth].length);
				if (guess == fruits[nth].length) {
					nth++;
					guess = 0;
					skip = '';
					console.log("n " + nth);
					if (nth == fruits.length) {
						alert("WIN!");
						location.reload();
					}
					insertInputValues(wordDiv, fruits[nth].length);
				}
			} else {
				lives++;
				var src = hImage.src.split('.')[0].split('/').splice(-1)[0];
				var num = src[src.length - 1];
				num++;
				var newSrc = '../dist/images/' + src.slice(0, src.length - 1) + num + '.png';
				hImage.src = newSrc;
				if (lives == 5) {
					alert("GAME OVER!");
					location.reload();
				}
			}
		}
	};
});

function checkCharInWord(char, word) {
	if (word.indexOf(char) > -1) {
		return true;
	}
	return false;
}

function getOccurrence(array, value) {
	var n = -1;
	var i = -1;
	do {
		n++;
		i = array.indexOf(value, i + 1);
		if (i > -1) {
			var input = document.querySelector("input.i_" + i);
			input.value = value;
		}
	} while (i >= 0);

	return n;
}

function insertInputValues(el, times) {
	var inputs = '';
	for (var i = 0; i < times; i++) {
		inputs += `<input disabled type='text' lenght=1 class="i_${i}" />`;
	}
	el.innerHTML = inputs;
}

function countdown(sec, tick, done) {
	var interval = setInterval(function () {
		if (sec <= 0) {
			clearInterval(interval);
			done();
		} else {
			tick(sec, interval);
			sec--;
		}
	}, 1000)
}