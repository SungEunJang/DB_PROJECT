import javax.swing.*;
import javax.swing.table.JTableHeader;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.*;
import java.io.IOException;

//class MainPage implements ActionListener{
public class MainPage{
	public static final int DEFAULT = 0;
	public static final int LOGINCHECK = 1;
	public static final int CHANGEACCOUNT = 2;
	
	public static final int SAVE = 3;
	public static final int DELETEACCOUNT =4;
	public static final int ADMIN = 5;
	public static final int CHECK= 6;
	
	ArrayList<String> data = new ArrayList<String>();
	String username;
	String passwd;
	String what;
	String col;
	String name;
	String new_passwd;
	String email;
	
	int mode = DEFAULT;
	int check = 0;
	int checkboxnum;
	int adminLog = 0;
	static 	String url = "jdbc:mysql://localhost:3306/test?characterEncoding=UTF-8&serverTimezone=UTC";
	static final String user = "root";
	static final String password = "password";
	Connection conn = null;
	Statement stmt = null;
	ResultSet rs = null;
	ResultSet ad = null;
	Scanner sc = new Scanner(System.in);
	
	
		JFrame frame = new JFrame("SOOK PLACE_LOG");
		JPanel mainPanel = new JPanel();
		JPanel adminPanel = new JPanel();
		JLabel mainUserLabel = new JLabel("UserName");
		JTextField mainUserField = new JTextField("");
		JLabel pwLabel = new JLabel("Password");
		JPasswordField pwField = new JPasswordField();
		JButton loginBtn = new JButton("Log in");
		JFrame editFrame = new JFrame("Change data");
		JLabel editLabel = new JLabel("Change to what?");
		JTextField editText = new JTextField();
		JButton editBtn = new JButton("Okay");
		JButton createBtn =	new JButton("Create Account");
		JButton changeBtn = new JButton("Change Account");
		JScrollPane jScrollPane;
		JFrame warnFrame = new JFrame();
		JLabel warnLabel = new JLabel();
		JButton warnBtn = new JButton("Got it");
		JFrame createFrame = new JFrame("Change Account");
		JPanel createPanel = new JPanel();
		JPanel deletePanel = new JPanel();
		JLabel changeLabel = new JLabel("Change your Info");
		JFrame askFrame = new JFrame();
		JLabel askLabel = new JLabel();
		JButton askBtn1 = new JButton("Yes");
		JButton askBtn2 = new JButton("No");
		JButton closeBtn = new JButton("CLOSE");
		JLabel userModeLabel = new JLabel("UserMode");
		JLabel changeInfoLabel = new JLabel("Change Info");
		Dimension dim_Frame = new Dimension(750,800);
		Dimension dim_Label = new Dimension(300,30);
		Dimension dim_Field = new Dimension(300,40);
		Dimension dim_Button = new Dimension(300,70);
		Dimension dim_SButton = new Dimension(150,70);
		JButton DeleteBtn = new JButton("Delete Account");
		JPanel userPanel = new JPanel();
		JTable table;

		JButton [] newBtn = new JButton[3];
		JLabel [] newLabel = new JLabel[4];
		
		
		JTextField [] userField = new JTextField[6];
		JTextField [] newField = new JTextField[6];
		
		JButton [] deleteBtn = new JButton[3];
		JLabel [] deleteLabel = new JLabel[3];
		//JTextField [] userField = new JTextField[6];
		JTextField [] deleteField = new JTextField[6];
		
		public static void main(String[] args) {
			new MainPage();
		}
		
