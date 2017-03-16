#!/bin/bash

export IFS=','
i=0
time_start=$(date +%s)
for word in `cat benchmark_app/words`; 
do 
	wget -O /dev/null --data-urlencode "q=$word" http://elasticsearch.lan/actors/_search > /dev/null 2> /dev/null;
	i=$((i+1))
	if [ $(date +%s) -gt $time_start ]; then
	        echo $i "requests per sec"
		time_start=$(date +%s)
		i=0
	fi
	
done
