

<!DOCTYPE>
<html>
<?php require 'dbconfig.php';
session_start(); ?>
<head>
<title>GHTK Quizz</title>
<link rel="stylesheet" href="style.css"> 
</head>
<body>
<center>
<?php 															
	if (isset($_POST['click']) || isset($_GET['start'])) {
		@$_SESSION['clicks'] += 1 ;
		$c = $_SESSION['clicks'];
		if(isset($_POST['userans'])) { 
            $userselected = $_POST['userans'];												
	        $fetchqry2 = "UPDATE `quiz` SET `userans`='$userselected' WHERE `id`=$c-1"; 
	        $result2 = mysqli_query($con,$fetchqry2);
	    }
		  
																	
 	} else {
		$_SESSION['clicks'] = 0;
	}
																
?>
<div class="bump">
    <br>
    <form>
        <?php 
            if($_SESSION['clicks']==0){ 
        ?> 
        <button class="button" name="start" float="left">
        <span>START QUIZ</span>
        </button> 
        <?php } 
        ?>
    </form>
</div>


<form action="" method="post">  				
<table>
<?php 
    if(isset($c)) {   
        $fetchqry = "SELECT * FROM `quiz` where id='$c'"; 
		$result=mysqli_query($con,$fetchqry);
		$num=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC); 
    }
?>
    <tr><td></td></tr> 
    <?php if ($_SESSION['clicks'] > 0 && $_SESSION['clicks'] < 6) { ?>
            <div class="game">
                <div class="root">
                    <div class="top">
                    </div>
                    <div class="main">
                        <div class="question"><?php echo @$row['que']; ?></div>
                        <div class="answerBox">
                            <input required type="submit" class="answer" name="userans" value="<?php echo $row['option 1']; ?>">
                            <input required type="submit" class="answer" name="userans" value="<?php echo $row['option 2']; ?>">
                            <input required type="submit" class="answer" name="userans" value="<?php echo $row['option 3']; ?>">
                            <input required type="submit" class="answer" name="userans" value="<?php echo $row['option 4']; ?>">
                        </div>
                    </div>

                    <div class="bottom">
                        <div class="timeRemaining" id="countdown">Time Remaining</div>
                    </div>
                </div>
            <?php }
            ?>
        <form>
        <?php if ($_SESSION['clicks'] > 5) {
            $qry3 = "SELECT `ans`, `userans` FROM `quiz`;";
            $result3 = mysqli_query($con, $qry3);
            $storeArray = array();
            while ($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
                if ($row3['ans'] == $row3['userans']) {
                    @$_SESSION['score'] += 1;
                }
            }
        ?>
            <div class="Result">
                <div class="resultBox">
                    <div><b>Game Over</b></div>
                    <div>Correct Answer:&nbsp;<?php echo $no = @$_SESSION['score'];
                                                session_unset(); ?>
                    </div>
                    <div>Your Score:&nbsp<?php echo $no * 2; ?></div>
                    <div>
                        <button class="btnPlayAgain">Play Again</button>
                    </div>
                </div>
            </div>
        <?php } ?>
        </form>
</center>
</body>
</html>