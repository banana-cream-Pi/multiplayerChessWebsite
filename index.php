<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Chess Online</title>
</head>
<body>
    <?php 
        require __DIR__ . '/functions.php';
        
?>
<h1 id="Hello-there"></h1>
<script>
    function getPiece(x1, y1) {
    	let p = new Promise((resolve, reject) => {
    		var xmlhttp = new XMLHttpRequest();
    		xmlhttp.onreadystatechange = function () {
    			if (this.readyState == 4 && this.status == 200) {
    				var m = this.responseText;
    				resolve(m);
    			}
    		};
    		xmlhttp.open("GET", "getPiece.php?x1=" + x1 + "&y1=" + y1, true);
    		xmlhttp.send();
    	});
    
    	var respo = p
    		.then((message) => {
    			return message;
    		})
    		.catch((message) => {
    			console.log(message);
    		});
    	return respo;
    }
    function invalid(msg) {
    	alert("Invalid Move: " + msg);
    }
    async function validate(x1, y1, x2, y2) {
        document.getElementById("Hello-there").innerHTML="Hello there, who are though?"
    	var x = await getPiece(x1, y1);
    	if (x == "blank") {
    		invalid("Can't move empty space");
    		return false;
    	}
    	var y = await getPiece(x2, y2);
    
    	var color = x.slice(-1);
    	var ycolor = y.slice(-1);
    	x = x.substr(0, x.length - 1);
    	console.log(x, y, color, ycolor);
    	if (ycolor == color) {
    		invalid("Cannont take your own piece");
    		return false;
    	}
    
    	if (x == "pawn") {
    		//console.log(color);
    		if (y1 == y2) {
    			invalid("Cannot move horizontally");
    		}
    		if (color == "W") {
    			console.log("white");
    			if ((x1 == x2 && y1 == y2) || y2 > y1) {
    				//checks that the space is not the same or behind the pawn
    				invalid("Cannot Move Backwards");
    				return false;
    			}
    			if ((y2 < y1 - 1 && y1 != 7) || y2 < y1 - 2) {
    				invalid(
    					"You can only move more than one space the first time the pawn has moved"
    				);
    				return false;
    			} //makes sure it can not move more than one space or two spaces on the first turn
    		} else if (color == "B") {
    			//console.log('black');
    			if ((x1 == x2 && y1 == y2) || y2 < y1) {
    				//checks that the space is not the same or behind the pawn
    				invalid("Cannot Move Backwards");
    				return false;
    			}
    			if ((y2 > y1 + 1 && y1 != 2) || y2 > y1 + 2) {
    				invalid(
    					"You can only move more than one space the first time the pawn has moved"
    				);
    				return false;
    			}
    		}
    		if (y != "blank" && x2 == x1) {
    			invalid("You may only take pieces diagonally as a pawn");
    			return false;
    		} else if (y == "blank" && x2 != x1) {
    			invalid(
    				"You may only move diagonally when taking a piece as a pawn"
    			);
    			return false;
    		} else if ((x2 == x1 + 1 || x2 == x1 - 1) && y != "blank" && y1 != y2) {
    			return true;
    		}
    	} else if (x == "rook") {
    		console.log("rook");
    		if (x2 != x1 && y2 != y1) {
    			invalid("must move vertically or horizontally");
    			return false;
    		} else if ((x2 != x1 && y2 == y1) || (x2 == x1 && y2 != y1)) {
    			if (x2 != x1 && y2 == y1) {
    				if (x2 > x1) {
    					for (var i = x1 + 1; i != x2; i++) {
    						if ((await getPiece(i, y1)) != "blank") {
    							//fix this: this sucks
    							invalid("A piece is in your path");
    							return false;
    						}
    					}
    				} else if (x2 < x) {
    					for (i = x1 - 1; i != x2; i--) {
    						if ((await getPiece(i, y1)) != "blank") {
    							//fix this: this sucks
    							invalid("A piece is in your path");
    							return false;
    						}
    					}
    				} else {
    					invalid("um...idk");
    					return false;
    				}
    			} else {
    				console.log("k..man");
    				if (y2 > y1) {
    					console.log("uno");
    					for (i = y1 + 1; i != y2; i++) {
    						if ((await getPiece(x1, i)) != "blank") {
    							//fix this: this sucks
    							invalid("A piece is in your path");
    							return false;
    						}
    					}
    				} else if (y2 < y1) {
    					console.log("dos");
    					for (i = y1 - 1; i != y2; i--) {
    						console.log(i);
    						if ((await getPiece(x1, i)) != "blank") {
    							//fix this: this sucks
    							invalid("A piece is in your path");
    							return false;
    						}
    					}
    				} else {
    					invalid("um...idk2");
    					return false;
    				}
    			}
    		}
    	} //end of rook
    	else if (x == "knight") {
    		console.log("knight");
    		if (
    			(y2 == y1 + 2 && x2 == x1 + 1) ||
    			(y2 == y1 + 2 && x2 == x1 - 1) ||
    			(y2 == y1 - 2 && x2 == x1 + 1) ||
    			(y2 == y1 - 2 && x2 == x1 - 1) | (x2 == x1 + 2 && y2 == y1 + 1) ||
    			(x2 == x1 + 2 && y2 == y1 - 1) ||
    			(x2 == x1 - 2 && y2 == y1 + 1) ||
    			(x2 == x1 - 2 && y2 == y1 - 1)
    		) {
    			return true;
    		} else {
    			invalid("Knights can not move like that");
    			return false;
    		}
    	} else if (x == "bishop") {
    		//must fix block check super ineffciant with calls
    		if (
    			Math.max(y1, y2) - Math.min(y1, y2) !=
    			Math.max(x1, x2) - Math.min(x1, x2)
    		) {
    			invalid("Bishops must move diagonally");
    			return false;
    		} else {
    			if (x2 > x1) {
    				for (i = x1 + 1; i != x2; i++) {
    					if (y2 > y1) {
    						for (var j = y1 + 1; j != y2; j++) {
    							if ((await getPiece(j, i)) != "blank") {
    								invalid("Piece in your path");
    								return false;
    							}
    						}
    					} else {
    						for (j = y1 - 1; j != y2; j--) {
    							if ((await getPiece(j, i)) != "blank") {
    								invalid("Piece in your path");
    								return false;
    							}
    						}
    					}
    				}
    			} else {
    				for (i = x1 - 1; i != x2; i--) {
    					if (y2 > y1) {
    						for (j = y1 + 1; j != y2; j++) {
    							if ((await getPiece(j, i)) != "blank") {
    								invalid("Piece in your path");
    								return false;
    							}
    						}
    					} else {
    						for (j = y1 - 1; j != y2; j--) {
    							if ((await getPiece(j, i)) != "blank") {
    								invalid("Piece in your path");
    								return false;
    							}
    						}
    					}
    				}
    			}
    		}
    	} //end of bishop
    	if (x == "king") {
    		if (y2 > y1 + 1 || x2 > x1 + 1 || y2 < y1 - 1 || x2 < x1 - 1) {
    			invalid("Kings may only move one space in any direction");
    			return false;
    		}
    	}
    	if (x == "queen") {
    		if (
    			Math.max(y1, y2) - Math.min(y1, y2) !=
    				Math.max(x1, x2) - Math.min(x1, x2) &&
    			x2 != x1 &&
    			y2 != y1
    		) {
    			invalid("Queens may only move horizontally or diagonally");
    			return false;
    		} else if ((x2 != x1 && y2 == y1) || (x2 == x1 && y2 != y1)) {
    			//if valid rook
    			if (x2 != x1 && y2 == y1) {
    				if (x2 > x1) {
    					for (i = x1 + 1; i != x2; i++) {
    						if ((await getPiece(i, y1)) != "blank") {
    							//cout << "invalid blockedX1" << endl;
    							invalid("Piece in your pathR1");
    							return false;
    						}
    					}
    				} else if (x2 < x1) {
    					for (i = x1 - 1; i != x2; i--) {
    						if ((await getPiece(i, y1)) != "blank") {
    							console.log(await getPiece(y1, i), y1, i);
    							invalid("Piece in your pathR2");
    							return false;
    						}
    					}
    				} else {
    					invalid("idk-funky");
    				}
    			} else {
    				if (y2 > y1) {
    					for (i = y1 + 1; i != y2; i++) {
    						if ((await getPiece(x1, i)) != "blank") {
    							invalid("Piece in your pathR3");
    							return false;
    						}
    					}
    				} else if (y2 < y1) {
    					for (i = y1 - 1; i != y2; i--) {
    						if ((await getPiece(x1, i)) != "blank") {
    							invalid("Piece in your pathR4");
    							return false;
    						}
    					}
    				} else {
    					invalid("Mystery failure, oooo");
    					return false;
    				}
    			}
    		} else if (
    			Math.max(y1, y2) - Math.min(y1, y2) ==
    			Math.max(x1, x2) - Math.min(x1, x2)
    		) {
    			if (x2 > x1) {
    				for (i = x1 + 1; i != x2; i++) {
    					if (y2 > y1) {
    						for (j = y1 + 1; j != y2; j++) {
    							if ((await getPiece(j, i)) != "blank") {
    								invalid("Piece in your pathb1");
    								return false;
    							}
    						}
    					} else {
    						for (j = y1 - 1; j != y2; j--) {
    							if ((await getPiece(j, i)) != "blank") {
    								invalid("Piece in your pathb2");
    								return false;
    							}
    						}
    					}
    				}
    			} else {
    				for (i = x1 - 1; i != x2; i--) {
    					if (y2 > y1) {
    						for (j = 1 + 1; j != y2; j++) {
    							if ((await getPiece(j, i)) != "blank") {
    								invalid("Piece in your pathb3");
    								return false;
    							}
    						}
    					} else {
    						for (j = y1 - 1; j != y2; j--) {
    							if ((await getPiece(j, i)) != "blank") {
    								invalid("Piece in your pathb4");
    								return false;
    							}
    						}
    					}
    				}
    			}
    		}
    	}
    	return true;
    }
    //validate(2,2,3,3);
    //ntoc(notation to coord) function returns x or y coordinate depending on whether a = 1 or a = 2. Input chess notation(ex: a2) for note
    function notation_check(input) {
    	let regex = /[a-h][1-8]/;
    	return regex.test(input.toLowerCase());
    }
    
    function ntoc(note, a) {
    	var columns = ["a", "b", "c", "d", "e", "f", "g", "h"];
    	var rows = [8, 7, 6, 5, 4, 3, 2, 1];
    	var x1 = note[0].toLowerCase();
    	var x2 = note[1];
    
    	for (var i in columns) {
    		if (x1 == columns[i]) {
    			x1 = parseInt(i) + 1;
    		}
    	}
    
    	for (var i in rows) {
    		if (x2 == rows[i]) {
    			x2 = parseInt(i) + 1;
    
    			break;
    		}
    	}
    	console.log(eval("x" + a));
    	return eval("x" + a);
    }
    
    //function uses ajax magic to call the move function from functions.php which returns the board
    async function move() {
    	var start = document.getElementById("start").value.toLowerCase();
    	var end = document.getElementById("end").value.toLowerCase();
    	console.log(start, end);
    	if (start == "") {
    		alert("Must enter piece to move");
    		return false;
    	} else if (end == "") {
    		alert("Must enter space you want to move it to");
    		return false;
    	} else if (
    		!notation_check(start) ||
    		!notation_check(end) ||
    		start.length != 2 ||
    		end.length != 2
    	) {
    		alert("Invalid notation");
    		return false;
    	} else if (start == end) {
    		alert("You can't move a piece to a place that it already is");
    		return false;
    	}
    
    	var x1 = ntoc(document.getElementById("start").value, 1);
    	var y1 = ntoc(document.getElementById("start").value, 2);
    	var x2 = ntoc(document.getElementById("end").value, 1);
    	var y2 = ntoc(document.getElementById("end").value, 2);
    	var columns = ["a", "b", "c", "d", "e", "f", "g", "h"];
    	if (await validate(x1, y1, x2, y2)) {
    		var xmlhttp = new XMLHttpRequest();
    		xmlhttp.onreadystatechange = function () {
    			if (this.readyState == 4 && this.status == 200) {
    				document.getElementById("board").innerHTML = this.responseText;
    			}
    		};
    		xmlhttp.open(
    			"GET",
    			"move.php?x1=" + x1 + "&y1=" + y1 + "&x2=" + x2 + "&y2=" + y2,
    			true
    		);
    		xmlhttp.send();
    	} else {
    		return false;
    	}
    }
    //calls the populate function which resets the board to the opening position
    function populate(id) {
    	var xmlhttp = new XMLHttpRequest();
    	xmlhttp.onreadystatechange = function () {
    		if (this.readyState == 4 && this.status == 200) {
    			document.getElementById("board").innerHTML = this.responseText;
    		}
    	};
    	xmlhttp.open("GET", "populate.php", true);
    	xmlhttp.send();
    }

</script>
<p id='test'></p>
<h1>Chess</h1>
<p>The board displayed is the board displayed to every user, to reset it press reset<br>
To move enter the the chess coords of the piece you want to move(ex: a2) and then the coords of the space you want to move it to<br>
move verification not yet implemented</p>
Piece you want moved: <input type="text" id="start"><br>
Space you want to move it to: <input type="text" id="end"><br>
<button onclick="move();">Move</button>
<button onclick="populate();">Reset</button>
<p id="txtHint"></p>
    <table id="board" class="chess-board">
            
            <?php 
            //gets the board from the data base
            getBoard() 
            ?>
        </table>
</body>
</html>
