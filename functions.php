<?php
//mysql server login info
$servername = "localhost";
$username = "bcpi";
$password = "temp";
$dbname = "board";

//images for the pieces to display
$pawnW = "<img src='https://upload.wikimedia.org/wikipedia/commons/0/04/Chess_plt60.png'>";
$rookW = "<img src='https://upload.wikimedia.org/wikipedia/commons/5/5c/Chess_rlt60.png'>";
$knightW = "<img src='https://upload.wikimedia.org/wikipedia/commons/2/28/Chess_nlt60.png'>";
$bishopW = "<img src='https://upload.wikimedia.org/wikipedia/commons/9/9b/Chess_blt60.png'>";
$queenW = "<img src='https://upload.wikimedia.org/wikipedia/commons/4/49/Chess_qlt60.png'>";
$kingW = "<img src='https://upload.wikimedia.org/wikipedia/commons/3/3b/Chess_klt60.png'>";
$blank = "";
$pawnB = "<img src='https://upload.wikimedia.org/wikipedia/commons/c/cd/Chess_pdt60.png'>";
$rookB = "<img src='https://upload.wikimedia.org/wikipedia/commons/a/a0/Chess_rdt60.png'>";
$knightB = "<img src='https://upload.wikimedia.org/wikipedia/commons/f/f1/Chess_ndt60.png'>";
$bishopB = "<img src='https://upload.wikimedia.org/wikipedia/commons/8/81/Chess_bdt60.png'>";
$queenB = "<img src='https://upload.wikimedia.org/wikipedia/commons/a/af/Chess_qdt60.png'>";
$kingB = "<img src='https://upload.wikimedia.org/wikipedia/commons/e/e3/Chess_kdt60.png'>";


