# 2018-2학기 데이터베이스 강의 제출 프로젝트

## 프로젝트 소개
`DBMS` + `Java` + `Web`을 아우르는 프로젝트
### 프로젝트 상세
대학교 재학생들이 강의평을 공유할 수 있는 커뮤니티 구현
### 기술 스택
- MySQL
- Java
- php

## Database Schema
### Relation : 학생(Students_reg) - 대학교에 재학중인 학생 정보, 회원가입시 인증이 필요함
설명 | field name | constraint
-- | ---------- | ----------
이름 | stu_name |
학번 | stu_SSN | primary key
전공 | stu_major | primary key

### Relation : 회원정보(SINFO) - 가입할때 생성되는 테이블
설명 | field name | constraint
-- | ---------- | ----------
이름 | SINFO_name | 
학번 | SINFO_SSN | primary key, foreign key
전공 | SINFO_major | foreign key
비밀번호 | SINFO_pass | foreign key
이메일 | SINFO_mail |
닉네임 | SINFO_nick

### View : 로그인(Log) - 로그인 시 가입여부 비교 회원정보에서 다 가져옴. 
설명 | field name
-- | ----------
학번 | log_SSN
비밀번호 | log_pass


_Log in Page*_
현재로서는 비밀번호 확인을 학번칸에서 확인하도록 하였다.     
       
_강의평가 홈페이지 작성 DB_
### Relation : 강의 목록(Lectures) - 대학교 전체 강의 
설명 | field name | constraint
-- | ---------- | ----------
강의명 | lec_name |
교수명 | lec_prof |
학기 | lec_seme | primary key
강의번호 | lec_num | primary key
교과구분 | lec_type |
학점 | lec_credits |
   

### Relation : 강의 평가 (Evaluation) - 유저(학생)들이 올린 강의 평가
설명 | field name | constraint
-- | ---------- | ----------
학기정보 | ev_seme | foreign key
별점 | ev_star |
강의번호 | ev_lecnum | foreign key, primary key
닉네임 | ev_nick | primary key
내용 | ev_content |
추천수 | ev_recom |

### Relation : 강의 추천 (Recommendation)
설명 | field name | constraint
-- | ---------- | ----------
추천내용 |rec_content |
강의명 | rec_lectitle |
교수명 | rec_prof |
강의번호 | rec_lecnum | foreign key
닉네임 | rec_nick | foreign key
학기정보 | rec_seme |

### Relation : Q&A (QnA) - 유저(학생)들이 올리는 질문
설명 | field name | constraint
-- | ---------- | ----------
제목 | QA_title |
닉네임 | QA_nick |
내용 | QA_content |
날짜 | QA_date |
댓글 | QA_ Reply |

### Relation : Reply - 유저(학생)들이 올린 질문에 달린 답변
설명 | field name | constraint
-- | ---------- | ----------
댓글 내용 | Reply_content |
댓글 닉네임 | Reply_nick |
댓글 날짜 | Reply_date |
