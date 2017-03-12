<?php

error_reporting(E_ALL);

while (1) {
	try {
        $ip = gethostbyname('postgresql');
		$pdo = new PDO('pgsql:dbname=postgres;user=postgres;password=azerty;host='.$ip);
		break;
	} catch (PDOException $e) {
		echo $e->getMessage() . "\n";
		sleep(1);
	}
}

echo "connected to " . $ip . "\n";

function generateValue() {
	return uniqid();
}

$time_start = time();
$words = explode(",", file_get_contents("/words"));
$count = 0;
while (1) {
    foreach ($words as $word) {
        try {
            $sql = 'SELECT * FROM actors WHERE tsvector_search @@ plainto_tsquery(\'english\', \'' . $word . '\');';
            $query_time_start = microtime(true);
            $count++;
            $result = $pdo->query($sql);
            if ($result === FALSE) {
                print_r($pdo->errorInfo());
                continue;
            }
            $query_time_end = microtime(true);
            $elapsed_time = ($query_time_end - $query_time_start) * 1000;

            if (time() > $time_start) {
                echo $count . " requests per/s | last query = " . $result->rowCount() . " rows, " . $elapsed_time . " ms\n";
                $time_start = time();
                $count = 0;
            }

        } catch (PDOException $e) {
            echo $e->getMessage() . "\n";
        }
//        sleep(0.01);
    }
}
