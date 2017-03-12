docker-compose -f ./postgresql/postgresql.yml exec postgresql psql -h 127.0.0.1 -U postgres -c "
CREATE TABLE actors(
	idactors SERIAL PRIMARY KEY,
	lname TEXT,
	fname TEXT,
	mname TEXT,
	number INTEGER,
	gender TEXT,
	tsvector_search tsvector
);

CREATE INDEX actors_search_idx ON actors USING GIN(tsvector_search);

CREATE TABLE movies(
	idmovies SERIAL PRIMARY KEY,
	title TEXT,
	year INTEGER,
	type TEXT,
	number INTEGER,
	location TEXT,
	language TEXT,
	tsvector_search tsvector
);

CREATE INDEX movies_search_idx ON movies USING GIN(tsvector_search);
COPY actors (idactors,lname,fname,mname,number,gender) FROM '/datasets/actors.csv' CSV HEADER DELIMITER ',';
COPY movies (idmovies,title,year,type,number,location,language) FROM '/datasets/movies.csv' CSV HEADER DELIMITER ',';

UPDATE actors SET tsvector_search = to_tsvector('english', lname);
UPDATE movies SET tsvector_search = to_tsvector('english', title);

";
