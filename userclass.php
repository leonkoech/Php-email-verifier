<?php 
	//require '../vendor/autoload.php';
	//include the server connector
	include "serverconnect.php";
	include_once "mailerclass.php";
	// include_once "alert.php";
	// class phpAlert{
	// 	function phpAlert($msg) {
	// 		echo '<script type="text/javascript">alert("'.$msg.'")</script>';
	// 	}
	// }

	class User{
		protected $db;
		public function __construct(){
			$this->db = new DB_con();
			$this->db = $this->db->ret_obj();
		}
		//registration of new users
		public function reg_user($fname, $lname, $uname, $upassword, $uemail){	

			//this is to prevent mysql injection with trim
			 $fname=trim($fname);
			 $lname=trim($lname);
			 $uname=trim($uname);
			 $uemail=trim($uemail);
			 $upassword=trim($upassword);
			
			//encrypting the password		
			$hashed_password = password_hash($upassword, PASSWORD_DEFAULT);

			//creating the unique key with usernamr email and the date
			//$unique_key = $uname . $uemail . date('mY');
			//making the unguessable
			$unique_key = md5($uname);
			
			//checking if the username or email is available in db
			$query = "SELECT * FROM users WHERE username='$uname' OR email='$uemail'";
			
			$result = $this->db->query($query) or die($this->db->error);
			
			$count_row = $result->num_rows;
			
			//if the username is not in the database, then insert to the table
			
			if($count_row == 0){
				$query = "INSERT INTO users SET uniqueid='$unique_key', username='$uname', userpassword='$hashed_password', firstname='$fname',lastname='$lname', email='$uemail',active=0";
				$resultt=$this->db->query($query) or die ($this->db->error);
				if(isset($resultt))
				{
						/*send the email*/
						//Create a new PHPMailer instance
						//change this baseurl value as per your file path
						$mailbody = "
						<p>Hi ".$uname.",</p>
						<p>Thanks for Registration. Your email is ".$uemail.", Your password will work only after your email verification.</p>
						<p>Please Open this link to verify your email address - http://localhost/phpprojects/final/emailver.php?uniqueuserid=".$unique_key."
						<p>Best Regards,<br />Your Webmaster hahaha</p>
						";
						$companyname='van der keons';
						$subject='Confirm your '.$companyname.' email';
						$mailer= new Mailerclass();
						$mailer->sendemail($subject,$uemail,$mailbody,'');
						

				}
				else{
					$this->db->error;
				}
				return true;
			}
			else{
				echo '<script type="text/javascript">alert("A user with the same username already exists")</script>';
				// $alert=new phpAlert();
				// $msg='';
				// $alert->phpAlert($msg);
				return false;
			}
			
			
    }
			
			
	 //loging in users
		public function check_login($emailusername, $upassword){

			$emailusername=trim($emailusername);
			$upassword=trim($upassword);
        $hashed_password = password_hash($upassword, PASSWORD_DEFAULT);
		//check if user exists
		$connect = new PDO('mysql:host=localhost;dbname=sidetest', 'root', '');
		$query = "SELECT * from users WHERE email='$emailusername' or username='$emailusername' and userpassword='$hashed_password'";
		$result= $connect->prepare($query);
		$result->execute();
		$rowcount = $result->rowCount();
        //checking if user exists
        if($rowcount == 1)
        {
		$stmnt = $result->fetchAll();
		
			
				foreach ($stmnt as $count_row) {
					# code...
					if($count_row['active']==1){
						if(password_verify($upassword, $hashed_password)) {
							// If the password inputs matched the hashed password in the form
							// log them in.
							$_SESSION['login'] = true; // this login var will use for the session 
							$_SESSION['id'] = $count_row['id'];
							header("location:main.php");
							return true;
						} 
						else{
							echo '<script type="text/javascript">alert("this doesnt normally happen but your password 
							doesnt match with the one in our database please refresh and enter again")</script>';
	
							// $alert=new phpAlert();
							// $alert->phpAlert('');
							return false;
						}
					}
					//if user is not verified
					elseif($count_row['active']==0){
						//now check if user is verified
						//because the user already exists I'm just going to check username or email
						//and checkins status of activity if it equals 1 which means it is verified
						$connect = new PDO('mysql:host=localhost;dbname=sidetest', 'root', '');
						$getmail = "SELECT username from users WHERE email='$emailusername' or username='$emailusername' and active=0";
						$resultmail= $connect->prepare($getmail);
						$resultmail->execute();
	
						$mresult = $resultmail->fetchAll();
						foreach ($mresult as $column) {
							$unique_key=$column['username'];
							$unique_key=md5($unique_key);
							header("location:notactive.php?uniqueuserid=".$unique_key."");
						}
	
	
					}
				}               
	    }
			
		else{
			echo '<script type="text/javascript">alert("Wrong username or email")</script>';
			// $alert=new phpAlert();
			// $alert->phpAlert('Wrong username or email');
			
		}
		
	}
	 //loging in Admin
	 public function check_loginadmin($emailusername, $upassword){
		$hashed_password = password_hash($upassword, PASSWORD_DEFAULT);
		
		$query = "SELECT id from admins WHERE email='$emailusername' or username='$emailusername' and adminpassword='$hashed_password'";

		$result = $this->db->query($query) or die($this->db->error);
		
		$user_data = $result->fetch_array(MYSQLI_ASSOC);
		$count_row = $result->num_rows;
		//checking if user exists
		if ($count_row == 1) {
            if(password_verify($upassword, $hashed_password)) {
                // If the password inputs matched the hashed password in the database
                // Do something, you know... log them in.
                $_SESSION['login'] = true; // this login var will use for the session thing
	            $_SESSION['id'] = $user_data['id'];
	            return true;
            } 
               
	        }
			
		else{
			//either the username or password is wrong
			//but bc it's the admin I won't tell them what's wrong
			echo '<script type="text/javascript">alert("either the username or password is wrong")</script>';
			// $alert=new phpAlert();
			// $alert->phpAlert('');
			return false;
		}
	
	}
		//get inactive users
		public function activeusers(){
			$query="SELECT username FROM users WHERE active = 1";
			$result=$this->db->query($query) or die ($this->db->error);
			echo '<table>';
			while ($rowtwo = $result->fetch_array(MYSQLI_ASSOC)){
				echo '<tr>
					
					<td><font size="5" face="Lucida Sans Unicode" color=black>'.$rowtwo['username'].'</td>
					</tr>';
			}
			echo '</table>';
		}
	//get inactive users
	public function inactiveusers(){
		$query="SELECT username FROM users WHERE active = 0";
		$result=$this->db->query($query) or die ($this->db->error);
		echo '<table>';
		while ($rowtwo = $result->fetch_array(MYSQLI_ASSOC)){
			echo '<tr>
				
				<td><font size="5" face="Lucida Sans Unicode" color=black>'.$rowtwo['username'].'</td>
				</tr>';
		}
		echo '</table>';
	}
	//creating a function to fetch username
	public function get_username($uid){
		$query = "SELECT username FROM users WHERE id = '$uid'";
		
		$result = $this->db->query($query) or die($this->db->error);
		
		$user_data = $result->fetch_array(MYSQLI_ASSOC);
		echo $user_data['username'];
		
	}
	//creating a function to fetch email address
	public function get_email($uid){
		$query = "SELECT email FROM users WHERE id = '$uid'";
		
		$result = $this->db->query($query) or die($this->db->error);
		
		$user_data = $result->fetch_array(MYSQLI_ASSOC);
		echo $user_data['email'];
		
	}
		//creating a function to fetch admin username
		public function get_adminusername($userid){
			$query = "SELECT username FROM admins WHERE id = '$userid'";
			
			$result = $this->db->query($query) or die($this->db->error);
			
			$user_data = $result->fetch_array(MYSQLI_ASSOC);
			echo $user_data['username'];
			
		}
	
	//function to start the session
	public function get_session(){
	    return $_SESSION['login'];
		}
	//function to logout the user
	public function user_logout() {
	    $_SESSION['login'] = FALSE;
		unset($_SESSION);
	    session_destroy();
	}
	//function for resetting password by sending an email first
	public function resetpasswordlink($emailusername){
		$query = "SELECT * from users WHERE email='$emailusername' or username='$emailusername'";
		$result = $this->db->query($query) or die($this->db->error);
		//checking if user exists
		$countrow= $result ->num_rows;
		if ($countrow==1) {
			$connect = new PDO('mysql:host=localhost;dbname=sidetest', 'root', '');
			//send email for password verification
			$getmail = "SELECT email,username from users WHERE email='$emailusername' or username='$emailusername'";
			$resultmail= $connect->prepare($getmail);
			$resultmail->execute();

				$mresult = $resultmail->fetchAll();
				foreach ($mresult as $column) {
					$em=trim($column['email']) ;
					$na=$column['username'];
						$uniquekey = md5($na);
						$subject='Password Reset Request';
						$mailbody = "
						<p>Hi ".$na.",</p>
						<p>We have received a request to reset your password</p>
						<p>Please Open this link to reset password - http://localhost/phpprojects/final/resetpassword.php?qid=".$uniquekey."
						<p>and if it wasnt you please ignore this email.
						<p>Best Regards,<br />Leon the Webmaster</p>
						";
						$mailer= new Mailerclass();
						$mailer->sendemail($subject,$em,$mailbody,'');  
						if($mailer){
							echo '<script type="text/javascript">alert("email has been sent")</script>';

							// $alert=new phpAlert();
							// $alert->phpAlert('email has been sent');
							return true;
						}
						else{
							header('location: errors.php');
							return false;
						}
				}
			//first find the username of the human
			$findusername="SELECT * FROM users WHERE email='$emailusername' or username='$emailusername'";
			$usernameresult= $this->db->query($findusername) or die ($this->db->error);
			$uusername = $usernameresult->fetch_array(MYSQLI_ASSOC);
			foreach ($uusername as $username) {
				# code..
				//next we find the email adress so that we can send the email
				$findemail= "SELECT * FROM users WHERE email='$emailusername' or username='$emailusername'";
				$emailresult= $this->db->query($findemail) or die ($this->db->error);
				$email = $emailresult->fetch_array(MYSQLI_ASSOC);
				foreach ($email as $uemail) {
					# code...

				}		
			}
			     
	        }
			
		else{
			echo '<script type="text/javascript">alert("wrong username or email")</script>';

			// $alert=new phpAlert();
			// $alert->phpAlert('wrong username or email');
		}
	
		}
		//after the email has been received and link clicked
		public function resetpassword($newpassword,$username){
		$query = "UPDATE userpassword FROM users where username='$username'";
		}
		public function resendemail(){
						//creating the unique key with usernamr email and the date
						$unique_key = $uname . $uemail . date('mY');
						//making the unguessable
						$unique_key = password_hash($unique_key, PASSWORD_DEFAULT);
			}
}