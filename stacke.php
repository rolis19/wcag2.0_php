<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Php file handling</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<style>
		header{height: 120px}
	</style>
</head>
<body>
	<header>
	</header>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<form action="" method="post">
                    <label for="cek">cek kode</label>
					<textarea name="cekode" id="cek" cols="80" rows="8"></textarea>
					<input type="hidden" name="stage" value="process">
					<button class="btn btn-success btn-lg" type="submit">CHECK</button>
				</form>
			</div>
			<div class="col-md-6">
				<h4>Your error code will be displayed here</h4>
				<?php

                class mainArray{
					protected $stack;
					protected $limit;

					public function __construct($limit = 10) {
						// initialize the stack
						$this->stack = array();
						// stack can only contain this many items
						$this->limit = $limit;
					}

					public function push($item) {
						// trap for stack overflow
						if (count($this->stack) < $this->limit) {
							// prepend item to the start of the array
							array_unshift($this->stack, $item);
						} else {
							throw new RunTimeException('Stack is full!');
						}
					}

					public function pop() {
						if ($this->isEmpty()) {
							// trap for stack underflow
							throw new RunTimeException('Stack is empty!');
						} else {
							// pop item from the start of the array
							return array_shift($this->stack);
						}
					}

					public function top() {
						return current($this->stack);
					}

					public function isEmpty() {
						return empty($this->stack);
					}
					public function printStack(){
						foreach ($this->stack as $item) {
							echo $item." _____ ";
						}
					}
				}
//  End of class here

                //Run Code start here
                if (isset($_POST['stage']) && ('process' == $_POST['stage'])) {
                    $main_array = new mainArray(htmlspecialchars($_POST['cekode']));
					$main_array->tag_check();
                }



				?>
				
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">

			</div>
		</div>
	</div>
	<footer style="color: #FFFFFF; padding: 40px; text-align: center; background-color: #262626; position: fixed; bottom: 0; width: 100%">
		<?php
		function convert($size){
			$unit=array('b','kb','mb','gb','tb','pb');
			return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
		}
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		echo 'Page generated in '.$total_time.' seconds.<br>';
		echo "Memory: ".convert(memory_get_usage());
		echo " Peak Memory: ".convert(memory_get_peak_usage());
		?>
	</footer>
	<script src="js/jquery.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<script type='text/javascript' src='js/bootstrap.js'></script>
</body>
</html>