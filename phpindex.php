<?php

function google_spreadsheet_to_array($key) {
                // initialize URL
                        $url = 'http://spreadsheets.google.com/feeds/cells/' . $key . '/1/public/values';

                // initialize curl
                        $curl = curl_init();

                // set curl options
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_HEADER, 0);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

                // get the spreadsheet using curl
                        $google_sheet = curl_exec($curl);

                // close the curl connection
                        curl_close($curl);

                // import the xml file into a SimpleXML object
                        $feed = new SimpleXMLElement($google_sheet);

                // get every entry (cell) from the xml object
                        // extract the column and row from the cell's title
                        // e.g. A1 becomes [1][A]

                        $array = array();
                        foreach ($feed->entry as $entry) {
                                $location = (string) $entry->title;
                                preg_match('/(?P<column>[A-Z]+)(?P<row>[0-9]+)/', $location, $matches);
                           $array[$matches['column']][$matches['row']] = (string) $entry->content;
                        }

                // return the array
                return $array;
        }
        
function results_spreadsheet_to_array($key) {
		// initialize URL
				$url = 'http://spreadsheets.google.com/feeds/cells/' . $key . '/1/public/values';

		// initialize curl
				$curl = curl_init();

		// set curl options
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HEADER, 0);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		// get the spreadsheet using curl
				$google_sheet = curl_exec($curl);

		// close the curl connection
				curl_close($curl);

		// import the xml file into a SimpleXML object
				$feed = new SimpleXMLElement($google_sheet);

		// get every entry (cell) from the xml object
				// extract the column and row from the cell's title
				// e.g. A1 becomes [1][A]

				$array = array();
				foreach ($feed->entry as $entry) {
						$location = (string) $entry->title;
						preg_match('/(?P<column>[A-Z]+)(?P<row>[0-9]+)/', $location, $matches);
				   $array[$matches['row']][$matches['column']] = (string) $entry->content;
				}

		// return the array
		return $array;
}
        

$responses = results_spreadsheet_to_array('0Av9l84KvUJBWdFNVRGhhc1E1Umc0ZG92d1d4SE13N3c');
$last = count($responses) - 1;
$isFirst = true;	
?>

<!DOCTYPE html>
 <html lang="en">
 <head>
<link href="http://augmenting.me/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />	
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://augmenting.me/trials/before_after/jquery.beforeafter.js"></script>
<script type="text/javascript">
$(function(){
	<?php
					foreach ($responses as $i => $row)
	{
		if ($isFirst) {
		$isFirst = false;
		continue;
		}
		$isLast = ($i == $last);
	echo "$('#container";
	echo $i;
	echo "').beforeAfter();";
}
	?>
});
</script>

 </head>
 <body>
	 <div class="container">
	 	<div class="row clearfix">
	 		<div class="col-md-12 column">
	 			
	<?php
					foreach ($responses as $i => $row)
	{
		if ($isFirst) {
		$isFirst = false;
		continue;
		}
		$isLast = ($i == $last);
		echo '<div class="panel panel-default"><h2>';
		echo $row['A'];
		echo '</h2>';
		echo '<div id="container';
		echo $i;
		echo '"><div>';
		echo '	<img alt="before" src="';
		echo $row['B'];
		echo '" width="';
		echo $row['D'];
		echo '" height="';
		echo $row['E'];
		echo '"></div>';
		echo '<div><img alt="after" src="';
		echo $row['C'];
		echo '" width="';
		echo $row['D'];
		echo '" height="';
		echo $row['E'];
		echo '"></div></div></div>';
			}
					?>
	 </div>
	 		</div>
	 	</div>
	 </div>
     
 </body>
 </html>		                     
