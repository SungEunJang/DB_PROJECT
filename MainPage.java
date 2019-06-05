import javax.swing.*;
import javax.swing.table.JTableHeader;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.image.BufferedImage;
import java.sql.*;
import java.util.*;
import java.io.File;
import java.io.IOException;
import javax.imageio.ImageIO;

/*java GUI구현을 목표로 하고자 하였기 때문에 [https://zoomkoding.github.io/java/2018/06/28/Java-round-3.html] 해당 홈페이지의 GUI부분을 많이 참고하였다.*/
public class MainPage{
	/*버튼을 누를떄마다 주는 flag로서 해당 플래그를 이용해서 원하는 동작을 query문으로 이동할 수 있다. */
	BufferedImage img = null;
	public static final int DEFAULT = 0;
	public static final int LOGINCHECK = 1;
	public static final int CHANGEACCOUNT = 2;
	public static final int SAVE = 3;
	public static final int DELETEACCOUNT =4;
	public static final int ADMIN = 5;
	public static final int CHECK= 6;
	//현재 "<강의평가했SOOK>"의 가입자 리스트를 담는 array이다.
	ArrayList<String> data = new ArrayList<String>();
	ArrayList<String> login_ar = new ArrayList<String>();
	ArrayList<String> login_br = new ArrayList<String>();
	ArrayList<String> lec_ar = new ArrayList<String>();
	ArrayList<String> lecname_ar = new ArrayList<String>();
	//현재 DB불러올 것들에 대한 변수
	String username; String passwd; String what;
	String col; String name; String new_passwd; String email;
	
	int mode = DEFAULT; int check = 0;  int checkboxnum;  int adminLog = 0;
	//MySQL 접속시 필요한  문장들.
	static 	String url = "jdbc:mysql://localhost:3306/test?characterEncoding=UTF-8&serverTimezone=UTC";
	//url:접속할 데이터 베이스 주소 
	static final String user = "root";
	//DB접속 아이디로 편의상 팀원과 같은 root라는 이름을 사용하였다.
	static final String password = "password";
	//DB접속 비밀번호로 위와 같은 이유로 팀원과 같다.
	//MySQL접속시 필요한 설정들이다. 
	Connection conn = null;
	Statement stmt = null;
	ResultSet rs = null;
	ResultSet ad = null;
	
//사용한 FRAME
		JFrame frame = new JFrame("SOOK LECTURE_LOG");
		JFrame warnFrame = new JFrame();
		JFrame createFrame = new JFrame("Change Account");
		JFrame askFrame = new JFrame();
		JFrame editFrame = new JFrame("Change data");
//PANEL 
		JPanel mainPanel = new JPanel();
		JPanel adminPanel = new JPanel();
		JPanel createPanel = new JPanel();
		JPanel deletePanel = new JPanel();
		JPanel userPanel = new JPanel();
		JPanel loginPanel = new JPanel();
		
//LABEL
		JLabel mainUserLabel = new JLabel("학번");
		JLabel pwLabel = new JLabel("Password");
		JLabel editLabel = new JLabel("Change to what?");
		JLabel warnLabel = new JLabel();
		JLabel changeLabel = new JLabel("Change your Info");
		JLabel askLabel = new JLabel();
		JLabel userModeLabel = new JLabel("UserMode");
		JLabel changeInfoLabel = new JLabel("Change Info");
		JLabel [] newLabel = new JLabel[4];
		JLabel [] deleteLabel = new JLabel[3];		
		JLabel loginLabel = new JLabel("로그인 정보:");
//BUTTON
		JButton loginBtn = new JButton("Log in");
		JButton editBtn = new JButton("Okay");
		//JButton createBtn =	new JButton("Create Account");
		JButton changeBtn = new JButton("Change Account");
		JButton warnBtn = new JButton("Got it");
		JButton askBtn2 = new JButton("No");
		JButton closedBtn = new JButton("CLOSED");
		JButton closeBtn = new JButton("CLOSE");
		JButton [] newBtn = new JButton[3];
		JButton [] deleteBtn = new JButton[3];
		JButton askBtn1 = new JButton("Yes");
		JButton DeleteBtn = new JButton("Delete Account");	
		
//TEXTFIELD & 그 외 여러가지 영역들.
		JTextField mainUserField = new JTextField("");
		JTextField editText = new JTextField();
		JTextField [] userField = new JTextField[6];
		JTextField [] newField = new JTextField[6];
		JTextField [] deleteField = new JTextField[6];
		JTable table,table_log;
		JScrollPane jScrollPane;
		JPasswordField pwField = new JPasswordField();

