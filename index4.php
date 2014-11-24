<!DOCTYPE html>
<html>
    <head>
		<?php require_once("includes/connection.php") ?>
		<?php require_once("includes/functions.php") ?>
		<?php global $docID, $docNumber	?>
		<?php 
			session_start();
			$total_Docs=5;
			if((isset($_GET["docID"]))){
				$docID= $_GET["docID"];
				if($docID>=6){
					$docID= 1;
					$docNumber= 1;	
				}
			}
			else{
				unset($_SESSION['id']);
			}
			
			if(!(isset($_SESSION['id']))){
				$_SESSION['id']=1;
				if(isset($_SESSION['userid'])){
					$_SESSION['userid'] = $_SESSION['userid'] + 1;
				}
				else{
					$_SESSION['userid'] = 1;
				}
				logsession_details($_SESSION['userid']);
				$docID=1;
				$docNumber=1;
			}
		
		
		if(isset($_POST['nextDoc'])){
			$docID= $_GET["docID"];
			$docNumber= $_GET["docNumber"];
			logsession_activity($_SESSION['userid'], ($docID-1), $_POST['radio1']);
		}
		
		if(isset($_POST['submitDoc'])){
			$docID= $_GET["docID"];
			$docNumber= $_GET["docNumber"];
			//echo $_SESSION['userid'];
			logFinalTime($_SESSION['userid']);
			logsession_activity($_SESSION['userid'], ($docID-1), $_POST['radio1']);
			unset($_SESSION['id']);
			$docID= 1;
			$docNumber= 1;
		}
		
		?>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="product" content="Cross Language Plagiarism Detector">
		<meta name="description" content="Simple responsive css framework">
		<meta name="author" content="Lalit Agarwal">
		
		<link rel="stylesheet" href="style/css/metro-bootstrap.css">
        <script src="style/js/jquery/jquery-2.1.1.min.js"></script>
        <script src="style/js/jquery/jquery.widget.min.js"></script>
		<script src="style/js/jquery/jquery.mousewheel.js"></script>
		
		<script type="text/javascript" src="style/js/texthighlighter/jquery.textHighlighter.js"></script>
		<script type="text/javascript" src="style/js/texthighlighter/rangy-core.js"></script>
		<script src="style/js/metro/metro-scroll.js"></script>
		<script src="style/js/metro/metro-progressbar.js"></script>
		<script src="style/js/metro/metro-panel.js"></script>
       
	   <script type="text/javascript" src="style/js/textselector.js"></script>
	   
		<style>
		mark { 
			background-color: #99CCFF;
			color: black;
		}
		</style>
    </head>
    <body class="metro">
		
		<?php 
			if($docNumber!=$total_Docs){
				echo "<div id=\"progress\" class=\"progress-bar large\" data-role=\"progress-bar\" data-color=\"bg-blue\" data-value=\"".($docNumber/$total_Docs*100)."\" data-max=\"100\" ></div>";
			}			
			else{
				echo "<div id=\"progress\" class=\"progress-bar large\" data-role=\"progress-bar\" data-color=\"bg-green\" data-value=\"".($docNumber/$total_Docs*100)."\" data-max=\"100\" ></div>";
			}
		?>
		<div class="grid fluid">
			<div class="row" >
				<div class="span4">
					<h2><center>ENGLISH</center><h2>
				</div>
				<div class="span4">
					<h2><center>CHINESE</center><h2>
				</div>
				<div class="span4">
					<h2><center>TOP TEN WORDS</center></h2>
				</div>
			</div>
			<div class="row" >
				<div class="span4">
					<div id="scrollbox1" data-role="scrollbox1" data-scroll="both" class="readable-text">
						<?php
							$result=getDocuments($docID);
							echo $result['Doc1'];
						echo "</div>
					</div>
					<div class=\"span4\">
						<div id=\"scrollbox2\" data-role=\"scrollbox1\" data-scroll=\"both\" class=\"readable-text\">";
							echo $result['Doc2'];
						?>
					</div>
				</div>
				<div class="span2">
					<nav class="sidebar light">
						<ul>
							
							<li class="title"><center>ENGLISH</center></li>
							<?php
								$result=explode(",",getTopWords1($docID)['Words1']);
								foreach($result as $result) {
									echo"<li><a href=\"#\"><center>$result</center></a></li>";
								}
							?>
						</ul>
					</nav>
				</div>
				<div class="span2">
					<nav class="sidebar light">
						<ul>
							<li class="title"><center>CHINESE</center></li>
							<?php
								$result=explode(",",getTopWords2($docID)['Words2']);
								foreach($result as $result) {
									echo"<li><a href=\"#\"><center>$result</center></a></li>";
								}
							?>
						</ul>
					</nav>
				</div>
			</div>
			<div class="row">
				<div class="span8"><h3>
					<?php					
						echo "<form id=\"getNextDoc\" class=\"form-horizontal\" role=\"form\" action=\"index4.php?docID=".($docID+1)."&docNumber=".($docNumber+1)."\" method=\"post\">";
						//echo "<form id=\"getNextDoc\" class=\"form-horizontal\" role=\"form\" action=\"index4.php\" method=\"post\">";
					?>
						<div class="input-control radio default-style" data-role="input-control">
							<label>
								<input type="radio" name="radio1" value="Plagiarized" checked />
								<span class="check"></span>
								Plagiarized
							</label>
						</div>
						<div class="input-control radio default-style" data-role="input-control">
							<label>
								<input type="radio" name="radio1" value="Partially Plagiarized" />
								<span class="check"></span>
								Partially Plagiarized
							</label>	
						</div>
						<div class="input-control radio default-style" data-role="input-control">
							<label>
								<input type="radio" name="radio1" value="Not Plagiarized" />
								<span class="check"></span>
								Not Plagiarized
							</label>
						</div> 
				</div>
				<div class="span1">
					<?php
						if ($docNumber<$total_Docs)
							echo "<center><button class=\"info\" value = \"next\" name=\"nextDoc\" id=\"next-btn\">NEXT</button></center>";
						else
							echo "<center><button class=\"success\" value = \"submit\" name=\"submitDoc\" id=\"submit-btn\">SUBMIT</button></center>";
					?>						
					</form>
				</div>
				<div class="span2">
					<center><button class="info" id="remove-highlights-btn">Remove all Highlights</button></center>
				</div>
				<div class="span1">
			<form id="StartAgain" class="form-horizontal" role="form" action="index4.php" method="post">
				<center><button class="info" id="start-over-btn">Start Over</button></center>
			</form>
		</div>
			</div>
			<div class="row">
				<div class="span4 offset2">
					<div class="panel collapsed" id="panel_similarity" data-role="panel">
						<?php $result=getSimilarity($docID);
							$similarity=$result['Similarity'];
							if($similarity<50)
								$bgcolor='bg-lightGreen';
							elseif ($similarity>=50 && $similarity<80)
								$bgcolor='bg-lightRed';
							else
								$bgcolor='bg-darkRed';
							echo "<div class=\"panel-header ".$bgcolor." fg-white\">
							Documents Similarity
						</div>
						<div style=display:none; class=\"panel-content bg-white fg-dark nlp nrp\"><h3><center>";
							echo $similarity."%";
						?>
						</h3></center>
						</div>
					</div>
				</div>
				<div class="span6">
					<label><h4>What topics if added to training data would help increase accuracy?</h4></label>
					<div class="input-control text" data-role="input-control">
						<input type="text" placeholder="Topics"/>
					</div>
				</div>
			</div>
			<br>
		</div>
	</body>
	
<script type="text/javascript" id="snippet-source">
	$("#progress").progressbar({
		onchange: function(val){}
	});
</script>

<script type="text/javascript" id="snippet-source">
	$("#panel_similarity").panel({
		onCollapse: function(){},
         onExpand: function(){}
	});
</script>

</html>
