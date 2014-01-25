<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css"></link>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"></meta>
		<script>
			function alertsize(ID)
			{
				{
					document.getElementById(ID).style.height = 0;
				};
				{			
					pixels=document.getElementById(ID).contentWindow.document.body.scrollHeight;   			
					document.getElementById(ID).style.height=pixels+"px";				
				}
				document.getElementById(ID).scrolling="no";
				parent.alertsize('maincontentframe');
			}
		</script>
	</head>

	<body>
		<header>
			<h1>Select RefSeq ID</h1>
		</header>
		For <?php echo htmlspecialchars($_POST['species']);?> gene <?php	echo htmlspecialchars($_POST['gene']);?>, the following RefSeq transcripts were found. Please pick one:<br> 		
		<form action="sitefinder_results.php" method="post" target="sitefinderresultsframe">
			<input type="hidden" name="species" value="<?php echo htmlspecialchars($_POST['species']);?>"/>
			<select name="RefSeqID" size="5" width="auto">		 
			<?php
				$Opdracht = "perl scripts/ObtainRefSeqIDFromGene.pl -g " . htmlspecialchars($_POST['gene']) . " -s " . htmlspecialchars($_POST['species']);
				exec($Opdracht,$Resultaat);
				foreach ($Resultaat as $RefSeqID) {  // process array line by line				
					echo '<option value="' . $RefSeqID. '">' . $RefSeqID . '</option>\n';
				}
			?>
			</select><br><br>
			Display only the top <input type="text" name="NumberOfSites" value="20" size="7"/> sites (Enter -1 to show all)<br>
			Only search the 5' <input type="text" name="Percentage" value="50" size="7"/>% of the transcript for valid sites<br>
			Include <input type="text" name="AroundStart" value="25" size="7"/> nucleotides around the startcodon as valid target sites (max. 100)<br><br>
			<input type="submit" name="Plot CRISPR Sites" /><br>
			Click <a href="sitefinderexplanation.html" target="_blank">here</a> for an explanation of what you see below<br>
		</form>
		<iframe name="sitefinderresultsframe" id="sitefinderresultsframe" class="maincontentclass" width="100%" seamless onload="alertsize('sitefinderresultsframe');">
		</iframe>
	</body>
</html>