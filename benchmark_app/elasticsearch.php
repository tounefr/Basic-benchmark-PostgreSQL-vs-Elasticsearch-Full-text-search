<?php

//$words = explode(",", file_get_contents("/benchmark_app/words"));
$words = explode(",", file_get_contents("./words"));

$count = 0;
$time_display = time();
$failed = 0;

while (1) {
	foreach ($words as $word) {
		$url = "http://elasticsearch.lan/logstash-2017.03.12/_search?q=".urlencode($word)."&size=1";
		//print_r($url . "\n");
		$time_start = microtime(true);
		$result = @file_get_contents($url);
		$count++;
		$time_end = microtime(true);
		$elapsed_time_ms = ($time_end - $time_start) * 1000;

		if ($result === false) {
			$failed++;
			continue;
		}

		if (time() > $time_display) {
			echo $count . " requests per/s $failed requests failed, last query $elapsed_time_ms ms\n";
			$count = 0;
			$failed = 0;
			$time_display = time();
		}

	}
}
