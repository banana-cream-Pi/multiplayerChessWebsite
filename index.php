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
<script>
    //ntoc(notation to coord) function returns x or y coordinate depending on whether a = 1 or a = 2. Input chess notation(ex: a2) for note
    function notation_check(input){
        
        let regex = /[a-h][1-8]/;
        return regex.test(input.toLowerCase());
}
    
    function ntoc(note,a){
        var columns = ['a','b','c','d','e','f','g','h'];
        var rows = [8,7,6,5,4,3,2,1];
        var x1=note[0].toLowerCase();
        var x2=note[1];
        
        for(var i in columns){
            if(x1==columns[i]){
                x1=parseInt(i)+1;
            }
            
        }
        
        for(var i in rows){
            if(x2==rows[i]){
                x2=parseInt(i)+1;
               
                break;
            }
        }
        console.log(eval('x'+a));
        return eval('x'+a);
    }
    //function uses ajax magic to call the move function from functions.php which returns the board
    function move() {
        
        var start = document.getElementById('start').value.toLowerCase();
        var end = document.getElementById('end').value.toLowerCase();
        console.log(start,end);
        if(start ==""){
            alert("Must enter piece to move");
            return false;
        }
        else if(end ==""){
            alert("Must enter space you want to move it to");
            return false;
        }else if(!notation_check(start)||!notation_check(end)||start.length!=2||end.length!=2){
            alert("Invalid notation");
            return false;
        }else if(start==end){
            alert("You can't move a piece to a place that it already is");
            return false;
        }
        
        var x1 =ntoc(document.getElementById('start').value,1);
        var y1 =ntoc(document.getElementById('start').value,2);
        var x2 =ntoc(document.getElementById('end').value,1);
        var y2 =ntoc(document.getElementById('end').value,2);
        var columns = ['a','b','c','d','e','f','g','h'];
        console.log(x1, y1, x2, y2);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("board").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "move.php?x1=" + x1+"&y1="+y1+"&x2="+x2+"&y2="+y2, true);
        xmlhttp.send();
      
    }
    //calls the populate function which resets the board to the opening position
    function populate(id){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("board").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "populate.php", true);
        xmlhttp.send();
    }
</script>
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
