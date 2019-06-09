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
("영화를통한법의이해", "홍성수", "17년도 1학기", "A170105", "교양핵심", 3),
("여성의여행안전을위한자기방어기술", "숀블래그던", "17년도 1학기", "A170102", "교양일반", 2),
("통계학", "오예림", "17년도 1학기", "M170103", "전공선택", 3),
("웨이트트레이닝", "신민혜", "17년도 1학기", "A170104", "교양일반", 2),

("융합적사고와글쓰기", "이명길", "17년도 2학기", "A170206", "교양필수", 2),
("서버운영과보안", "이종우", "17년도 2학기", "C170201", "전공선택", 3),

("영화를통한법의이해", "홍성수", "18년도 1학기", "A180105", "교양핵심", 3),
("여성의여행안전을위한자기방어기술", "숀블래그던", "18년도 1학기", "A180102", "교양일반", 2),
("통계학", "오예림", "18년도 1학기", "M180103", "전공선택", 3),
("웨이트트레이닝", "신민혜", "18년도 1학기", "A180104", "교양일반", 2),
 
("융합적사고와글쓰기", "이명길", "18년도 2학기", "A180206", "교양필수", 2),
("서버운영과보안","이종우","18년도 2학기","C180201","전공선택",3),
   
("통계학", "오예림", "19년도 1학기", "M190103","전공선택",3),
("웨이트트레이닝","신민혜","19년도 1학기","A190104","교양일반",2), 
("여성의여행안전을위한자기방어기술","숀블래그던","19년도 1학기","A190102","교양일반",2);

select * from Lectures;
CREATE TABLE Evaluation(
	EV_SEME VARCHAR(50),
    EV_LECNUM VARCHAR(13),
    EV_NICK VARCHAR(50) NOT NULL,
    EV_CONTENT TEXT NOT NULL,
    EV_RECOM INT,
    EV_VIEW int,
    EV_TIME datetime default "2019-06-06 20:00:00",
    PRIMARY KEY (EV_NICK,EV_LECNUM),
    FOREIGN KEY (EV_SEME,EV_LECNUM) REFERENCES Lectures(LEC_SEME,LEC_NUM)
);

DROP TABLE Evaluation;

INSERT INTO Evaluation(EV_SEME,EV_LECNUM,EV_NICK,EV_CONTENT,EV_RECOM,EV_VIEW)
VALUES 
("18년도 2학기","C180201","진서연","재미있었지만, 점수를 받기에는너무 힘든 과목이다.",6,0),
("19년도 1학기","A190102","장성은"," 점수를 받기에는 너무 힘든 과목이다.",7,0),
("19년도 1학기","M190103","장성은","수학과 부전공으로 듣고싶어지는 수업.",10,0),
("19년도 1학기","A190104","진서연","운동을 싫어하는 사람에게도 재미있는 수업.",9,0),
("17년도 1학기","A170105","진서연","영화와 법을 한번에 이해할 수 있다.",4,0),
("17년도 2학기","A170206","진서연","도망가....",1,0);

SELECT * FROM evaluation;
select * from Lectures;
SELECT LEC_NAME,LEC_NUM,EV_LECNUM FROM Lectures,evaluation WHERE EV_LECNUM IN(LEC_NUM);
    

use final_project;

show tables;

delete from evaluation;
delete from lectures;

CREATE TABLE QnA(
	QA_title CHAR(100) NOT NULL,
	QA_nick VARCHAR(50) ,
    QA_content TEXT,
    QA_date date DEFAULT '0000-00-00',
    QA_num INT auto_increment,
    Primary KEY (QA_num)
);
    
INSERT INTO QnA (QA_title, QA_nick, QA_content, QA_date, QA_num)
VALUES ("공지사항", "ADMIN", "강의했SOOK 공지사항", curdate(), 1),
("공지사항", "ADMIN", "강의했SOOK 공지사항2", curdate(), 2),
("디자인", "김송송", "강의했sook 디자인바꿔주세요..", curdate(), 3),
("게시물.", "김상하", "각 게시물마다 댓글 기능은 없나요?", curdate(), 4),
("게시물.", "송하경", "광고가 너무 많아요.", curdate(), 5);

drop table QnA;

