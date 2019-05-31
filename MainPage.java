import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.*;

//class MainPage implements ActionListener{
public class MainPage{
	public static final int DEFAULT = 0;
	public static final int LOGINCHECK = 1;
	
	ArrayList<String> data = new ArrayList<String>();
	String username;
	String passwd;
	String what;
	String col;
	int mode = DEFAULT;
	static 	String url = "jdbc:mysql://localhost:3306/fortest?characterEncoding=UTF-8&serverTimezone=UTC";
	static final String user = "root";
	static final String password = "password";
	Connection conn = null;
	Statement stmt = null;
	ResultSet rs = null;
	Scanner sc = new Scanner(System.in);
	
	
		JFrame frame = new JFrame("Login Program");
		JPanel mainPanel = new JPanel();
		JLabel mainUserLabel = new JLabel("UserName");
		JTextField mainUserField = new JTextField("");
		JLabel pwLabel = new JLabel("Password");
		JPasswordField pwField = new JPasswordField();
		JButton loginBtn = new JButton("Log in");
		JButton createBtn =	new JButton("Create Account");
		JScrollPane jScrollPane;
		JFrame warnFrame = new JFrame();
		JLabel warnLabel = new JLabel();
		JButton warnBtn = new JButton("Got it");
		
		
		Dimension dim_Frame = new Dimension(1600,900);
		Dimension dim_Label = new Dimension(300,30);
		Dimension dim_Field = new Dimension(300,40);
		Dimension dim_Button = new Dimension(300,70);
		Dimension dim_SButton = new Dimension(150,70);
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
		
		loginBtn.addActionListener(new ButtonAction());
		createBtn.addActionListener(new ButtonAction());
		
		mainPanel.setFont(new Font("Arial", Font.BOLD, 20));
		frame.add(mainPanel);
		
		mainPanel.add(mainUserLabel);
		mainPanel.add(mainUserField);
		mainPanel.add(pwLabel);
		mainPanel.add(pwField);
		mainPanel.add(loginBtn);
		mainPanel.add(createBtn);
		
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
				System.out.println("GO TO PHP! ");
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
				col = "STU_SSN";
				what = username;
				
				String search = "select * from students_reg where " + col + " like '" + what +"';";
				//System.out.println(search);
				rs = stmt.executeQuery(search);
				if(rs.next()) {
					if(passwd.equals(rs.getString("STU_SSN"))){
						warnFrame.setVisible(true);
						warnLabel.setText("Login Succeeded");
						System.out.println("login succeeded");
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
		}
		catch(ClassNotFoundException e) {
			e.printStackTrace();
		}
		catch(SQLException e) {
			e.printStackTrace(); 
		}
	
	}
	
}

		

		
		
	
		
		


