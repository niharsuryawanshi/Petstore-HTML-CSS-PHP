<?php


function client_val(){
	echo"hello client</br>";
	$f_name=$_POST['f_name'];
	$l_name=$_POST['l_name'];
	$email01=$_POST['email01'];
	$phone01=$_POST['phone01'];
	$bname=$_POST['b_name'];
	
	$val_flag = 0;

	if(empty($f_name)|empty($l_name)|empty($email01)){
		echo"First name, Last name and email are mandatory feilds";
		echo"</br>Please enter all feilds and resubmit again";
		$val_flag=1;
	}

	$name_regex="/[a-zA-z]+/";
	if(!preg_match($name_regex,$f_name)){
		echo"Please enter valid first name";
		$val_flag=1;
	}
	if(!preg_match($name_regex,$l_name)){
		echo"Please enter valid last name";
		$val_flag=1;
	}

	
	$email_regex = "/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/";
	if(!preg_match($email_regex,$email01)){
		echo"Please enter valid email";
		$val_flag=1;
	}

	$phone_regex = "/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/";
	if(!preg_match($phone_regex,$phone01)){
		echo"Please enter valid phone";
		$val_flag=1;
	}	

	//connect to db and client table
	if($val_flag==0){
		$db = mysqli_connect('localhost','root','','petstore') or die('Error connecting to DB');
		$query1 = "INSERT INTO `client` (`cid`, `f_name`, `l_name`, `email`, `phone`, `b_name`) VALUES (NULL, '$f_name','$l_name' ,'$email01','$phone01','$bname')";
		
		// 1 for client rid
		$query2 = "INSERT INTO `user` (`email`, `password`, `rid`) VALUES ('$email01', '1234567', 1)";


		if (mysqli_query($db,$query1)) {

			//save the user
			if(mysqli_query($db,$query2)){

				mail($email01,"Welcome to Petstore","Password is 1234567");
				//email();
			
				echo"Thanks you for registering with us.";
				echo"</br>";
				echo"We have sent you an email with the password. please use that to login";
				echo"</br>";
			}
		}
		else{
			echo"Something Wrong please contact the system admin";
		}
	}

}

function service_val(){
	
	$f_name=$_POST['f_name'];
	$l_name=$_POST['l_name'];
	$email01=$_POST['email01'];
	$phone01=$_POST['phone01'];
	$bname=$_POST['b_name'];
	
	$val_flag = 0;

	if(empty($f_name)|empty($l_name)|empty($email01)){
		echo"First name, Last name and email are mandatory feilds";
		echo"</br>Please enter all feilds and resubmit again";
		$val_flag=1;
	}

	$name_regex="/[a-zA-z]+/";
	if(!preg_match($name_regex,$f_name)){
		echo"Please enter valid first name";
		$val_flag=1;
	}
	if(!preg_match($name_regex,$l_name)){
		echo"Please enter valid last name";
		$val_flag=1;
	}

	
	$email_regex = "/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/";
	if(!preg_match($email_regex,$email01)){
		echo"Please enter valid email";
		$val_flag=1;
	}

	$phone_regex = "/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/";
	if(!preg_match($phone_regex,$phone01)){
		echo"Please enter valid phone";
		$val_flag=1;
	}	

	//connect to db and service table
	if($val_flag==0){
		$db = mysqli_connect('localhost','root','','petstore') or die('Error connecting to DB');
		$query1 = "INSERT INTO `service` (`sid`, `f_name`, `l_name`, `email`, `phone`, `b_name`) VALUES (NULL, '$f_name','$l_name' ,'$email01','$phone01','$bname')";
		
		// 2 for client rid
		$query2 = "INSERT INTO `user` (`email`, `password`, `rid`) VALUES ('$email01', '1234567', 2)";


		if (mysqli_query($db,$query1)) {

			//save the user
			if(mysqli_query($db,$query2)){

				mail($email01,"Welcome to Petstore","Password is 1234567");
			
				echo"Thanks you for registering your Service with us.";
				echo"</br>";
				echo"We have sent you an email with the password. please use that to login";
				echo"</br>";
			}
		}
		else{
			echo"Something Wrong please contact the system admin";
		}
	}

}


function login_val(){

	$username=$_POST['u_name'];
	$password=$_POST['pwd'];
	$val_flag=0;

	//check if the username or password field is empty
	if(empty($username)|empty($password)){
		echo"Please fill in all the feilds and resubmit again";
		//if this flag is 1 then do not enter entries in the database
		$val_flag=1;
	}

	$email_regex = "/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/";
	if(!preg_match($email_regex,$username)){
		echo"Please enter valid email";
		$val_flag=1;
	}

	//if the value flag is 0, then validation is passed.
	if($val_flag==0){

		$db = mysqli_connect('localhost','root','','petstore') or die('Error connecting to DB');
		$query1="select * from user WHERE email ='$username' and password = '$password'";

		if($result = mysqli_query($db,$query1)){

			$row= mysqli_fetch_row($result);
			$count= mysqli_num_rows($result);
			//checks if there are records.

			if($count == 1){				
				//load view according the roles
				//1 equals client view. 
				if($row[2]==1){
					//echo"login client";	
					header( 'Location: client_view.html' );
				}
				//2 equals service view.
				if($row[2]==2){
					//echo"login service";
					header( 'Location: service_view.html' );
				}
			}
			else{
				echo"Username or Password is incorrect";
			}
		}
		else{
			echo"Query Failure, contact system admin";
		}

	}
}



function contactus_val(){
	$f_name=$_POST['f_name'];
	$l_name=$_POST['l_name'];
	$email01=$_POST['email01'];
	$phone01=$_POST['phone01'];
	$comments=$_POST['comments'];

	$val_flag=0;
	
	if(empty($f_name)|empty($l_name)|empty($email01)|empty($comments)){
		echo"First name, Last name, Email and Comments are mandatory";
		echo"</br>Please enter all feilds and resubmit again";
	}

	$name_regex="/[a-zA-z]+/";
	if(!preg_match($name_regex,$f_name)){
		echo"Please enter valid first name";
		$val_flag=1;
	}
	if(!preg_match($name_regex,$l_name)){
		echo"Please enter valid last name";
		$val_flag=1;
	}

	$email_regex = "/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/";
	if(!preg_match($email_regex,$email01)){
		echo"Please enter valid email";
		$val_flag=1;
	}

	$phone_regex = "/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/";
	if(!preg_match($phone_regex,$phone01)){
		echo"Please enter valid phone";
		$val_flag=1;
	}	

	//Connect to DB if validation passes
	if($val_flag==0){
		$db = mysqli_connect('localhost','root','','petstore') or die('Error connecting to DB');
		$query1 = "INSERT INTO `contact_us` (`id`, `f_name`, `l_name`, `email`, `phone`, `comments`) VALUES (NULL, '$f_name','$l_name' ,'$email01','$phone01','$comments')";
	
		if (mysqli_query($db,$query1)) {
			echo"We have got your information and our executive will contact you soon";
			echo"</br>";
			echo"Plese click the button below to return to main menu";
			echo"</br>";
			echo"<a href='index01.html'><input type='button' value='Home'></a>";
		}
		else{
			echo"Something Wrong please contact the system admin";
		}
	}	
}



if(isset($_POST['action'])){
	
	switch(($_POST['action'])){
	
	case 'contactus':
		contactus_val();
		break;
	
	case 'client':
		client_val();
		break;
	
	case 'service':
		service_val();
		break;
	case 'login':
		login_val();
		break;
	}

}

?>