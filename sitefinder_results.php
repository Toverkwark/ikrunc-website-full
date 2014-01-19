<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css"></link>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"></meta>
	</head>
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
	   	}
		function initialize() 
		{
			var SVGDocument = document.getElementById("svgimageframe").contentDocument;			    		
			SVGDocument.defaultView.AddEventListeners(SwapTableRowColor);
		}
		function SwapTableRowColor(ID)
		{
			TableRowID=ID+".table"
			var TableFrameDocument = document.getElementById("svgtableframe").contentDocument;	   		
			var TableRow = TableFrameDocument.getElementById(TableRowID);
			var CurrentBackgroundColor=TableRow.style.backgroundColor.valueOf();	   
			if(TableRow.style.backgroundColor.valueOf()=="red") {
			   	TableRow.style.backgroundColor="";
			}
			else {
				TableRow.style.backgroundColor="red";
			}
		}
		function ClickTableRow(ID) {
			var SVGDocument = document.getElementById("svgimageframe").contentDocument;
			SwapTableRowColor(ID);
			SVGDocument.defaultView.ClickTriangle(ID); 			
		}
		</script>
	</head>
	
	<body>
		<?php
			#TODO: Change this into perl -P
			$Opdracht = "perl scripts/ReportTargetSites.pl -r " . htmlspecialchars($_POST['RefSeqID']) . " -s " . htmlspecialchars($_POST['species']);
			exec($Opdracht,$Resultaat);
			foreach ($Resultaat as $ImageFile) {  // process array line by line
			}
			//Wait until svg file is written
			for ($i = 0; $i < 100; $i++) { 
				sleep(0.1);
				if ($im = @file_get_contents($ImageFile)) {
					break;
				}
			}
			echo "<iframe id='svgimageframe' src='";					
			echo $ImageFile;        			
			echo "' width='100%' seamless onload='initialize();'))></iframe>\n";
			echo "<iframe id='svgtableframe' src='";					
			echo $ImageFile . ".html";        			
			echo "' width='100%' seamless onload='alertsize(\"svgtableframe\");'></iframe>";
			?> 	
		<br>
	</body>
</html>