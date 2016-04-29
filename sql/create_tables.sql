CREATE TABLE Golfer(
  id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
  name varchar(50) NOT NULL, -- Muista erottaa sarakkeiden määrittelyt pilkulla!
  password varchar(50) NOT NULL
);-- Lisää CREATE TABLE lauseet tähän tiedostoon


CREATE TABLE Course(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL,
  holes INTEGER,
  city varchar(50) NOT NULL
);

CREATE TABLE Hole(
  id SERIAL PRIMARY KEY,
  course_id INTEGER REFERENCES Course(id),
  holenumber INTEGER,
  par INTEGER
);

CREATE TABLE PlayedCourse(
  id SERIAL PRIMARY KEY,
  golfer_id SERIAL REFERENCES Golfer(id),
  course_id INTEGER REFERENCES Course(id),
  result INTEGER
);

CREATE TABLE PlayedHole(
  id SERIAL PRIMARY KEY,
  course_id INTEGER REFERENCES Course(id),
  playedcourse_id INTEGER REFERENCES PlayedCourse(id),
  golfer_id SERIAL REFERENCES Golfer(id),
  holenumber INTEGER,
  result INTEGER 
);
