<?php require __DIR__ . '/functions.php';
$x1 = $_GET['x1'];
$y1 = $_GET['y1'];
$x2 = $_GET['x2'];
$y2 = $_GET['y2'];
if(strlen($x1)==1 && strlen($y1)==1 && strlen($x2)==1 && strlen($y2)==1){
    move($x1,$y1,$x2,$y2);
}
echo getBoard();
?>