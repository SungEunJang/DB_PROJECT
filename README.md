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
      
       
       
