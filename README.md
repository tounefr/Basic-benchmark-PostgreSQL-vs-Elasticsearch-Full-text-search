# Basic benchmark PostgreSQL vs Elasticsearch
---
For a project, i have to compare between PostgreSQL and Elasticsearch databases for full text searches.
I have to setup a database cluster for a website supporting more than 5000 users simultaneously.
I'm not an database administrator expert so i've to Googling a lot.

After some reading i've read that PostgreSQL and ElasticSearch are good full text searches solutions but i've not found which solution is best adapted for my needs.
I will update this Git as soon as i'm getting better results.
If you have any suggestions or remarks/questions, do not hesitate to submit an issue.

## Specifications
---
- I'm mostly using Docker Swarm to set up a cluster.
- The database requests are mostly read requests.
- The dataset to benchmark the databases comes from [IMDB actors names](http://www.imdb.com/interfaces)  (3 960 899 rows).
- The benchmark app (a simple PHP script) queries the database endlessly and display the numbers queries/s performed.

## Requirements
---
- Docker 1.13 and Docker-compose
- A good machine whith enough CPU and RAM
- Curl
- Extract the dataset `tar zxvf datasets.tar.gz`

## Benchmarking PostgreSQL
---

##### > Start the postgresql cluster
    docker-compose -f ./postgresql/postgresql.yml up -d postgresql
##### > Import the database
    echo "Importing the database, please wait..." && sleep 5 && ./postgresql/psql_importdb.sh
##### > Start the benchmark script
    docker-compose -f ./postgresql/postgresql.yml up -d benchmark_app
##### > Show the benchmark results
    docker-compose -f ./postgresql/postgresql.yml logs benchmark_app
    
##### > Stop the and remove cluster
    docker-compose -f ./postgresql/postgresql.yml kill ; \
    docker-compose -f ./postgresql/postgresql.yml rm ; \
    rm -rf ./postgresql/postgres_db/*

## Benchmarking Elasticsearch
---
You must set Docker as an Docker Cluster : `docker swarm init`

##### > Set the local domain to access the Elasticsearch API
    echo "127.0.0.1       elasticsearch.lan" >> /etc/host
    
##### > Start the cluster
    docker stack deploy -c ./elasticsearch/elasticsearch_swarm.yml benchmark
    
##### > Import the database
    echo "Importing the database in the background. This can take a while..." && ./elasticsearch/import_db.sh
    
##### > Start the benchmark script
    ./benchmark_app/stress.sh

##### > Stop and remove the cluster
    docker service rm $(docker service ls -q)
    
## Note
The benchmark scripts use one single CPU core.
To benefit to all yours cores, you can scale the container
##### PostgreSQL
    docker-compose -f ./postgresql/postgresql.yml scale benchmark_app=4
##### Elasticsearch
    soon
    
## Conclusion
---
Soon

