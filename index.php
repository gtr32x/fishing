<html>
	<head>
		<title>Fishing</title>

		<meta name="viewport" content="width=320, initial-scale=1.0">

		<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>

		<link rel="stylesheet" type="text/css" href="css/lightbox.css" />
		<link rel="stylesheet" type="text/css" href="css/screen.css" />

		<style>
			body {
				font-family: helvetica;
				background: #eeeeee;
			}

			#content {
				padding: 0 0 20px;
				margin: 0 auto;
				overflow: auto;
				text-align: center;
			}

			h1 {
				font-size: 2em;
				padding: 15px 10px;
				background: #333333;
				color: white;
				box-shadow: 0px 0px 3px #888888;
			}

			#fish_container {
				display: flex;
				margin: 0 auto;
				flex-flow: row wrap;
				justify-content: center;
			}

			#fish_container:after {
				content: "";
				flex: auto;
			}

			.fish_block {
				position: relative;
				display: inline-block;
				padding: 3px;
				margin: 10px;
				box-shadow: 0px 0px 3px #888888;
				border-radius: 3px;
				background-color: white;
			}

			.fish_block h3 {
				margin: 0;
				padding-top: 8px;
				color: white;
				background: #333333;
				border-radius: 2px 2px 0 0;
			}

			.fish_block h4 {
				margin: 0;
				position: absolute;
				right: 12px;
				bottom: 36px;
				color: white;
				font-size: 3em;
				opacity: 0.3;
				z-index: 1;
				/*text-shadow: -1px 0px 1px #333, 0 0 0 #000, 1px 0px 1px #333;*/
			}

			.fish_block p {
				margin: 0;
				padding: 0 10px 5px;
				background: #333333;
				font-size: 0.9em;
				color: #999999;
				text-align: right;
				border-radius: 0 0 2px 2px;
			}

			.fish_block time {
				clear: both;
				float: left;
				font-size: 0.9em;
				padding-left: 10px;
				color: #999999;
			}

			.fish_block span {
				display: block;
				margin: 0 0 ;
				padding-bottom: 5px;
				font-style: italic;
				font-size: 0.8em;
				background: #333333;
				color: #999999;
			}

			.img_shadow {
				position: relative;
				max-width: 100%;
				float: left;
				margin-bottom: 5px;
			}
    
			.img_shadow::before {
				content: "";
				position: absolute;
				top: 0;
				bottom: 0;
				left: 0;
				right: 0;
				box-shadow: inset 0 0 10px black;
			}
		</style>

		<script>
			$(document).ready(function(){
				set_container_size();				
			});

			function set_container_size(){
				screen_width = window.innerWidth;
				items_per_row = Math.floor(screen_width / 326);
				container_width = 326 * items_per_row;

				$('#fish_container').css('width', container_width + 'px');
			}

			$(window).on('resize', function(){
				set_container_size();
			});
		</script>
	</head>

<?php
	$handle = fopen("fish.csv", "r");

	$fish = array();

	while (($line = fgets($handle)) !== false){
		$data = explode('|', str_replace("\n", "", $line));
		$img_name = strtolower($data[0]);
		$img_name = str_replace(' ', '_', $img_name);
		$fish[] = array(
			'name' => $data[0],
			'species_name' => $data[1],
			'image' => $img_name,
			'date' => $data[4],
			'location' => $data[3],
		);
	}

	fclose($handle);
?>

	<body>
		<div id="content">
			<h1>Fishing Records</h1>

			<h3>Total species count: <?php echo count($fish) ?></h3>

			<div id="fish_container">

<?php
	$count = 1;
	foreach ($fish as $f):
?>
			<div class="fish_block">
				<h4><?php echo $count; ?></h4>
				<h3><?php echo $f['name']; ?></h3>
				<span><?php echo $f['species_name']; ?></span>
				<a href="images/<?php echo $f['image'] ?>.jpg" data-lightbox="fish" class="img_shadow"><img src="images/<?php echo $f['image'] ?>_300.jpg" srcset="images/<?php echo $f['image'] ?>_300.jpg 1x, images/<?php echo $f['image'] ?>_300@2x.jpg 2x" data-rjs="2"></a>
				<time><?php echo $f['date']; ?></time>
				<p><?php echo $f['location']; ?></p>
			</div>
<?php
	$count++;
	endforeach;
?>
			</div>
		</div>

		<script src="js/lightbox.js"></script>
	</body>
</html>