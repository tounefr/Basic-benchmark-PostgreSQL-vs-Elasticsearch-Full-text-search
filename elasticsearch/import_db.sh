docker run -d --rm --net host -v "$PWD/datasets/":/data -v "$PWD/elasticsearch/":/config-dir logstash -f /config-dir/logstash.conf
