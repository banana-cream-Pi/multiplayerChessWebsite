<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <!--<script src="jquery-3.7.1.min.js"></script>-->
</head>
<body>
    <?php 
    $servername = "localhost";
$username = "bcpi";
$password = "temp";
$dbname = "board";

// Create connection
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
?>


    <table class="chess-board">
            <tbody>
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
                    <td class="light" id="a8"><?php echo ${$board[0][0]} ?></td>
                    <td class="dark" id="b8"><?php echo ${$board[0][1]} ?></td>
                    <td class="light" id="c8"><?php echo ${$board[0][2]} ?></td>
                    <td class="dark" id="d8"><?php echo ${$board[0][3]} ?></td>
                    <td class="light" id="e8"><?php echo ${$board[0][4]} ?></td>
                    <td class="dark" id="f8"><?php echo ${$board[0][5]} ?></td>
                    <td class="light" id="g8"><?php echo ${$board[0][6]} ?></td>
                    <td class="dark" id="h8"><?php echo ${$board[0][7]} ?></td>
                </tr>
                <tr>
                    <th>7</th>
                    <td class="dark" id="a7"><?php echo ${$board[1][0]} ?></td>
                    <td class="light" id="a7"><?php echo ${$board[1][1]} ?></td>
                    <td class="dark" id="a7"><?php echo ${$board[1][2]} ?></td>
                    <td class="light" id="a7"><?php echo ${$board[1][3]} ?></td>
                    <td class="dark" id="a7"><?php echo ${$board[1][4]} ?></td>
                    <td class="light" id="a7"><?php echo${$board[1][5]} ?></td>
                    <td class="dark" id="a7"><?php echo ${$board[1][6]} ?></td>
                    <td class="light" id="a7"><?php echo ${$board[1][7]} ?></td>
                </tr>
                <tr>
                    <th>6</th>
                    <td class="light" id="a6"><?php echo ${$board[2][0]} ?></td>
                    <td class="dark" id="b6"><?php echo ${$board[2][1]} ?></td>
                    <td class="light" id="c6"><?php echo ${$board[2][2]} ?></td>
                    <td class="dark" id="d6"><?php echo ${$board[2][3]} ?></td>
                    <td class="light" id="e6"><?php echo ${$board[2][4]} ?></td>
                    <td class="dark" id="f6"><?php echo ${$board[2][5]} ?></td>
                    <td class="light" id="g6"><?php echo ${$board[2][6]} ?></td>
                    <td class="dark" id="h6"><?php echo ${$board[2][7]} ?></td>
                </tr>
                <tr>
                    <th>5</th>
                   <td class="dark" id="a5"><?php echo ${$board[3][0]} ?></td>
                    <td class="light" id="a5"><?php echo ${$board[3][1]} ?></td>
                    <td class="dark" id="a5"><?php echo ${$board[3][2]} ?></td>
                    <td class="light" id="a5"><?php echo ${$board[3][3]} ?></td>
                    <td class="dark" id="a5"><?php echo ${$board[3][4]} ?></td>
                    <td class="light" id="a5"><?php echo ${$board[3][5]} ?></td>
                    <td class="dark" id="a5"><?php echo ${$board[3][6]} ?></td>
                    <td class="light" id="a5"><?php echo ${$board[3][7]} ?></td>
                </tr>
                <tr>
                    <th>4</th>
                    <td class="light" id="a4"><?php echo ${$board[4][0]} ?></td>
                    <td class="dark" id="b4"><?php echo ${$board[4][1]} ?></td>
                    <td class="light" id="c4"><?php echo ${$board[4][2]} ?></td>
                    <td class="dark" id="d4"><?php echo ${$board[4][3]} ?></td>
                    <td class="light" id="e4"><?php echo ${$board[4][4]} ?></td>
                    <td class="dark" id="f4"><?php echo ${$board[4][5]} ?></td>
                    <td class="light" id="g4"><?php echo ${$board[4][6]} ?></td>
                    <td class="dark" id="h4"><?php echo ${$board[4][7]} ?></td>
                </tr>
                <tr>
                    <th>3</th>
                    <td class="dark" id="a3"><?php echo ${$board[5][0]} ?></td>
                    <td class="light" id="a3"><?php echo ${$board[5][1]} ?></td>
                    <td class="dark" id="a3"><?php echo ${$board[5][2]} ?></td>
                    <td class="light" id="a3"><?php echo ${$board[5][3]} ?></td>
                    <td class="dark" id="a3"><?php echo ${$board[5][4]} ?></td>
                    <td class="light" id="a3"><?php echo ${$board[5][5]} ?></td>
                    <td class="dark" id="a3"><?php echo ${$board[5][6]} ?></td>
                    <td class="light" id="a3"><?php echo ${$board[5][7]} ?></td>
                </tr>
                <tr>
                    <th>2</th>
                    <td class="light" id="a2"><?php echo ${$board[6][0]} ?></td>
                    <td class="dark" id="b2"><?php echo ${$board[6][1]} ?></td>
                    <td class="light" id="c2"><?php echo ${$board[6][2]} ?></td>
                    <td class="dark" id="d2"><?php echo ${$board[6][3]} ?></td>
                    <td class="light" id="e2"><?php echo ${$board[6][4]} ?></td>
                    <td class="dark" id="f2"><?php echo ${$board[6][5]} ?></td>
                    <td class="light" id="g2"><?php echo ${$board[6][6]} ?></td>
                    <td class="dark" id="h2"><?php echo ${$board[6][7]} ?></td>
                </tr>
                <tr>
                    <th>1</th>
                    <td class="dark" id="a1"><?php echo ${$board[7][0]} ?></td>
                    <td class="light" id="a1"><?php echo ${$board[7][1]} ?></td>
                    <td class="dark" id="a1"><?php echo ${$board[7][2]} ?></td>
                    <td class="light" id="a1"><?php echo ${$board[7][3]} ?></td>
                    <td class="dark" id="a1"><?php echo ${$board[7][4]} ?></td>
                    <td class="light" id="a1"><?php echo ${$board[7][5]} ?></td>
                    <td class="dark" id="a1"><?php echo ${$board[7][6]} ?></td>
                    <td class="light" id="a1"><?php echo ${$board[7][7]} ?></td>
                </tr>
            </tbody>
        </table>
</body>
</html>