//returns from the database the piece located at speicfied x,y on the board
function pquery($x,$y){
    global $servername; global $username; global $password; global $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT column$x from board where id=$y";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row["column$x"];
        }
    }
    $conn->close();
}   
//changes the piece at the speicified x & y to the given value
function change($x, $y,$value){
    global $servername; global $username; global $password; global $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "UPDATE board
    SET column$x = '$value'
    WHERE id=$y;
    ";
   
    if ($conn->query($sql) === TRUE) {
      //echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
    
}

//resets the data base to the starting chess board setup
function populate(){
    $board = array(
    array("rookB","knightB","bishopB","queenB","kingB","bishopB","knightB","rookB"),
    array("pawnB","pawnB","pawnB","pawnB","pawnB","pawnB","pawnB","pawnB"),
    array("blank","blank","blank","blank","blank","blank","blank","blank"),
    array("blank","blank","blank","blank","blank","blank","blank","blank"),
    array("blank","blank","blank","blank","blank","blank","blank","blank"),
    array("blank","blank","blank","blank","blank","blank","blank","blank"),
    array("pawnW","pawnW","pawnW","pawnW","pawnW","pawnW","pawnW","pawnW"),
    array("rookW","knightW","bishopW","queenW","kingW","bishopW","knightW","rookW"));
    
    for($i=0;$i<8;$i++){//i=row
    
        for($n=0;$n<8;$n++){
            //echo $board[$i][$n];
            $nvalue = $board[$i][$n];
            change($n+1,$i+1,$nvalue);
    }
    }
}
//moves a piece from (x1, y1) to (x2, y2)
function move($x1,$y1,$x2,$y2){
    $piece = pquery($x1,$y1);
    change($x2,$y2,$piece);
    change($x1,$y1,'blank');
    
}

//returns the html code for the board using information from the database
function getBoard(){
    global $pawnW; 
    global $rookW;
    global $knightW;
    global $bishopW; 
    global $queenW;
    global $kingW;
    global $pawnB; 
    global $rookB;
    global $knightB;
    global $bishopB;
    global $queenB;
    global $kingB;
    global $blank;
    
    global $servername; global $username; global $password; global $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $board = array(
        array("","","","","","","",""),
        array("","","","","","","",""),
        array("","","","","","","",""),
        array("","","","","","","",""),
        array("","","","","","","",""),
        array("","","","","","","",""),
        array("","","","","","","",""),
        array("","","","","","","",""));
    //goes through each row and column in data base and put it into 2d array
    for($n = 1;$n<9;$n++){
        for($i=1;$i<9;$i++){
            $sql = "SELECT column$i from board where id=$n";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $board[$n-1][$i-1] = $row["column$i"];
                }
              
            }
        }
        
    }
    $conn->close();
    //echos the html for the table with the pieces from the 2d array
    echo "<tbody>
                <tr>
                    <th></th>
                    <th>a</th>
                    <th>b</th>
                    <th>c</th>
                    <th>d</th>
                    <th>e</th>
                    <th>f</th>
                    <th>g</th>
                    <th>h</th>
                </tr>
                <tr>
                    <th>8</th>
                    <td class='light' id='a8'>${$board[0][0]}</td>
                    <td class='dark' id='b8'>${$board[0][1]}</td>
                    <td class='light' id='c8'>${$board[0][2]}</td>
                    <td class='dark' id='d8'>${$board[0][3]}</td>
                    <td class='light' id='e8'>${$board[0][4]}</td>
                    <td class='dark' id='f8'>${$board[0][5]}</td>
                    <td class='light' id='g8'>${$board[0][6]}</td>
                    <td class='dark' id='h8'>${$board[0][7]}</td>
                </tr>
                <tr>
                    <th>7</th>
                    <td class='dark' id='a7'>${$board[1][0]}</td>
                    <td class='light' id='a7'>${$board[1][1]}</td>
                    <td class='dark' id='a7'>${$board[1][2]}</td>
                    <td class='light' id='a7'>${$board[1][3]}</td>
                    <td class='dark' id='a7'>${$board[1][4]}</td>
                    <td class='light' id='a7'>${$board[1][5]}</td>
                    <td class='dark' id='a7'>${$board[1][6]}</td>
                    <td class='light' id='a7'>${$board[1][7]}</td>
                </tr>
                <tr>
                    <th>6</th>
                    <td class='light' id='a6'>${$board[2][0]}</td>
                    <td class='dark' id='b6'>${$board[2][1]}</td>
                    <td class='light' id='c6'>${$board[2][2]}</td>
                    <td class='dark' id='d6'>${$board[2][3]}</td>
                    <td class='light' id='e6'>${$board[2][4]}</td>
                    <td class='dark' id='f6'>${$board[2][5]}</td>
                    <td class='light' id='g6'>${$board[2][6]}</td>
                    <td class='dark' id='h6'>${$board[2][7]}</td>
                </tr>
                <tr>
                    <th>5</th>
                   <td class='dark' id='a5'>${$board[3][0]}</td>
                    <td class='light' id='a5'>${$board[3][1]}</td>
                    <td class='dark' id='a5'>${$board[3][2]}</td>
                    <td class='light' id='a5'>${$board[3][3]}</td>
                    <td class='dark' id='a5'>${$board[3][4]}</td>
                    <td class='light' id='a5'>${$board[3][5]}</td>
                    <td class='dark' id='a5'>${$board[3][6]}</td>
                    <td class='light' id='a5'>${$board[3][7]}</td>
                </tr>
                <tr>
                    <th>4</th>
                    <td class='light' id='a4'>${$board[4][0]}</td>
                    <td class='dark' id='b4'>${$board[4][1]}</td>
                    <td class='light' id='c4'>${$board[4][2]}</td>
                    <td class='dark' id='d4'>${$board[4][3]}</td>
                    <td class='light' id='e4'>${$board[4][4]}</td>
                    <td class='dark' id='f4'>${$board[4][5]}</td>
                    <td class='light' id='g4'>${$board[4][6]}</td>
                    <td class='dark' id='h4'>${$board[4][7]}</td>
                </tr>
                <tr>
                    <th>3</th>
                    <td class='dark' id='a3'>${$board[5][0]}</td>
                    <td class='light' id='a3'>${$board[5][1]}</td>
                    <td class='dark' id='a3'>${$board[5][2]}</td>
                    <td class='light' id='a3'>${$board[5][3]}</td>
                    <td class='dark' id='a3'>${$board[5][4]}</td>
                    <td class='light' id='a3'>${$board[5][5]}</td>
                    <td class='dark' id='a3'>${$board[5][6]}</td>
                    <td class='light' id='a3'>${$board[5][7]}</td>
                </tr>
                <tr>
                    <th>2</th>
                    <td class='light' id='a2'>${$board[6][0]}</td>
                    <td class='dark' id='b2'>${$board[6][1]}</td>
                    <td class='light' id='c2'>${$board[6][2]}</td>
                    <td class='dark' id='d2'>${$board[6][3]}</td>
                    <td class='light' id='e2'>${$board[6][4]}</td>
                    <td class='dark' id='f2'>${$board[6][5]}</td>
                    <td class='light' id='g2'>${$board[6][6]}</td>
                    <td class='dark' id='h2'>${$board[6][7]}</td>
                </tr>
                <tr>
                    <th>1</th>
                    <td class='dark' id='a1'>${$board[7][0]}</td>
                    <td class='light' id='a1'>${$board[7][1]}</td>
                    <td class='dark' id='a1'>${$board[7][2]}</td>
                    <td class='light' id='a1'>${$board[7][3]}</td>
                    <td class='dark' id='a1'>${$board[7][4]}</td>
                    <td class='light' id='a1'>${$board[7][5]}</td>
                    <td class='dark' id='a1'>${$board[7][6]}</td>
                    <td class='light' id='a1'>${$board[7][7]}</td>
                </tr>
            </tbody>";}
    
?>
