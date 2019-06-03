create database test2;
show databases;
create user 'test_user' @ 'localhost' identified by'1234';

grant all privileges on test2. * TO 'test_user'@'localhost';


use fortest;
alter user 'root'@'localhost' identified with mysql_native_password by 'password';
DROP TABLE Lectures;
CREATE TABLE Lectures(
	LEC_NAME CHAR(50) NOT NULL,
	LEC_PROF CHAR(50) NOT NULL,
	LEC_SEME VARCHAR(50) ,
	LEC_NUM VARCHAR(13) ,
	LEC_TYPE VARCHAR(50),
	LEC_CREDITS INT,
	PRIMARY KEY (LEC_SEME,LEC_NUM)
	);
INSERT INTO Lectures (LEC_NAME,LEC_PROF,LEC_SEME,LEC_NUM,LEC_TYPE,LEC_CREDITS)
VALUES 
 ("서버운영과보안","이종우","18년도 2학기","C180201","전공선택",3),
  ("여성의여행안전을위한자기방어기술","숀블래그던","19년도 1학기","A190102","교양일반",2),
  ("통계학","오예림","19년도 1학기","M190103","전공선택",3),
   ("웨이트트레이닝","신민혜","19년도 1학기","A190104","교양일반",2),
    ("영화를통한법의이해","홍성수","17년도 1학기","A170105","교양핵심",3),
    ("융합적사고와글쓰기","이명길","17년도 2학기","A170206","교양필수",2);

select * from Lectures;
CREATE TABLE Evaluation(
	EV_SEME VARCHAR(50),
    EV_STAR INT,
    EV_LECNUM VARCHAR(13),
    EV_NICK VARCHAR(50) NOT NULL,
    EV_CONTENT TEXT NOT NULL,
    EV_RECOM INT,
    PRIMARY KEY (EV_NICK,EV_LECNUM),
    FOREIGN KEY (EV_SEME,EV_LECNUM) REFERENCES Lectures(LEC_SEME,LEC_NUM)
);


    
