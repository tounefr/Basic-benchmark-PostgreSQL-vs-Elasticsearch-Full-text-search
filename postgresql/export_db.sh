docker-compose -f postgresql.yml exec postgresql bash -c 'pg_dump -U postgres -h 127.0.0.1 postgres > /dump/postgres'