		Dimension dim_Frame = new Dimension(750,600);
		Dimension dim_Label = new Dimension(300,30);
		Dimension dim_Field = new Dimension(300,40);
		Dimension dim_Button = new Dimension(250,50);
		Dimension dim_SButton = new Dimension(150,70);
		

public static void main(String[] args) {
			new MainPage();
		}

public MainPage() {
		
		//FRAME 선언부분 : 기본이 되는 홈페이지이다. 
		frame.setVisible(true);
		frame.setSize(dim_Frame);
		frame.setLocation(0, 0);
		frame.setResizable(false);
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
	//mainpanel: frame에 붙을 기본이 되는 패널이다. 로그인 기능을 구현하는 부분.위치,사이즈 선정. 
		mainPanel.setLayout(null);
		mainUserLabel.setLocation(50, 15);
		pwLabel.setLocation(50, 115);
		mainUserField.setLocation(50, 45);
		pwField.setLocation(50, 145);
		loginBtn.setLocation(400, 45);
		changeBtn.setLocation(400,100);
		DeleteBtn.setLocation(400, 155);
	//createBtn.setLocation(50, 280);
		mainUserField.setSize(dim_Field);
		mainUserLabel.setSize(dim_Label);
		pwLabel.setSize(dim_Label);
		pwField.setSize(dim_Field);
		loginBtn.setSize(dim_Button);
	//createBtn.setSize(dim_Button);	//계정생성 버튼. 
		changeBtn.setSize(dim_Button);  //계정 수정 버튼 
		DeleteBtn.setSize(dim_Button);
		
		//actionlistener 선정 부분. 
		DeleteBtn.addActionListener(new ButtonAction());
		loginBtn.addActionListener(new ButtonAction());
		closedBtn.addActionListener(new ButtonAction());
		changeBtn.addActionListener(new ButtonAction());
		closeBtn.addActionListener(new ButtonAction());
		mainPanel.setFont(new Font("Arial", Font.BOLD, 20));
		frame.add(mainPanel);
		
		mainPanel.add(mainUserLabel);
		mainPanel.add(mainUserField);
		mainPanel.add(pwLabel);
		mainPanel.add(pwField);
		mainPanel.add(loginBtn);
		
		//mainPanel.add(createBtn);
		mainPanel.add(changeBtn);
		mainPanel.add(DeleteBtn);
 //login시 나오는 panel 
		
	//경고창
		warnFrame.setSize(400, 200);
		warnFrame.setLocation(0, 0);
		warnFrame.setLayout(null);
		warnFrame.setResizable(false);
		warnFrame.setVisible(false);
		warnLabel.setLocation(10, 10);
		warnLabel.setSize(380, 100);
		warnLabel.setFont(new Font("Arial", Font.PLAIN, 15));
		warnBtn.setSize(100, 50);
		warnBtn.setLocation(150, 100);
		warnBtn.addActionListener(new ButtonAction());
		
		warnFrame.add(warnLabel);
		warnFrame.add(warnBtn);
		
	//계정의 비밀번호 변경 시 사용함.
		newLabel[0] = new JLabel("UserName");
		newField[0] = new JTextField();
		newLabel[1] = new JLabel("Your Password");
		newField[1] = new JTextField();
		newLabel[2] = new JLabel("NEW Password");
		newField[2] = new JTextField();
		
		newLabel[3] = new JLabel("E-mail");
		newField[3] = new JTextField();
		newBtn[0] = new JButton("Save");
		newBtn[1] = new JButton("Cancel");
		newBtn[2] = new JButton("Check");
		
	//계정 삭제 시 사용
		deleteLabel[0] = new JLabel("UserName");
		deleteField[0] = new JTextField();
		deleteLabel[1] = new JLabel("Before Password");
		deleteField[1] = new JTextField();
		deleteLabel[2] = new JLabel("E-mail");
		deleteField[2] = new JTextField();
	//계정 삭제에 승인하거나 취소할때 사용하는 버튼.
		deleteBtn[0] = new JButton("OK");
		deleteBtn[1] = new JButton("Cancel_delete");
		
	}
//실제 구현과 연관된 부분들 ====> JAVA영역 
	class ButtonAction implements ActionListener{
		public void actionPerformed(ActionEvent e) {
			JButton myButton = (JButton)e.getSource();
			String temp = myButton.getText();
			
			if(temp.equals("Log in")) { 				//로그인 버튼을 누르면 SQL문장이 실해되는 command 함수로 이동하는데 이때, LOGINCHECK부분으로넘어간다.
				username = mainUserField.getText(); 	//입력받은 문자열을 username이라는 변수에 저장한다. 
				passwd = new String(pwField.getPassword()); 
				/*비밀번호 입력 영역 역시 passwd변수에 저장한다. 
				이때, command부분으로 넘어갈때 username과 passwd변수가 함께 넘어간다.*/
				mainUserField.setText("");
				pwField.setText("");

				mode = LOGINCHECK;                                          //LOGINCHECK로 넘기면 command에서 SQL 구현. 
				System.out.println("Login 정보 " + username + " " + passwd);  //콘솔창에서 로그인 정보가 출력되도록 하였다. 
				command(); 
			}
			/*else if(temp.equals("Create Account")) { 	//회원정보를만들때에는 웹언어로 작성한 계정생성으로 넘어가도록 링크를 걸어두었다. 
				Runtime runtime = Runtime.getRuntime();
				try {
					runtime.exec("explorer.exe http://localhost/index.php");
				} catch (IOException ex) {
				}
			}*/
			else if(temp.equals("Change Account")) { 
				/*계정의 비밀번호를 변경시, CHANGEACCOUNT라는 FLAG를 사용하는데, 이때, 기존의 panel인 mainpanel을 remove하고 새롭게 지정한 panel을 add한다.  */
				mode = CHANGEACCOUNT;
				createPanel.setLayout(null);
				frame.remove(mainPanel);
				frame.add(createPanel);
				frame.revalidate();
				frame.repaint();
				//createpanel의 디자인 부분. 
				int x = 50, y = 10;

				for(int i =  0; i< newLabel.length ; i++) {
					newLabel[i].setLocation(x, y);
					newLabel[i].setSize(dim_Label);
					createPanel.add(newLabel[i]);
					y += 30;
					newField[i].setLocation(x, y);
					newField[i].setSize(dim_Field);
					createPanel.add(newField[i]);
					y += 40;
					if(i==0) y += 50; 
				}
				for(int i = 0; i < newBtn.length -1 ; i++) {
					newBtn[i].setLocation(x, y);
					newBtn[i].setSize(dim_SButton);
					newBtn[i].addActionListener(this);
					createPanel.add(newBtn[i]);
					x += 150;
				}
				
				newBtn[2].setLocation(230, 80);
				newBtn[2].setSize(120, 50);
				newBtn[2].addActionListener(this);
				createPanel.add(newBtn[2]);
				
			}
				
			//warnFrame(경고창)이 사라지도록 함. 
			else if(temp.equals("Got it")){
					warnFrame.setVisible(false);
				}
			/*계정 변경시 createpanel에서 작성한 내용을 save를누르면 그때 비로서 save라는 flag가 넘어가고 
			이때!!, command 함수 부분에서 SQL문 중 UPDATE를 한다. */
			else if(temp.equals("Save")) {				
					mode = SAVE;
					String warnMessage = "";
					warnMessage ="Success!";
						//userField라는 배열에 입력값을 저장한다. 이때, command함수로 넘어갈때 같이 넘어가게 된다. 
						username = newField[0].getText();
						passwd = newField[1].getText();
						new_passwd = newField[2].getText();
						
						email = newField[3].getText();
				//command함수를 실행함. 이때, flag인 SAVE에 해당하는 부분만 실행함.
						command(); 
						warnLabel.setText("password changed successfully!");
						warnFrame.setVisible(true);
						frame.remove(createPanel);
						frame.add(mainPanel);
						frame.revalidate();
						frame.repaint();
						//이후에 있을 동작들을 위해서 다시 DEFAULT flag로 돌아간다.
						mode = DEFAULT;
						check = 0;
					}
			//계정의 비밀번호 변경을 진행하다가 그만두고 싶은 경우에 실행하는 코드이다. 만일 비밀번호 변경을 진행하던 도중 cancel을 누르면 mainpanel로 돌아간다.
			else if(temp.equals("Cancel")) {
				frame.remove(createPanel);
				frame.remove(userPanel);
				frame.add(mainPanel);
				frame.revalidate();
				frame.repaint();
				for(int i = 0; i < newField.length; i++) {
					newField[i].setText("");
				}
				for(int i = 0; i < userField.length; i++) {
					userField[i].setText("");
				}
				mode = DEFAULT;
			}
			//계정 삭제
			else if(temp.equals("Delete Account")) {
					//계정을 삭제할때, 나타나는 panel인 deletePanel이다. 위와 동일하게 mainpanel을 remove하고 deletepanel을 add한다. 
				//해당 부분에서도 실질적인 sql구현은 없다. !!! 실질적인 구현은 deletepanel안의 deletebtn버튼을 눌렀을때, 실행한다. 
					deletePanel.setLayout(null);
					frame.remove(mainPanel);
					frame.add(deletePanel);
					frame.revalidate();
					frame.repaint();
					//버튼과 Label, Field 위치 선정. 
					int x = 50, y = 10;

					for(int i =  0; i< deleteLabel.length ; i++) {
						deleteLabel[i].setLocation(x, y);
						deleteLabel[i].setSize(dim_Label);
						deletePanel.add(deleteLabel[i]);
						y += 30;
						deleteField[i].setLocation(x, y);
						deleteField[i].setSize(dim_Field);
						deletePanel.add(deleteField[i]);
						y += 40;
						if(i==0) y += 50; 
					}
					for(int i = 0; i < deleteBtn.length -1 ; i++) {
						deleteBtn[i].setLocation(x, y);
						deleteBtn[i].setSize(dim_SButton);
						deleteBtn[i].addActionListener(this);
						deletePanel.add(deleteBtn[i]);
						x += 150;
					}

				}
			//계정 삭제 시 실질적인 구현 부분. 
			//실질적으로 구현할 때, 삭제가 sql쿼리 문으로 넘어가서 진행하게 되는 부분이다.  
			else if(temp.equals("OK")) {				
				mode = DELETEACCOUNT;
				String warnMessage = "";
				warnMessage ="Your account was deleted";
					System.out.println("DeleteaACCOUNT");
					username = deleteField[0].getText();
					passwd = deleteField[1].getText();
					
					//deletepanel안의 deleteField에 입력된 값을 command함수로 넘겨준다. 이때, 위와 동일하게 command에서는 DELETEACCOUNT영역만 실행한다. 
					command();
					//계정이 무사히 삭제 되면 경고창을 통해서 계정이 삭제됨을 알려준다. 그 후, deletepanel을 remove하고 mainpanel을 add해준다. 
					warnLabel.setText("Account Delete!");
					warnFrame.setVisible(true);
					frame.remove(deletePanel);
					frame.add(mainPanel);
					frame.revalidate();
					frame.repaint();
					mode = DEFAULT;
					check = 0;
				}
			//계정 과정을 모두 그만두고 싶으면, cancel_Delete버튼을 누르면 다시 mainpanel로 돌아간다. 
			else if(temp.equals("Cancel_delete")) {
				frame.remove(deletePanel);
				frame.remove(userPanel);
				frame.add(mainPanel);
				frame.revalidate();
				frame.repaint();
				for(int i = 0; i < newField.length; i++) {
					newField[i].setText("");
				}
				for(int i = 0; i < userField.length; i++) {
					userField[i].setText("");
				}
				mode = DEFAULT;
			}
			//단순한 창을 끄는 버튼이다.
			else if(temp.equals("CLOSE")) {
					frame.remove(adminPanel);
					
					frame.add(mainPanel);
					frame.revalidate();
					frame.repaint();
					mode =DEFAULT;
				}
			//단순한 창을 끄는 버튼이다.
			else if(temp.equals("CLOSED")) {
				frame.remove(loginPanel);
				
				frame.add(mainPanel);
				frame.revalidate();
				frame.repaint();
				mode =DEFAULT;
			}
			
			//중복확인을 진행하는 버튼으로서 본인이 가입이 되어있는지 이름을 통해서 조회가능하다. 
			else if (temp.equals("Check")) {
					username = newField[0].getText();
					//newField[0].setText("");
					mode =CHECK;
					command();
					mode= DEFAULT;
				}
				
			}
		}
	
		
//!! SQL쿼리 문과 JAVA를 연결지어서 구현하는 부분이다. 	
	public void command() {
		try {
			Class.forName("com.mysql.jdbc.Driver"); 
			// JDBC 드라이버 로드
			conn = DriverManager.getConnection(url,user,password);
			System.out.println("드라이버 연결 성공!");
			

			stmt = conn.createStatement();
			//본인의 DB 이름을 작성해준다. 
			String useXproject = "use fortest";
			stmt.executeUpdate(useXproject);
			
			if(mode == LOGINCHECK) {
				col = "SINFO_SSN";
				what = username;
				
				//해당 쿼리문에서는 입력한 데이터와 비교할 기존 회원 데이터중 입력된 학번과 같은 값을 출력한다.
				String search = "select * from SINFO where " + col + " like '" + what +"';";
				//System.out.println(search);
				rs = stmt.executeQuery(search);
				if(rs.next()) {
					if(passwd.equals(rs.getString("SINFO_PASS"))){
						//로그인시 조회해야하는 부분들을 조회되면 진입할 수 있는 IF문이다.비밀번호 영역 조회로 넘어가면 된다. 
						if(username.equals("9999")) {
							//만일 본인이 이 페이지의 간리자라면, id에 9999와 비밀번호에 0을 입력하면, admin으로 로그인을 해서 회원 정보를 조회할 수 있다. 
							System.out.println("Admin Log in");
							warnFrame.setVisible(true);
							warnLabel.setText("Admin Log in");
							adminPanel.setLayout(null);
							frame.remove(mainPanel);
							frame.add(adminPanel);
							frame.revalidate();
							frame.repaint();
							//관리자 계정으로 로그인하면, 가입되어있는 모든 회원 데이터를 조회한다.
							String Admin = "Select * from SINFO;";
							ad=stmt.executeQuery(Admin);
							while(ad.next()) {
								data.add(ad.getString("SINFO_SSN"));
								data.add(ad.getString("SINFO_PASS"));
								data.add(ad.getString("SINFO_NAME"));
								
							}
							//출력할 때에는 adminpanel에 출력한다. 보기 좋게 보이기 위해서 JTable을 이용해서 table 형태로 출력한다. 
							String header[]= {"SINFO_SSN","SINFO_PASS","SINFO_NAME"};
							String contents[][] = new String[data.size()/3][3];
							for(int i = 0; i < data.size()/3; i++) {
								for(int j =0 ; j< 3; j++) {
									contents[i][j] = data.get(i*3 + j);	
									
								}
							}
							table = new JTable(contents, header);
							JTableHeader theader = table.getTableHeader();
							theader.setFont(new Font("Arial", Font.PLAIN, 20));

							table.setRowHeight(20);
							table.getColumn("SINFO_SSN").setPreferredWidth(20);
							table.getColumn("SINFO_PASS").setPreferredWidth(20);
							table.getColumn("SINFO_NAME").setPreferredWidth(10);
							
							jScrollPane = new JScrollPane(table);
							jScrollPane.setSize(750,300);
							jScrollPane.setLocation(0,20);
							adminPanel.add(jScrollPane);
							closeBtn.setLocation(350,350);
							closeBtn.setSize(80,40);
							adminPanel.add(closeBtn);
							
						}
					else { 
						//만일 로그인한 사용자가 admin이 아닌 회원이라면, 자신이 작성햇던 강의 평가 내역을 조회할 수 있다.
							loginPanel.setLayout(null);
							frame.remove(mainPanel);
							frame.add(loginPanel);
							frame.revalidate();
							frame.repaint();
							warnFrame.setVisible(true);
							warnLabel.setText("Login Succeeded");
							/*해당 쿼리문은 3개의 테이블에서 필요한 데이터 2개를 가져오는 쿼리문이다. 
							첫번째로 가입자 명단인 SINFO에서 로그인된  학번에 해당하는 이름을 가져온다. 이때, 
							가져온 이름은 Evaluation인 강의평가작성 테이블에서 같은 이름으로 작성된 과목 번호를 가져온다.
							가져온 과목번호를 통해서 Lectures라는 강의 목록 테이블의 강의 이름에 접근해서 최종적으로는 
							해당 학번학생이 작성한 강의 이름이 출력되도록 하였다.  */
							String LOG = "SELECT LEC_NAME, k.SINFO_NAME FROM (SELECT SINFO_NAME,EV_CONTENT FROM (SELECT SINFO_NAME,SINFO_SSN FROM SINFO) A "+
																		"JOIN Evaluation e ON A.SINFO_NAME = E.ev_nick) k,lectures l "+
																		"where (l.lec_num,k.SINFO_NAME) in (SELECT EV_LECNUM,A.SINFO_NAME FROM "+
																		"(SELECT SINFO_NAME,SINFO_SSN FROM SINFO WHERE SINFO_SSN ="+
																		username+") A JOIN Evaluation e ON A.SINFO_NAME = E.ev_nick);";
							
							
							ad=stmt.executeQuery(LOG);
							while(ad.next()) {
								login_ar.add(ad.getString("LEC_NAME"));
								login_ar.add(ad.getString("k.SINFO_NAME"));

							}
							
							String header[]= {"LEC_NAME","k.SINFO_NAME"};
							String contents[][] = new String[login_ar.size()/2][2];
							for(int i = 0; i < login_ar.size()/2; i++) {
								for(int j =0 ; j< 2; j++) {
									contents[i][j] = login_ar.get(i*2 + j);	
									
								}
							}
							table_log = new JTable(contents, header);
							JTableHeader theader = table_log.getTableHeader();
							theader.setFont(new Font("Arial", Font.PLAIN, 20));

							table_log.setRowHeight(20);
							table_log.getColumn("LEC_NAME").setPreferredWidth(20);
							table_log.getColumn("k.SINFO_NAME").setPreferredWidth(20);
							
							
							jScrollPane = new JScrollPane(table_log);
							jScrollPane.setSize(750,300);
							jScrollPane.setLocation(0,20);
							loginPanel.add(jScrollPane);
							closedBtn.setLocation(350,350);
							closedBtn.setSize(80,50);
							loginPanel.add(closedBtn);
							
						}
					}
						
					else {
						//비밀번호가 틀려서 로그인이 거부되는 경우.
						System.out.println("login failed");
						warnFrame.setVisible(true);
						warnLabel.setText("Password is wrong.");
					}
				}
				else {
					//아이디가 존재하지 않아서 로그인이 거부되는 경우.
					System.out.println("login failed");
					warnFrame.setVisible(true);
					warnLabel.setText("UserName does not exist.");


				}
			}
			//변경된 계정을 최종 저장하면, 바뀐 비밀번호로 DB를 업데이트해서 저장한다. 
			else if(mode == SAVE) {
				String Update = "update SINFO set SINFO_PASS = '" + new_passwd 
						+ "' where SINFO_NAME = '"+ username+"' ; ";
				stmt.executeUpdate(Update);
				System.out.println(Update);
			}
			//만일 본인의 계정을 삭제한다면, 해당 학번의 열에 있는 회원정보를 삭제한다. 
			else if(mode ==DELETEACCOUNT) {
				String delete = "DELETE FROM SINFO WHERE SINFO_SSN =' "+ username +"';";
				System.out.println(delete);
				stmt.executeUpdate(delete);
			}
			//관리자 모드로 진행된다면, 필요한 모든 가입자 목록을 출력해야하므로 아래와 같은 쿼리문을 작성하였다. 
			else if(mode ==ADMIN) {
				String admin = "SELECT * FROM SINFO;";
				System.out.println(admin);
				stmt.executeUpdate(admin);
			}
			//계정을 변경할때, 본인이 가입되어 있는지 확인하는 부분으로, 본인의 이름이 있는지 조회한다. 없으면, 없다고 돌아가고, 만일 있으면, 그대로 진행할 수 있다. 
			else if(mode ==CHECK) {
				col = "SINFO_NAME";
				what = username;

				String Check = "select * from SINFO where "+col + " like'"+what +"';";
				System.out.println(Check);
				rs=stmt.executeQuery(Check);
				if(rs.next()) {
					if(username.equals(rs.getString("SINFO_NAME"))){
						
						System.out.println("ACCOUNT EXIST");
					}
						
					else {
						System.out.println("login failed");
						warnFrame.setVisible(true);
						warnLabel.setText("NO ACCOUNT TRY AGAIN");
				
						}
				}
				else {
						System.out.println("FILL THE BOX");
						warnFrame.setVisible(true);
						warnLabel.setText("FILL THE BOX.");


					}
			
				}
			
		}
		//발생할 수 있는 예외처리 과정. 
		catch(ClassNotFoundException e) {
			e.printStackTrace();
		}
		catch(SQLException e) {
			e.printStackTrace(); 
		}
	
	}
	
}

		

		
		
	
		
		


