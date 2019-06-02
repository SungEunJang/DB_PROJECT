# DB_PROJECT
/* DATA BASE INFO*/
회원정보(SINFO) //가입할때 생성되는 테이블
  이름: SINFO_name,   
  학번: SINFO_SSN,  fk , pk
  전공: SINFO_major,  fk 
  비밀번호: SINFO_pass,
  이메일:SINFO_mail,
  닉네임: SINFO_nick

학생(Students_reg)  // 회원가입시 인증
  이름: stu_name  
  학번: stu_SSN   //pk
  전공: stu_major  //pk 

view 로그인(Log)  // 로그인 시 가입여부 비교 회원정보에서 다 가져옴. 
  학번: log_SSN  
  비밀번호: log_pass


/*Log in Page*/
현재로서는 비밀번호 확인을 학번칸에서 확인하도록 하였다.
      
       
/* 강의평가 홈페이지 작성 DB */
강의 목록(Lectures)
   강의명 lec_name: 
   교수명 lec_prof;
   학기 lec_seme:            pk
   강의 번호 lec_num:     pk  -> char
   교과구분 lec_type: 
   학점 lec_credits:
   

강의 평가 (Evaluation) 
   학기정보: ev_seme, fk 
   영역:  select문이나 쿼리문으로 강의목록에서 데려오면 됨.      
   강의명:  select문이나 쿼리문으로 강의목록에서 데려오면 됨.     
   별점: ev_star,
   교수명: select문이나 쿼리문으로 강의목록에서 데려오면 됨.       
   강의번호: ev_lecnum,     fk pk
   닉네임: ev_nick, pk
   내용: ev_content
   추천수: ev_recom

강의 추천  (Recommendation)   -> select문으로 강의평가에서 다 끌고옴.   
   추천내용: rec_content,  
   강의명: rec_lectitle,
   교수명:rec_prof,
   강의번호:rec_lecnum, fk
   닉네임: rec_nick, fk 
  학기정보: rec_seme*/

