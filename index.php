<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Chess Online</title>
</head>
<body>
    <div id='main'>
    <script src="./move-script.js"></script><!--script file-->
    <p id='test'></p>
    <h1>Chess</h1>
    <p>The board displayed is the board displayed to every user, to reset it press reset<br>
    To move enter the the chess coords of the piece you want to move(ex: a2) and then the coords of the space you want to move it to<br>
    </p>
    <div id='log-thing'>
    <h3>Move log:</h3><p id = 'log'></p></div>
    Piece you want moved: <input type="text" id="start"><br><!--piece to move-->
    Space you want to move it to: <input type="text" id="end"><br><!--place to move to-->
    <button onclick="move();">Move</button>
    <button onclick="populate();">Reset</button>
    
    Team: <select name="color-select" id="color-select"> 
        <option value="white">white</option> 
        <option value="black">black</option> 
    </select>
    <p id="turn"></p>
    <p id="txtHint"></p>
        <table id="board" class="chess-board">
                
                <?php 
                require __DIR__ . '/functions.php';
                //gets the board from the data base
                getBoard() 
                ?>
        </table></div>
</body>
</html>