	public MainPage() {
		
		frame.setVisible(true);
		frame.setSize(dim_Frame);
		frame.setLocation(0, 0);
		frame.setResizable(false);
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		
		mainPanel.setLayout(null);
		mainUserLabel.setLocation(50, 10);
		mainUserLabel.setSize(dim_Label);
		mainUserField.setLocation(50, 40);
		mainUserField.setSize(dim_Field);
		pwLabel.setSize(dim_Label);
		pwLabel.setLocation(50, 110);
		pwField.setSize(dim_Field);
		pwField.setLocation(50, 140);
		loginBtn.setSize(dim_Button);
		loginBtn.setLocation(50, 210);
		
		createBtn.setSize(dim_Button);
		createBtn.setLocation(50, 280);
		changeBtn.setSize(dim_Button);
		changeBtn.setLocation(50,350);
		DeleteBtn.setSize(dim_Button);
		DeleteBtn.setLocation(50, 420);
		
		DeleteBtn.addActionListener(new ButtonAction());
		loginBtn.addActionListener(new ButtonAction());
		createBtn.addActionListener(new ButtonAction());
		changeBtn.addActionListener(new ButtonAction());
		closeBtn.addActionListener(new ButtonAction());
		mainPanel.setFont(new Font("Arial", Font.BOLD, 20));
		frame.add(mainPanel);
		
		mainPanel.add(mainUserLabel);
		mainPanel.add(mainUserField);
		mainPanel.add(pwLabel);
		mainPanel.add(pwField);
		mainPanel.add(loginBtn);
		mainPanel.add(createBtn);
		mainPanel.add(changeBtn);
		mainPanel.add(DeleteBtn);
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
		
		deleteLabel[0] = new JLabel("UserName");
		deleteField[0] = new JTextField();
		deleteLabel[1] = new JLabel("Before Password");
		deleteField[1] = new JTextField();
		deleteLabel[2] = new JLabel("E-mail");
		deleteField[2] = new JTextField();
		
		deleteBtn[0] = new JButton("OK");
		deleteBtn[1] = new JButton("Cancel_delete");
		
		
		
		
	}
	class ButtonAction implements ActionListener{
		public void actionPerformed(ActionEvent e) {
			JButton myButton = (JButton)e.getSource();
			String temp = myButton.getText();
			
			if(temp.equals("Log in")) {
				username = mainUserField.getText();
				passwd = new String(pwField.getPassword());
				mainUserField.setText("");
				pwField.setText("");

				mode = LOGINCHECK;
				System.out.println("Login 정보 " + username + " " + passwd);
				command();
			}
			else if(temp.equals("Create Account")) {
				Runtime runtime = Runtime.getRuntime();
				try {
					runtime.exec("explorer.exe http://localhost/index.php");
				} catch (IOException ex) {
				}
			}
			else if(temp.equals("Change Account")) {
				mode = CHANGEACCOUNT;
				createPanel.setLayout(null);
				frame.remove(mainPanel);
				frame.add(createPanel);
				frame.revalidate();
				frame.repaint();
				
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
				

				else if(temp.equals("Got it")){
					warnFrame.setVisible(false);
				}
				else if(temp.equals("Save")) {				
					mode = SAVE;
					String warnMessage = "";
					warnMessage ="Success!";
						System.out.println("new account added");
						username = newField[0].getText();
						passwd = newField[1].getText();
						new_passwd = newField[2].getText();
						
						email = newField[3].getText();

						//for(int i = 0; i < newField.length; i++) {
							//newField[i].setText(" ");
						//}
						command();
						warnLabel.setText("Account created! Login with your Account!");
						warnFrame.setVisible(true);
						frame.remove(createPanel);
						frame.add(mainPanel);
						frame.revalidate();
						frame.repaint();
						mode = DEFAULT;
						check = 0;
					}
				else if(temp.equals("Delete Account")) {
					
					deletePanel.setLayout(null);
					frame.remove(mainPanel);
					frame.add(deletePanel);
					frame.revalidate();
					frame.repaint();
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
				else if(temp.equals("CLOSE")) {
					frame.remove(adminPanel);
					frame.add(mainPanel);
					frame.revalidate();
					frame.repaint();
					mode =DEFAULT;
				}
				else if(temp.equals("OK")) {				
					mode = DELETEACCOUNT;
					String warnMessage = "";
					warnMessage ="Your account was deleted";
						System.out.println("Delete aCCOUNT");
						username = deleteField[0].getText();
						passwd = deleteField[1].getText();
						

						command();
						warnLabel.setText("Account Delete!");
						warnFrame.setVisible(true);
						frame.remove(deletePanel);
						frame.add(mainPanel);
						frame.revalidate();
						frame.repaint();
						mode = DEFAULT;
						check = 0;
					}

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
				else if (temp.equals("Check")) {
					username = newField[0].getText();
					newField[0].setText("");
					mode =CHECK;
					command();
					
				}
				
			}
		}
	
		
	
	public void command() {
		try {
			Class.forName("com.mysql.jdbc.Driver"); 
			// JDBC 드라이버 로드
			conn = DriverManager.getConnection(url,user,password);
			System.out.println("드라이버 연결 성공!");
			

			stmt = conn.createStatement();
			
			String useXproject = "use fortest";
			stmt.executeUpdate(useXproject);
			
			if(mode == LOGINCHECK) {
				col = "SINFO_SSN";
				what = username;
				
				String search = "select * from SINFO where " + col + " like '" + what +"';";
				//System.out.println(search);
				rs = stmt.executeQuery(search);
				if(rs.next()) {
					if(passwd.equals(rs.getString("SINFO_PASS"))){
						if(username.equals("9999")) {
							System.out.println("Admin Log in");
							warnFrame.setVisible(true);
							warnLabel.setText("Admin Log in");
							adminPanel.setLayout(null);
							frame.remove(mainPanel);
							frame.add(adminPanel);
							frame.revalidate();
							frame.repaint();
							String Admin = "Select * from SINFO;";
							ad=stmt.executeQuery(Admin);
							while(ad.next()) {
								data.add(ad.getString("SINFO_SSN"));
								data.add(ad.getString("SINFO_PASS"));
								data.add(ad.getString("SINFO_NAME"));
								
							}
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
							jScrollPane.setLocation(20,20);
							adminPanel.add(jScrollPane);
							closeBtn.setLocation(400,550);
							closeBtn.setSize(80,40);
							adminPanel.add(closeBtn);
							
						}
						else {
						warnFrame.setVisible(true);
						warnLabel.setText("Login Succeeded");
						System.out.println("login succeeded");
						}
					}
						
					else {
						System.out.println("login failed");
						warnFrame.setVisible(true);
						warnLabel.setText("Password is wrong.");
					}
				}
				else {
					System.out.println("login failed");
					warnFrame.setVisible(true);
					warnLabel.setText("UserName does not exist.");


				}
			}
			else if(mode == SAVE) {
				String Update = "update SINFO set SINFO_PASS = '" + new_passwd 
						+ "' where SINFO_NAME = '"+ username+"' ; ";
				stmt.executeUpdate(Update);
				System.out.println(Update);
			}
			else if(mode ==DELETEACCOUNT) {
				String delete = "DELETE FROM SINFO WHERE SINFO_SSN =' "+ username +"';";
				System.out.println(delete);
				stmt.executeUpdate(delete);
			}
			else if(mode ==ADMIN) {
				String admin = "SELECT * FROM SINFO;";
				System.out.println(admin);
				stmt.executeUpdate(admin);
			}
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
		catch(ClassNotFoundException e) {
			e.printStackTrace();
		}
		catch(SQLException e) {
			e.printStackTrace(); 
		}
	
	}
	
}

		

		
		
	
		
		


