<?php
$servername = "localhost";
$username = "bcpi";
$password = "temp";
$dbname = "board";
function query($x,$y){
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
query(2,7);
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
            echo $board[$i][$n];
            $nvalue = $board[$i][$n];
            change($n+1,$i+1,$nvalue);
    }
    }
}

function move($x1,$y1,$x2,$y2){
    $piece = query($x1,$y1);
    change($x2,$y2,$piece);
    change($x1,$y1,'blank');
    
}
//move(1,1,4,4);
populate();
?>
