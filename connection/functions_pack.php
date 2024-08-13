<?php 
//error_reporting(0);
//error_reporting(E_ALL); 
//ini_set("display_errors", 1);
$UserTypes=array(1=>"Administrator");

function GetUserType($type_id)
{
	global $UserTypes;
	return $UserTypes[$type_id];
}

function jk_website_down_message()
{
	return 0;
}

function jk_mysql_datetime()
{
	//$ACCOUNT_CLOSE =jk_select_data(ACCOUNT_CLOSE," order by account_close_id DESC");
		     $stop_date = date('Y-m-d')." ".date("H:i:s");
	return $stop_date;
}

//@ Desc: Show Website Alert with message and sub message
//@ Parm: $msg heading as string, $submsg as sub heading as string
//@ Dependancy: File @include/mail_templates/info_pages/website_alert.php
function jk_alert($msg,$submsg="")
{
$body= file_get_contents(ADMININC.'mail_templates/website_alert.html');
$body= stripcslashes($body);
$body=str_replace("#MESSAGE#",$msg,$body);
$body=str_replace("#SUBMESSAGE#",$submsg,$body);
$error_page=1;
echo $body;
die();
}

// @ Desc: Return a Red Div Box with given Message
// @ Parm: $msg as String 
// @ Dependancy: Nothing
function jk_form_error($msg)
{
return'<div class="alert-msg">		<div class="alert alert-danger alert-msg" style="margin-bottom:0px !important">'.$msg.'</div></div>';
}

// @ Desc: Return a Green Div Box with given Message
// @ Parm: $msg as String 
// @ Dependancy: Nothing
function jk_form_ok($msg)
{
return '<div class="alert-msg no-print">		<div class="alert alert-success" style="margin-bottom: 0px;">'.$msg.'</div></div>';
}

function isMobile() {
    if(isset($_SERVER['HTTP_USER_AGENT']) and !empty($_SERVER['HTTP_USER_AGENT'])){
       $user_ag = $_SERVER['HTTP_USER_AGENT'];
       if(preg_match('/(Mobile|Android|Tablet|GoBrowser|[0-9]x[0-9]*|uZardWeb\/|Mini|Doris\/|Skyfire\/|iPhone|Fennec\/|Maemo|Iris\/|CLDC\-|Mobi\/)/uis',$user_ag)){
          return true;
       }else{
          return false;
       };
    }else{
       return false;    
    };
}


// @ Desc: Check Valid Admin User or not
// @ Parm: Username and Password from ADMINLOGIN table
// @ Dependancy: ADMINLOGIN TABLE
function jk_check_admin_login($emp_code,$password, $varMac)
{
	// echo $emp_code;
	global $CN;
	$emp_code = mysqli_real_escape_string($CN,$emp_code);
	$password = mysqli_real_escape_string($CN,$password);
	$sql="select * from ".USER." where user_name='$emp_code' and password='".jk_encrypt_password($password,20)."' AND status=1";
	$result=mysqli_query($CN,$sql);
	if(mysqli_num_rows($result)>0)
	{
		$row=mysqli_fetch_array($result);
		
		$useragent=$_SERVER['HTTP_USER_AGENT'];

		$isMobile	=	(bool)preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
		
		//if($row['user_role']==3 && $isMobile)
			//return 0;
			
			//1C-1B-0D-29-0D-89
		/*if($row['user_role']==3 && $varMac==''){
			
			return 0; 
		}*/
		
		$_SESSION['ActiveLogin'.SESSION_TOKEN]		=	$row['user_id'];
		$_SESSION['ActiveUsername'.SESSION_TOKEN]	=	$row['user_name'];
		$_SESSION['NAME'.SESSION_TOKEN]				=	$row['name'];
		$_SESSION['ActiveEmail_id'.SESSION_TOKEN]	=	$row['email_id'];
		$_SESSION['lineboy_no'.SESSION_TOKEN]		=	$row['lineboy_no'];
		$_SESSION['isadmin'.SESSION_TOKEN]			=	$row['isadmin'];
		$_SESSION['ActiveLoginType'.SESSION_TOKEN]	=	$row['user_role'];
		$_SESSION['AdminLogged'.SESSION_TOKEN]		=	$row['name'];
		$_SESSION['line_code'.SESSION_TOKEN] = '';
		
		return 1;
	}else
	return 0; 
}

function jk_check_admin_otp($user_id)
{
	// echo $emp_code;
	global $CN;
	$emp_code = mysqli_real_escape_string($user_id);

	$sql="select * from ".USER." where user_id='$user_id' AND status=1";
	$result=mysqli_query($CN,$sql);
	if(mysqli_num_rows($result)>0)
	{
		$row=mysqli_fetch_array($result);
		$_SESSION['ActiveLogin'.SESSION_TOKEN]=$row['user_id'];
		$_SESSION['ActiveUsername'.SESSION_TOKEN]=$row['user_name'];
		$_SESSION['NAME'.SESSION_TOKEN]=$row['name'];
		$_SESSION['ActiveEmail_id'.SESSION_TOKEN]=$row['email_id'];
		$_SESSION['lineboy_no'.SESSION_TOKEN]=$row['lineboy_no'];
		$_SESSION['isadmin'.SESSION_TOKEN]=$row['isadmin'];
		$_SESSION['ActiveLoginType'.SESSION_TOKEN]=$row['user_role'];
		$_SESSION['AdminLogged'.SESSION_TOKEN]=$row['name'];

		return 1;
	}else
	return 0; 
}

// @ Desc: Return a Encyrpted Password with Defined Salts on Config.Website.inc.php
// @ Parm: Password String, and Encrypted Password Random Length defualt is 20
// @ Dependancy: defines: PASS_SALT_1, PASS_SALT_2
function jk_encrypt_password($str,$len=20) {
$new_pword = '';
if( defined('PASS_SALT_1') ):
   $new_pword .= md5(PASS_SALT_1);
endif;
$new_pword .= md5($str);
if( defined('PASS_SALT_2') ):
   $new_pword .= md5(PASS_SALT_2);
endif;
return substr($new_pword, strlen($str), $len);
} 

// @ Desc: Get Admin Logged User Name
// @ Parm: Nothing;
// @ Dependancy: ADMINLOGIN TABLE
function jk_get_admin_user_name()
{
	global $CN;
	$admin_user_id=$_SESSION['ActiveLogin'.SESSION_TOKEN];
	$row=SelectQuery(USER,"where user_id='$admin_user_id'");
	return ucfirst($row['user_name']);
}

// @ Desc: Check Valid Email and TLD;
// @ email as string
// @ Dependancy: Nothing;
function jk_valid_email($email) {
   if (substr_count($email, '@') != 1)
      return false;
   if ($email{0} == '@')
      return false;
   if (substr_count($email, '.') < 1)
      return false;
   if (strpos($email, '..') !== false)
      return false;
   $length = strlen($email);
   for ($i = 0; $i < $length; $i++) {
      $c = $email{$i};
      if ($c >= 'A' && $c <= 'Z')
         continue;
      if ($c >= 'a' && $c <= 'z')
         continue;
      if ($c >= '0' && $c <= '9')
         continue;
      if ($c == '@' || $c == '.' || $c == '_' || $c == '-')
         continue;
      return false;
   }
   $TLD = array (
         'COM',   'NET',
         'ORG',   'MIL',
         'EDU',   'GOV',
         'BIZ',   'NAME',
         'MOBI',  'INFO',
         'AERO',  'JOBS',
         'MUSEUM'
      );
   $tld = strtoupper(substr($email, strrpos($email, '.') + 1));
   if (strlen($tld) != 2 && !in_array($tld, $TLD))
      return false;
   return true;
}

// @ Desc: Fix Table AutoNumber counting after deleting last record;
// @ Param: Table as TABLE NAME
// @ Dependancy: Nothing;
function jk_fix_autonumber($table)
{
	global $CN;
	$sql="select * from ".$table;
	$result=mysqli_query($CN,$sql);
	$count=mysqli_num_rows($result);
	$sql="ALTER TABLE ".$table." AUTO_INCREMENT =$count";
	mysqli_query($CN,$sql);
}

// @ Desc: Create a Random Password String specified length
// @ Parm: Random String Length as integer
// @ Dependancy: Nothing
function jk_random_password($length=7) {
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;

    while ($i < $length) {
        $num = rand() % 35;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}

// @ Desc: Generate a New Admin password and Send a Password to their associated Admin Mail
// @ Param: String as Email address, and Random Passwrod Length as defined
// @ Dependancy TBL_ADMINLOGIN - Function: jk_random_password, jk_encrypt_password, jk_send_password_mail
function jk_forget_password($email,$len=20)
{
	global $CN;
	$sql="select user_name,password from ".USER." where email_id='$email'";
	$result=mysqli_query($CN,$sql);
	if(mysqli_num_rows($result)>0)
	{
		$row=mysqli_fetch_array($result);
		$username=$row["user_name"];
		$new_password_plain=jk_random_password();
		$new_password=jk_encrypt_password($new_password_plain,$len);
		$sql="update ".USER." set password='$new_password' where email_id='$email'";
		mysqli_query($CN,$sql);
		jk_send_password_mail($email,$username,$new_password_plain);
		return 1;
	}
	else
	return 0;
}

// @ Desc: Send a Password Mail to Member
// @ Parm: To Address, UserName, New Password String;
// @ Dependancy: class.phpmailer.pho, File @ Include/mail_settings.php, File @ include/mail_templates/forgetpassword.html
function jk_send_password_mail($to,$username,$newpassword)
{
	date_default_timezone_set('America/Toronto');
	require_once(ADMININC.'class/PHP_Mailer/class.phpmailer.php');
	//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
	$mail             = new PHPMailer();	
	$body             = file_get_contents(ADMININC.'mail_templates/forgetpassword.html',true);
	$body= stripcslashes($body);
	$body=str_replace("#USERNAME#",$username,$body);
	$body=str_replace("#PASSWORD#",$newpassword,$body);
	
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
											   // 1 = errors and messages
											   // 2 = messages only
	$mail->SMTPAuth   = SMTP_AUTH;                  // enable SMTP authentication
	$mail->SMTPSecure = SMTP_SECURE;                 // sets the prefix to the servier
	$mail->Host       = SMTP_HOST;      // sets GMAIL as the SMTP server
	$mail->Port       = SMTP_PORT;                   // set the SMTP port for the GMAIL server
	$mail->Username   = SMTP_USER;  // GMAIL username
	$mail->Password   = SMTP_PASS;            // GMAIL password
	
	$mail->SetFrom(NOREPLYMAIL, SENDERNAME);
	$mail->AddReplyTo(NOREPLYMAIL,SENDERNAME);
	$mail->Subject    = FORGETPASSWORD;
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	$mail->MsgHTML($body);
	$address = $to;
	$mail->AddAddress($address,$username );
	
	if(!$mail->Send()) 
	{
	jk_alert("Mailer Error: " . $mail->ErrorInfo);
	}else{
	  return true;
	}
}

function jk_insert_data($tablename,$data)
{
	
	global $CN;
	if(!is_array($data) or $tablename=="")
	die("jk_insert_data() : Invalid Data or Invalid Table Name");
	
	$result=mysqli_query($CN,"select * from $tablename");
	$field_count=mysqli_num_fields($result);
	$field_names=array();
	for($i=0;$i<$field_count;$i++)
	$field_names[]=mysqli_fetch_field_direct($result, $i)->name;
	
	$sql="INSERT IGNORE INTO $tablename ";
	
	$fields=array();
	$values=array();
	foreach($data as $key=>$value)
	{
	if(in_array($key,$field_names))
	{
	$fields[]=$key;
	$value=trim(addslashes($value));
	$values[]="'$value'";
	}
	}
	$sql.="(".implode(",",$fields).")";
	$sql.=" VALUES (".implode(",",$values).")";
	
	if(mysqli_query($CN,$sql))
	return mysqli_insert_id($CN);
	 else
	 echo $sql;
	// die(mysqli_error($CN)."<br />$sql  at Line: ".__LINE__);
	 	$error=mysqli_errno($CN);
	// $error_details=jk_select_data(TBL_ERROR,"where error_codes='".$error."'");
		//  $error_desc=$error_details[0]['description'];
		 // echo '<div style="margin:10px; padding:10px; color:#cc2a32; border:1px solid #cc2a32; background:#f9d6d6;">'.$error_desc.'</div>';
		 // echo "<b>".$error_desc."</b>";
}

// @Desc: Updata Data to a Table with the Array of Field Data: Return True if Pass
// @Parm: TableName, Data Array, KeyField, KeyValue
// @Dependancy: $CN Connection - connect_db.php
function jk_update_data($tablename,$data,$keyfield,$valueif)
{
	//	echo '<pre>';
	//	print_r($data);
	//	exit; 
	global $CN;
	if($data==""  or $tablename=="" or $keyfield=="" or $valueif=="")
	die("jk_update_data() : Invalid Parms");
	
	$result=mysqli_query($CN, "select * from $tablename");
	$field_count=mysqli_num_fields($result);
	$field_names=array();
	for($i=0;$i<$field_count;$i++)
	$field_names[]=mysqli_fetch_field_direct($result, $i)->name;
	
	$sql="UPDATE $tablename set ";
	$fields=array();
	foreach($data as $key=>$value)
	{
	if(in_array($key,$field_names))
	{		
	$value=trim(addslashes($value));
	$fields[]=" $key='$value'";
	}
	}
	$sql.=implode(",",$fields)." where $keyfield='$valueif'";
	
	if(mysqli_query($CN,$sql))
	return true;
	else
	
	$error=mysqli_errno($CN);
	 $error_details=jk_select_data(TBL_ERROR,"where error_codes='".$error."'");
		  $error_desc=$error_details[0]['description'];
		  echo '<div style="margin:10px; padding:10px; color:#cc2a32; border:1px solid #cc2a32; background:#f9d6d6;">'.$error_desc.'</div>';
}


// @Desc: Delete a Data from table
// @Parm: TableName, KeyField to Criteria, KeyField values/ Array
// @Dependancy: $CN Connection - connect_db.php

function jk_delete_data($tablename,$keyfield,$keyvalues)
{
	global $CN;
	if($tablename=="" or $keyfield=="" or $keyvalues=="")
	die("jk_delete_data() : Invalid Data or Invalid Table Name");	
	
	$sql="DELETE from $tablename where " ;
	$values=array();
	if(is_array($keyvalues))
	{
	foreach($keyvalues as $eachvalue)
	{
	$values[]="'$eachvalue'";
	}
	}else
	{
	$values[]="'$keyvalues'";
	}
	
	$sql.="$keyfield IN (".implode(",",$values).")";
	if(mysqli_query($CN,$sql))
	{
	jk_fix_autonumber($tablename);
	return true;
	}
	else
	$error=mysqli_errno($CN);
	 $error_details=jk_select_data(TBL_ERROR,"where error_codes='".$error."'");
		  $error_desc=$error_details[0]['description'];
		  echo '<div style="margin:10px; padding:10px; color:#cc2a32; border:1px solid #cc2a32; background:#f9d6d6;">'.$error_desc.'</div>';
}



// @Desc: Return DB Result as Array
// @Parm: TableName,Fields(opt), Whereclass (opt)
// @Dependancy: $CN Connection
function jk_select_data($tablename,$where="",$fields=" * ")
{
	global $CN,$select_count;
	
	@$select_count++;
	
	if($tablename=="")
	die("jk_select_data(): Table name Required");
	
	if($where!="")
	$sql="SELECT $fields FROM $tablename $where";
	else
	$sql="SELECT $fields FROM $tablename";
	
	
	$result=mysqli_query($CN,$sql) or print(mysqli_error($CN)."jk_select_data() - <br /> $sql".__LINE__);
	$data=array();
	while($row=mysqli_fetch_assoc($result))
	{
	foreach($row as $key=>$value)
	{
	$row[$key]=stripslashes($value);
	}
	array_push($data,$row);
	
	}
	return $data;
} 
function jk_select_data_by($tablename,$where="",$fields=" * ",$byf="")
{
	global $CN,$select_count;
	
	@$select_count++;
	$by_name = $fields;
	if($fields!=" * " && $byf!="") $fields= $fields.", ".$byf;
	if($tablename=="")
	die("jk_select_data(): Table name Required");
	
	if($where!="")
	$sql="SELECT $fields FROM $tablename $where";
	else
	$sql="SELECT $fields FROM $tablename";
	
	
	$result=mysqli_query($CN,$sql) or print(mysqli_error($CN)."jk_select_data() - <br /> $sql".__LINE__);
	$data=array();
	
	while($row=mysqli_fetch_assoc($result))
	{
		$val_f = $row[$byf];
		$fn_r[$val_f] = $row[$by_name];
	}
	
	return $fn_r;
}

function jk_select_data_by_sub($tablename,$where="",$fields=" * ",$byf="")
{
	global $CN,$select_count;
	
	@$select_count++;
	$by_name = $fields;
	if($fields!=" * " && $byf!="") $fields= $fields;
	if($tablename=="")
	die("jk_select_data(): Table name Required");
	
	if($where!="")
	$sql="SELECT $fields FROM $tablename $where";
	else
	$sql="SELECT $fields FROM $tablename";
	
	
	$result=mysqli_query($CN,$sql) or print(mysqli_error($CN)."jk_select_data() - <br /> $sql".__LINE__);
	$data=array();
	
	while($row=mysqli_fetch_assoc($result))
	{
		$val_f = $row[$byf];
		$fn_r[$val_f][] = $row;
	}
	
	return $fn_r;
}

function cal_hours($hours,$minutes,$seconds){
$tot_hr=0;
						//echo "hai";		
								
								$tot_min=0;
								$tot_ss=0;
								foreach ($hours as $key=> $hrs){
								$tot_hr = $hrs+$tot_hr;
								$tot_min = $minutes[$key]+$tot_min;
								$tot_ss = $seconds[$key]+$tot_ss;
								}
								$mm=0;
								if($tot_ss>60){
								 $mm = floor($tot_ss / 60);
								 $tot_ss = $tot_ss % 60;
								 //floor($tot_min / 60);
								}
								$tot_min = $tot_min+$mm;
								$hour=0;
								if($tot_min>60){
								 $hour = floor($tot_min / 60);
								 $tot_min = $tot_min % 60;
								 //floor($tot_min / 60);
								}
								$tot_hr = $tot_hr+$hour;
								return $tot_hr.":".$tot_min.":".$tot_ss;

}
function jk_redirect_success_url($page)
{
	//echo $page;
	@header("Location:".$page);
	//header('Location: index.php?success=Password changed successfully..!');
}

function jk_loan($dl_no){
	
$emp =jk_select_data(LOAN," where dl_no = '".$dl_no."'");
$restul = $emp[0];

$restul['dl_no_new'] = $restul['dl_no'];
$restul['loan_date'] = $restul['date'];
$date_of_create =  strtotime($restul['date']);
//$due_date = strtotime(date("Y-m-d", strtotime($date_of_create)) . " +100 days");
$bill =jk_select_data(BILL,"where dl_no = '".$restul['dl_no']."' order by date DESC");
if(!empty($bill[0])){
	$restul['date'] = $bill[0]['date'];
}
$call_date = call_date();
$days = floor((strtotime($call_date) - strtotime($restul['date'])) / (60 * 60 * 24));
$interest_percentage = $restul['loan_amount']* $restul['intrest']/100;
$restul['total_days'] = $days;
 $how_many_30=1;
 $pre_cal = 0;
// echo $restul['loan_type'];
 if($restul['loan_type']=='With Loan'){
  $restul['loan_amount_c'] = $restul['loan_amount']/$restul['loan_duration'];
  
  if($days>30){
	   $days1 = $days-30;
	  $interest_percentage1 = $restul['loan_amount_c']* $restul['intrest']/100;

			if($days1>29){
						$how_many_30 = $interest_percentage1/30;
						$sub_struct_month = ($days1 / 30) ;
					$sub_struct_month = floor($sub_struct_month); 
					$sub_struct_days = ($days1 % 30); // the rest of days
					$permonth_loan_amt = $restul['loan_amount_c'] ;
					$tot_loan_with_interst=0;
					$pre_cal=0;
					for($i=1;$i<=$sub_struct_days;$i++){
						//$permonth_loan_amt_fn = $permonth_loan_amt +$tot_loan_with_inters;
						$tot_loan_with_interst = $permonth_loan_amt +$tot_loan_with_inters;
						 $interest_percentage1 = $tot_loan_with_interst* $restul['intrest']/100;
						 
						 $tot_loan_with_interst = $tot_loan_with_interst +$restul['intrest_value'];
						
					}
					$pre_cal_m = $sub_struct_month*$interest_percentage1;
						$pre_cal_d = $sub_struct_days*$how_many_30;
						
						$pre_cal = $pre_cal_m+$pre_cal_d;
						$restul['loan_amount_c'] =$tot_loan_with_interst;
					}else{
						//echo $interest_percentage;
						$how_many_30 = $interest_percentage1/30;
						$pre_cal_d = $how_many_30*$days1;
						 $pre_cal = $pre_cal_d;
					}
					$pre_cal = $restul['intrest_value']+$pre_cal; 

  }else{
	$pre_cal = $restul['intrest_value'];  
  }
 }else{
if($days>29){
	$how_many_30 = $interest_percentage/30;
	$sub_struct_month = ($days / 30) ;
$sub_struct_month = floor($sub_struct_month); 
$sub_struct_days = ($days % 30); // the rest of days

	$pre_cal_m = $sub_struct_month*$interest_percentage;
	$pre_cal_d = $sub_struct_days*$how_many_30;
	
	$pre_cal = $pre_cal_m+$pre_cal_d;
	
	
}else{
	//echo $interest_percentage;
	$how_many_30 = $interest_percentage/30;
	$pre_cal_d = $how_many_30*$days;
	 $pre_cal = $pre_cal_d;
}
 }
$interest_amount = explode('.', $pre_cal);
$restul['interest_amount'] = $interest_amount[0];
$restul['interest_amount_c'] = $interest_amount[0];
return $restul;

}
function call_date(){
	$ACCOUNT_CLOSE =jk_select_data(ACCOUNT_CLOSE," order by account_close_id DESC");
		     $stop_date = $ACCOUNT_CLOSE[0]['close_date'];
			 return $stop_date;
}
function dis_date($date){
	
		     $stop_date = $date;
			 return date('d-m-Y',strtotime($stop_date));
}
function inbank(){
	 $BANK =jk_select_data(BANK,"order by date_of_create DESC");
 return $amount = $BANK[0]['amount'];
}
function inledger(){
		
		if(!isset($_SESSION['THITTAM'])){
			$branch_no	=	$_SESSION['branch'];
			$DAYBOOK =jk_select_data(DAYBOOK,"where branch_no='$branch_no'");
			
			if(!empty($DAYBOOK)){
				$_SESSION['THITTAM']	=	$DAYBOOK[0]['daybook_no']."_thittam";
				$_SESSION['daybook_no'.SESSION_TOKEN]	=	$DAYBOOK[0]['daybook_no'];
			}
		}
		if(isset($_SESSION['THITTAM'])){
	 $LEDGER_credit =jk_select_data($_SESSION['THITTAM'],"","sum(credit)");
	 $credit = $LEDGER_credit[0]['sum(credit)'];
	  $LEDGER_debit =jk_select_data($_SESSION['THITTAM'],"","sum(debit)");
	 $debit = $LEDGER_debit[0]['sum(debit)'];
		}
 return $amount = $credit-$debit;
}
function inledger_date($where){
	 $LEDGER_credit =jk_select_data($_SESSION['THITTAM'],$where,"sum(credit)");
	 $credit = $LEDGER_credit[0]['sum(credit)'];
	  $LEDGER_debit =jk_select_data($_SESSION['THITTAM'],$where,"sum(debit)");
	 $debit = $LEDGER_debit[0]['sum(debit)'];

 return $amount = $credit-$debit;
}
function inhand(){
	$ledger = inledger();
	$inbank = inbank();
 return $amount = $ledger - $inbank;
}
function auto_number($table_name,$prefix='',$colu=''){
	if($colu=='') $colu = $table_name;
$CUSTOMER =jk_select_data($table_name," order by ".$colu."_id DESC LIMIT 1");

	//$CUSTOMER[0]['customer_id']+1;
	$num = $CUSTOMER[0][$colu.'_id']+1;
	$num_padded = $num;
$receipt_no = $prefix. $num_padded;
return $receipt_no;
}
function auto_number_fin($table_name,$prefix='',$colu=''){
	if($colu=='') $colu = $table_name;
$CUSTOMER =jk_select_data($table_name," order by ".$colu."_id DESC LIMIT 1");

	//$CUSTOMER[0]['customer_id']+1;
	$num = $CUSTOMER[0][$colu.'_id']+1;
	$num_padded = sprintf("%04d", $num);
$receipt_no = $prefix. $num_padded;
return $receipt_no;
}


function howManyDays($startDate,$endDate) {

    $date1  = strtotime($startDate." 0:00:00");
    $date2  = strtotime($endDate." 23:59:59");
    $res    =  (int)(($date2-$date1)/86400);        
	
	$res    =	$res+1;

return $res;
} 


function howManyWeeks($startDate,$endDate) {
	
    $date1  = strtotime($startDate." 0:00:00");
    $date2  = strtotime($endDate." 23:59:59");
	
	 
	
    $res    =  (int)(($date2-$date1)/604800);        
	
	$res    =	$res+1;

return $res;
  
}
 function getMonthsInRange($startDate, $endDate) {
$months = array();
while (strtotime($startDate) <= strtotime($endDate)) {
    $months[] = array('year' => date('Y', strtotime($startDate)), 'month' => date('m', strtotime($startDate)), );
    $startDate = date('d M Y', strtotime($startDate.
        '+ 1 month'));
}

return $months;
}
 function getMonthsInRangeFull($a, $b) {
$months = array();
$i = date("Ym", strtotime($a));
while($i <= date("Ym", strtotime($b))){
    $months[] = $i;
    if(substr($i, 4, 2) == "12")
        $i = (date("Y", strtotime($i."01")) + 1)."01";
    else
        $i++;
}

return $months;
}

function dateRange( $first, $last, $step = '+1 day', $format = 'Y-m-d' ) {
    $dates = array();
    $current = strtotime( $first );
    $last = strtotime( $last );

    while( $current <= $last ) {

        $dates[] = date( $format, $current );
        $current = strtotime( $step, $current );
    }

    return $dates;
}
function balace_value($loan_id){
	$BILL =jk_select_data(BILL,"where loan_id = '".$loan_id."'","sum(total_amount)");
	$emp =jk_select_data(LOAN," where loan_id = '".$loan_id."' order by loan_id DESC");
	$bal = $emp[0]['loan_amount']-$BILL[0]['sum(total_amount)'];
	return $bal;
	
}
function balace_value_new($loan_id,$prefi){
	$BILL =jk_select_data($prefi.'bill',"where loan_id = '".$loan_id."'","sum(total_amount)");
	$emp =jk_select_data($prefi.'loan'," where loan_id = '".$loan_id."' order by loan_id DESC");
	$bal = $emp[0]['loan_amount']-$BILL[0]['sum(total_amount)'];
	return $bal;
	
}
function chit_balace_value($loan_id){
	$REQUEST_URI = $_SERVER['REQUEST_URI'];
	$ex = explode('/',$REQUEST_URI);
	if(!empty($ex[2])){
	$LOGIN_ROOT = $ex[2];
	$linename_top = explode('_',$LOGIN_ROOT); 
	$METHODSESSION_TOKEN = $linename_top[1];
	}
	$prefi	=	$_SESSION['branch']."_".$METHODSESSION_TOKEN."_";
	/*$BILL =jk_select_data(BILL,"where loan_id = '".$loan_id."'","sum(total_amount)");
	$emp =jk_select_data(LOAN," where loan_id = '".$loan_id."' order by loan_id DESC");
	$chit_group_id = $emp[0]['chit_group_id'];
	$GROUP_TARIFF_START =jk_select_data(CHITGROUPTARIFF,"where chit_group_id = '".$chit_group_id."'","sum(dividend)");
	
	$bal = $emp[0]['loan_amount']-$BILL[0]['sum(total_amount)']-$GROUP_TARIFF_START[0]['sum(dividend)']*/;
	$bal	=	chit_balace_value_new($loan_id,$prefi);
	return $bal;
	
}
function chit_balace_value_new_old($loan_id,$prefi){
	$BILL =jk_select_data($prefi.'bill',"where loan_id = '".$loan_id."'","sum(total_amount)");
	$emp =jk_select_data($prefi.'loan'," where loan_id = '".$loan_id."' order by loan_id DESC");
	$chit_group_id = $emp[0]['chit_group_id'];
	$GROUP_TARIFF_START =jk_select_data('chit_group_tariff',"where chit_group_id = '".$chit_group_id."'","sum(dividend)");
	$bal = $emp[0]['loan_amount']-$BILL[0]['sum(total_amount)']-$GROUP_TARIFF_START[0]['sum(dividend)'];
	return $bal;
	
}
function chit_balace_value_less_div($loan_id,$prefi){
	
	$emp	=	jk_select_data($prefi.'loan'," where loan_id = '".$loan_id."'");
	$restul	=	$emp[0];

	$LOAN	=	$emp[0];
  	
	$tot_ins	=	0;

  	$tot_div	=	0;

  	$tot_paid	=	0;
	
	$chit_group_id = $restul['chit_group_id'];

	$GROUP_TARIFF_START		=	jk_select_data(CHITGROUPTARIFF," where chit_group_id='$chit_group_id' order by inst_no asc");
	$CHITGROUP				=	jk_select_data(CHITGROUP," where chit_group_id='$chit_group_id'");
	$st_date				=	$LOAN['date'];

  if($LOAN['add_group_date']=='0000-00-00') 

  $add_group_date = $LOAN['date'];

  else

  $add_group_date = $LOAN['add_group_date'];

  $inst_date	=	$add_group_date;

  $due_paid 			=	jk_select_data($prefi.'bill',"where loan_id = '".$loan_id."'","sum(total_amount) as tot_due");
  
 	$DUE_TOT_paid 			=	$due_paid[0]['tot_due'];
  	$DUE_TOT_paid_final	=	$DUE_TOT_paid;
	$tot_instalment_add	= 0;
  
  $avg_divident		=	0;
  $dividend_full	=	0;
  foreach($GROUP_TARIFF_START as $tstart){
	  $dividend_full		=	$dividend_full+$tstart['dividend'];
  }
  $avg_divident		= round($dividend_full/count($GROUP_TARIFF_START));
  
  $tot_less_div = 0;

  foreach($GROUP_TARIFF_START as $tstart){ 

		$strt_inst		=	 $st_date;

  		$paid 			=	jk_select_data($prefi.'bill',"where loan_id = '".$loan_id."' AND date<='$inst_date' AND date>='$st_date'","sum(total_amount)");
		
  		$inst_date_d 	= 	date("Y-m-d",strtotime($inst_date));
		
 		$inst_amount_t	=	$tstart['inst_amount'];
 
  		$dividend_t		=	$tstart['dividend'];
   		$paid_tot		=	$paid[0]['sum(total_amount)'];
   
  
		  if($inst_amount_t<=$DUE_TOT_paid){
			  $DUE_TOT_paid = $DUE_TOT_paid - $inst_amount_t;
			  
		  }else{
			  
			  $DUE_TOT_paid=0;
		  }
		  
		  $less_divitent_fu =0;
		  if($active_less_divident){
			   $less_divitent_fu = round(($avg_divident*$less_percentage)/100);
		  }
 
  #total
  if(strtotime('today')>=strtotime($inst_date))
  	$tot_less_div = $tot_less_div+$less_divitent_fu;
 
  $tot_instalment_add	=	$tot_instalment_add	+	$inst_amount_t;
  $every_paid_month		=	$every_paid_month	+	$paid_tot;
  
  if($tot_instalment_add>$every_paid_month){
	  
	  $active_less_divident	 	=	1;
	  
	  $perce_amount_due			=	$tot_instalment_add-$every_paid_month;
	  
	  $less_percentage			=	round(($perce_amount_due	* 100)/$inst_amount_t);
	  
	  $every_paid_month			=	$tot_instalment_add;
	  
  }else
  		$active_less_divident		=	0;

   		$stop_date = date('Y-m-d', strtotime($inst_date . ' +1 day'));
		
		$chit_type		=	$CHITGROUP[0]['chit_type'];
		
		if($chit_type=='15days')
   			$sql			=	"SELECT DATE_ADD('$inst_date_d', INTERVAL 15 DAY) as inst_date";
		else
			$sql			=	"SELECT DATE_ADD('$inst_date_d', INTERVAL 1 ".$chit_type.") as inst_date";

		$next_inst		=	mysqli_fetch_array(mysqli_query($sql));

		$st_date = $stop_date;

   		$inst_date		=	$next_inst['inst_date'];



   		$tot_ins = $tot_ins + $inst_amount_t;

   		$tot_div = $tot_div + $dividend_t;

		$tot_paid = $tot_paid + $paid_tot;

   		

   }
   
   return $tot_less_div;;
}

function chit_balace_value_new($loan_id,$prefi){
	
	$emp	=	jk_select_data($prefi.'loan'," where loan_id = '".$loan_id."'");
	$restul	=	$emp[0];

	$LOAN	=	$emp[0];
  	
	$tot_ins	=	0;

  	$tot_div	=	0;

  	$tot_paid	=	0;
	
	$chit_group_id = $restul['chit_group_id'];

	$GROUP_TARIFF_START		=	jk_select_data(CHITGROUPTARIFF," where chit_group_id='$chit_group_id' order by inst_no asc");
	$CHITGROUP				=	jk_select_data(CHITGROUP," where chit_group_id='$chit_group_id'");
	$st_date				=	$LOAN['date'];

  if($LOAN['add_group_date']=='0000-00-00') 

  $add_group_date = $LOAN['date'];

  else

  $add_group_date = $LOAN['add_group_date'];

  $inst_date	=	$add_group_date;

  $due_paid 			=	jk_select_data($prefi.'bill',"where loan_id = '".$loan_id."'","sum(total_amount) as tot_due");
  
 	$DUE_TOT_paid 			=	$due_paid[0]['tot_due'];
  	$DUE_TOT_paid_final	=	$DUE_TOT_paid;
	$tot_instalment_add	= 0;
  
  $avg_divident		=	0;
  $dividend_full	=	0;
  foreach($GROUP_TARIFF_START as $tstart){
	  $dividend_full		=	$dividend_full+$tstart['dividend'];
  }
  $avg_divident		= round($dividend_full/count($GROUP_TARIFF_START));
  
  $tot_less_div = 0;

  foreach($GROUP_TARIFF_START as $tstart){ 

		$strt_inst		=	 $st_date;

  		$paid 			=	jk_select_data($prefi.'bill',"where loan_id = '".$loan_id."' AND date<='$inst_date' AND date>='$st_date'","sum(total_amount)");
		
  		$inst_date_d 	= 	date("Y-m-d",strtotime($inst_date));
		
 		$inst_amount_t	=	$tstart['inst_amount'];
 
  		$dividend_t		=	$tstart['dividend'];
   		$paid_tot		=	$paid[0]['sum(total_amount)'];
   
  
		  if($inst_amount_t<=$DUE_TOT_paid){
			  $DUE_TOT_paid = $DUE_TOT_paid - $inst_amount_t;
			  
		  }else{
			  
			  $DUE_TOT_paid=0;
		  }
		  
		  $less_divitent_fu =0;
		  if($active_less_divident){
			   $less_divitent_fu = round(($avg_divident*$less_percentage)/100);
		  }
 
  #total
  if(strtotime('today')>=strtotime($inst_date))
  	$tot_less_div = $tot_less_div+$less_divitent_fu;
 
  $tot_instalment_add	=	$tot_instalment_add	+	$inst_amount_t;
  $every_paid_month		=	$every_paid_month	+	$paid_tot;
  
  if($tot_instalment_add>$every_paid_month){
	  
	  $active_less_divident	 	=	1;
	  
	  $perce_amount_due			=	$tot_instalment_add-$every_paid_month;
	  
	  $less_percentage			=	round(($perce_amount_due	* 100)/$inst_amount_t);
	  
	  $every_paid_month			=	$tot_instalment_add;
	  
  }else
  		$active_less_divident		=	0;

   		$stop_date = date('Y-m-d', strtotime($inst_date . ' +1 day'));
		
		$chit_type		=	$CHITGROUP[0]['chit_type'];
		
		if($chit_type=='15days')
   			$sql			=	"SELECT DATE_ADD('$inst_date_d', INTERVAL 15 DAY) as inst_date";
		else
			$sql			=	"SELECT DATE_ADD('$inst_date_d', INTERVAL 1 ".$chit_type.") as inst_date";

		$next_inst		=	mysqli_fetch_array(mysqli_query($sql));

		$st_date = $stop_date;

   		$inst_date		=	$next_inst['inst_date'];



   		$tot_ins = $tot_ins + $inst_amount_t;

   		$tot_div = $tot_div + $dividend_t;

		$tot_paid = $tot_paid + $paid_tot;

   		

   }
   $bal_vall= $tot_ins+$tot_less_div-$DUE_TOT_paid_final;
   
   return $bal_vall;;
}
 function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }
		
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(__FUNCTION__, $d);
        }
        else {
            // Return array
            return $d;
        }
		
		
    }
function monthly_bal_int($loan_id,$call_date, $api='', $branch=''){
	if($api){
		$LOAN_T = $api.'loan';
		$TBL_RETURN_INTEREST_T = $api.'return_interest';
		$TBL_RETURN_T = $api.'return_amount';
		$BILL_T = $api.'bill';
		$ACCOUNT_CLOSE_T = $branch."_"."account_close";
		$LOANAC_T				=	$api."loan_ac";
	}else{
		$LOAN_T = LOAN;
		$TBL_RETURN_INTEREST_T = TBL_RETURN_INTEREST;
		$TBL_RETURN_T = TBL_RETURN;
		$BILL_T = BILL;
		$ACCOUNT_CLOSE_T = ACCOUNT_CLOSE;
		$LOANAC_T				=	LOANAC;
	}
	
	
$ACCOUNT_CLOSE =jk_select_data($ACCOUNT_CLOSE_T," order by account_close_id DESC");
							$call_date = $ACCOUNT_CLOSE[0]['close_date'];
							$new_call_manual = $call_date;
						  $emp =jk_select_data($LOAN_T," where loan_id = '".$loan_id."'");
						  $restul = $emp[0];
						  $loan_table = $emp[0];
						  $dl_no	=	$loan_id;
						  $tot_fjn_xx=0;
						  $bal	=0;
						    $i =0;
							
			if($restul['loan_type']=='day_dim' || $restul['loan_type']=='day_flat'){
				
				 require('../aa_monthly/bill_day_dim_bal.php');
			  	//require('bill_with_loan.php');
			 }elseif($restul['loan_type']=='month_dim' || $restul['loan_type']=='month_flat'){
				 require('../aa_monthly/bill_monthly_bal.php');
			 }
							return $bal;
	
}
function customer_number($week=''){
	
	if(!empty($week)){
		$CUSTOMER =jk_select_data(CUSTOMER," where loan_type='$week' order by customer_id DESC LIMIT 1");
	}else{
		$CUSTOMER =jk_select_data(CUSTOMER," order by customer_id DESC LIMIT 1");
	
	}
	//$CUSTOMER[0]['customer_id']+1;
	$num = $CUSTOMER[0]['customer_no']+1;
	$num_padded = $num;
$customer_no = "". $num_padded;
return $customer_no;
}

function dp_party_number(){
	$CUSTOMER =jk_select_data(PARTY," order by dp_party_id DESC LIMIT 1");
	//$CUSTOMER[0]['customer_id']+1;
	$num = $CUSTOMER[0]['dp_party_no']+1;
	$num_padded = $num;
	$customer_no = "". $num_padded;
	return $customer_no;
}
function dp_deposit_number(){
	$CUSTOMER =jk_select_data(DEPOSIT," order by dp_deposit_id DESC LIMIT 1");
	//$CUSTOMER[0]['customer_id']+1;
	$num = $CUSTOMER[0]['dp_deposit_no']+1;
	$num_padded = $num;
	$customer_no = "". $num_padded;
	return $customer_no;
}
function dp_pay_int_number(){
	$CUSTOMER =jk_select_data(PAY_INT," order by dp_pay_int_id DESC LIMIT 1");
	//$CUSTOMER[0]['customer_id']+1;
	$num = $CUSTOMER[0]['dp_pay_int_id']+1;
	$num_padded = $num;
	$customer_no = "". $num_padded;
	return $customer_no;
}
function curl($url) 
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}
function sendsms($numbers, $mess){
//$numbers = "phone-numbers"; //enter Mobile numbers comma seperated





$fields = array(
    "sender_id" => "FSTSMS",
    "message" => $mess,
    "language" => "english",
    "route" => "p",
   "numbers" => $numbers,
);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($fields),
  CURLOPT_HTTPHEADER => array(
    "authorization: N9C2nzcZKLOl0U7F1m3boVw8ydqGrBEMujSDxfe6sPIAg4HvTJ5bngCAL4FPDvpehUVfMRHwGTioqaQd",
    "accept: */*",
    "cache-control: no-cache",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
//$err = curl_error($curl);

curl_close($curl);

//echo $response; 
return $response; 
}

function getIndianCurrency(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');

    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }

    $rupees = implode('', array_reverse($str));
    $paise = '';

    if ($decimal) {
        $paise = 'and ';
        $decimal_length = strlen($decimal);

        if ($decimal_length == 2) {
            if ($decimal >= 20) {
                $dc = $decimal % 10;
                $td = $decimal - $dc;
                $ps = ($dc == 0) ? '' : '-' . $words[$dc];

                $paise .= $words[$td] . $ps;
            } else {
                $paise .= $words[$decimal];
            }
        } else {
            $paise .= $words[$decimal % 10];
        }

        $paise .= ' paise';
    }

    return ($rupees ? $rupees . 'rupees ' : '') . $paise ;
}


function dw_loan_update($loan_id,$call_date='', $api=''){
 	if($api){
		$LOAN_T 				= 	$api.'loan';
		$TBL_RETURN_INTEREST_T 	= 	$api.'return_interest';
		$TBL_RETURN_T 			= 	$api.'return_amount';
		$BILL_T 				= 	$api.'bill';
		$ACCOUNT_CLOSE_T 		= 	ACCOUNT_CLOSE;
		$LOANAC_T				=	$api.'loan_add';
	}else{
		$LOAN_T 				= LOAN;
		$TBL_RETURN_INTEREST_T 	= TBL_RETURN_INTEREST;
		$TBL_RETURN_T 			= TBL_RETURN;
		$BILL_T 				= BILL;
		$ACCOUNT_CLOSE_T 		= ACCOUNT_CLOSE;
		$LOANAC_T				=	LOANADD;
	}
	
	$arrLOANacLo 	= 	jk_select_data($LOANAC_T,"where loan_id=".$loan_id," sum(loan_add_amount) as loan");
	$arrLoan 		=	jk_select_data($LOAN_T," where loan_id = '".$loan_id."'");
		
		$loan_amount	=	$arrLOANacLo[0]['loan']+$arrLoan[0]['loan_amount'];
		
	//$datas1['intrest_value'] 	= 	($loan_amount*$arrLoan[0]['intrest'])/100;
	$datas1['interest_date'] 	=	$arrLOANac[0]['interest_date'];
	$datas1['loan_amount']		=	$loan_amount;
	$datas1['loan_amount_actual']		=	$loan_amount;
	
	$insertRoute = jk_update_data(LOAN,$datas1,"loan_id","$loan_id");	
	
}
function monthly_loan_update($loan_id,$call_date='', $api=''){
	if($api){
		$LOAN_T 				= 	$api.'loan';
		$TBL_RETURN_INTEREST_T 	= 	$api.'return_interest';
		$TBL_RETURN_T 			= 	$api.'return_amount';
		$BILL_T 				= 	$api.'bill';
		$ACCOUNT_CLOSE_T 		= 	ACCOUNT_CLOSE;
		$LOANAC_T				=	LOANAC;
	}else{
		$LOAN_T 				= LOAN;
		$TBL_RETURN_INTEREST_T 	= TBL_RETURN_INTEREST;
		$TBL_RETURN_T 			= TBL_RETURN;
		$BILL_T 				= BILL;
		$ACCOUNT_CLOSE_T 		= ACCOUNT_CLOSE;
		$LOANAC_T				=	LOANAC;
	}
	
	$arrLOANacRe 	= 	jk_select_data(LOANAC,"where loan_id=".$loan_id," sum(return_amt) as rtn");
	$arrLOANacLo 	= 	jk_select_data(LOANAC,"where loan_id=".$loan_id," sum(loan_amt) as loan");
	$arrLoan 		=	jk_select_data($LOAN_T," where loan_id = '".$loan_id."'");
	
	
	$loan_amount	=	$arrLOANacLo[0]['loan']	-	$arrLOANacRe[0]['rtn'];
	$arrLOANac = jk_select_data(LOANAC,"where loan_id=".$loan_id." order by date DESC LIMIT 1","interest_date");
		
	if($arrLoan[0]['loan_type']=='day_dim' || $arrLoan[0]['loan_type']=='month_dim')
		$datas1['intrest_value'] 	= 	($loan_amount*$arrLoan[0]['intrest'])/100;
	else
		$datas1['intrest_value'] 	= $arrLoan[0]['intrest_value'];
	
	$datas1['interest_date'] 	=	$arrLOANac[0]['interest_date'];
	$datas1['loan_amount']		=	$loan_amount;
	$datas1['loan_amount_actual']		=	$loan_amount;
	
	 if($datas1['loan_amount']<=0){
		  $datas1['status'] ='closed';
		   }else{
			   $datas1['status'] ='open';
		}
	$insertRoute = jk_update_data(LOAN,$datas1,"loan_id","$loan_id");	
	
}


function monthly_bal_int_range($loan_id,$call_date, $api='', $start_date, $end_date){
	if($api){
		$LOAN_T = $api.'loan';
		$TBL_RETURN_INTEREST_T = $api.'return_interest';
		$TBL_RETURN_T = $api.'return_amount';
		$BILL_T = $api.'bill';
		$ACCOUNT_CLOSE_T = ACCOUNT_CLOSE;
	}else{
		$LOAN_T = LOAN;
		$TBL_RETURN_INTEREST_T = TBL_RETURN_INTEREST;
		$TBL_RETURN_T = TBL_RETURN;
		$BILL_T = BILL;
		$ACCOUNT_CLOSE_T = ACCOUNT_CLOSE;
		
	}
	
	
						  $emp =jk_select_data($LOAN_T," where loan_id = '".$loan_id."'");
						  $restul = $emp[0];
						  $tot_fjn_xx=0;
						  $i =0;
						  
						  $mm	=	 getMonthsInRangeFull($start_date, $end_date);
						  
						  foreach($mm as $date_range){
							  
							   $d_year = substr($date_range,0,4);
							   $d_month = substr($date_range,4,2);
						  
						 	$arrLOANacinterest 	= 	jk_select_data(LOANAC,"where loan_id=".$loan_id."","sum(interest_amt) as interest_amt");
							$tot_fjn_xx			=	$arrLOANacinterest[0]['interest_amt'];
							
							
							$i = $i+1;
							
							$days = floor((strtotime($call_date) - strtotime($restul['interest_date'])) / (60 * 60 * 24));
							
							$tot_months	=1;
							if($days>20){ 
							$tot_d =$days/30; $f_m =round($tot_d,2); 
							
							$array = explode('.', $f_m); $array[1] = $days%30; 
							$tot_months = $array[0];
							//if($array[1]>20) $tot_months = $tot_months +1;
							//echo $tot_months." months ";
							
							if($days>30){ 
								//echo $tot_months." months & ".$array[1]." days";
								if($array[1]) $tot_months = $tot_months+1;
							}else { //echo $days." days";
							}
							}else echo 0;
							
							$cal_daywise_interest = $tot_months * $restul['intrest_value'];
							$cal_daywise_interest = (integer)$cal_daywise_interest;
							
							$tot_fjn_xx1 = $cal_daywise_interest;
							$tot_fjn_xx = $tot_fjn_xx+$tot_fjn_xx1;
							//exit;
							$TBL_BILL_interest_paid =jk_select_data($BILL_T,"where loan_id = '".$loan_id."' order by bill_id DESC","sum(total_amount)");
							$TBL_BILL_interest_less =jk_select_data($BILL_T,"where loan_id = '".$loan_id."' order by bill_id DESC","sum(less_amount) as less_amount");
							$total_amount_paid = $TBL_BILL_interest_paid[0]['sum(total_amount)']+$TBL_BILL_interest_less[0]['less_amount'];;
						  }
							//exit;
							$bal = $tot_fjn_xx- $total_amount_paid;
							
							return $bal;
	
}



function monthly_loan_remove($loan_id,$varloan_add_amount, $api=''){
 	if($api){
		$LOAN_T 				= 	$api.'loan';
		$TBL_RETURN_INTEREST_T 	= 	$api.'return_interest';
		$TBL_RETURN_T 			= 	$api.'return_amount';
		$BILL_T 				= 	$api.'bill';
		$ACCOUNT_CLOSE_T 		= 	ACCOUNT_CLOSE;
		$LOANAC_T				=	$api.'loan_add';
	}else{
		$LOAN_T 				= LOAN;
		$TBL_RETURN_INTEREST_T 	= TBL_RETURN_INTEREST;
		$TBL_RETURN_T 			= TBL_RETURN;
		$BILL_T 				= BILL;
		$ACCOUNT_CLOSE_T 		= ACCOUNT_CLOSE;
		$LOANAC_T				=	LOANADD;
	}
	
	$arrLOANacLo 	= 	jk_select_data($LOANAC_T,"where loan_id=".$loan_id," sum(loan_add_amount) as loan");
	$arrLoan 		=	jk_select_data($LOAN_T," where loan_id = '".$loan_id."'");
		
		$loan_amount	=	$arrLOANacLo[0]['loan']+$arrLoan[0]['loan_amount']-$varloan_add_amount;
		
	//$datas1['intrest_value'] 	= 	($loan_amount*$arrLoan[0]['intrest'])/100;
	$datas1['interest_date'] 	=	$arrLOANac[0]['interest_date'];
	$datas1['loan_amount']		=	$loan_amount;
	$datas1['loan_amount_actual']		=	$loan_amount;
	
	$insertRoute = jk_update_data(LOAN,$datas1,"loan_id","$loan_id");	
	
}

function deposit_preminum_bal($dp_deposit_id){
	$arrLoan=jk_select_data(DEPOSIT,"where dp_deposit_id='$dp_deposit_id'");
	$arrLOANacLo 	= 	jk_select_data(PAY_INT,"where dp_deposit_no='".$dp_deposit_id."'"," sum(pr_amount) as prm");

	return $loan_amount	=	$arrLoan[0]['amount']-$arrLOANacLo[0]['prm'];
}

function penolity_cron(){
	
	//$fin_account[]='daily';

	//$fin_account[]='seettu';
	
	//`kym_daily_account_inout`
	//$datas_p['description']	=	'hai';
	//jk_insert_data('kym_daily_account_inout',$datas_p);
	//exit;

	$fin_account =  jk_select_data(FINLINE,"GROUP BY type, branch");

	foreach($fin_account as $line){

	$prefi = $line['branch'].'_'.$line['type']."_";
$varAcc_table	=	$line['branch']."_"."account_close";
		$ACCOUNT_CLOSE 	=	jk_select_data($varAcc_table," order by account_close_id DESC LIMIT 1");
		$currnet_d 		= 	$ACCOUNT_CLOSE[0]['close_date'];

//$currnet_d    =   call_date();
	$loan_table = $prefi.'loan';
	$bill_table = $prefi.'bill';

	$penolity_int_table = $prefi.'penolity_int';

	  $LOAN =   jk_select_data($loan_table,"where status='open' AND dead=0 AND date < DATE_ADD(NOW(), INTERVAL -2 DAY) ORDER BY loan_id ASC");

	  $p10day   =   date('Y-m-d',strtotime($currnet_d . ' -3 day'));



	  foreach($LOAN as $ln){


		  if(!empty($ln['penolity'])){

			  //=((B2*6)/100)/30

			  if($line=='seettu')

				  $bal		= chit_balace_value_new($ln['loan_id'],$prefi);
				  else
			  	$bal		= balace_value_new($ln['loan_id'],$prefi);	

				//$bal		= 	$ln['loan_amount']-$paid_amt;

			  	if($line=='seettu' && $ln['add_group_status'])

						$l_start = $ln['add_group_date'];

			  	else

				 		$l_start = $ln['date'];

			  	
			  	$how		= 	howManyDays($ln['date'],$currnet_d); 

			  	$pay_da		= 	$how;

			  	

			  if($line=='seettu')

					$duration	=	($ln['group_members']*30)+20;

			  	else

					$duration	=	$ln['loan_duration']+20;
			  

			  	$pending	=	$how-$duration;

			  	if($pending>0){

					$penolity	=	(($bal*$ln['penolity'])/100)/30;

					

					if($penolity>0){

						

					$datas_p['loan_id'] 			=   $ln['loan_id'];

					$datas_p['principal_amount']    =   $bal;

					$datas_p['penolity']  			=   $penolity;	

					$datas_p['date']  				=   $currnet_d;					

						$PENOLITY		=	jk_select_data($penolity_int_table,"where loan_id = '".$ln['loan_id']."' AND date='".$currnet_d."'","loan_id");

						

						if(empty($PENOLITY[0]['loan_id']))

							jk_insert_data($penolity_int_table,$datas_p);

					}

					

				}

			  

		  }

		  

		 



	  }

}
	
}


function paginate($item_per_page, $total_records, $total_pages, $page_url, $otherpera='')
{
    $pagination = '';
	$current_page	=	(isset($_GET['page']))? $_GET['page'] : 1;
	
	//echo "<br> current_page".$current_page;
	
    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
        $pagination .= '<ul class="pagination">';
        
        $right_links    = $current_page + 3; 
        $previous       = $current_page - 1; //previous link 
        $next           = $current_page + 1; //next link
        $first_link     = true; //boolean var to decide our first link
        
        if($current_page > 1){
		
			$previous_link = ($previous==0)?1:$previous;
            $pagination .= '<li class="first"><a class="button" href="'.$page_url.'?page=1.'.$otherpera.'" title="First">«</a></li>'; //first link
            $pagination .= '<li><a class="button" href="'.$page_url.'?page='.$previous_link.$otherpera.'" title="Previous">PREVIOUS</a></li>'; //previous link
                for($i = ($current_page-1); $i < $current_page; $i++){ //Create left-hand side links
                    if($i > 0){
                        $pagination .= '<li><a class="button" href="'.$page_url.'?page='.$i.$otherpera.'">'.$i.'</a></li>';
                    }
                }   
            $first_link = false; //set first link to false
        }
        
        if($first_link){ //if current active page is first link
            $pagination .= '<li class="first active"><a class="button">'.$current_page.'</a></li>';
        }elseif($current_page == $total_pages){ //if it's the last active link
            $pagination .= '<li class="last active"><a class="button">'.$current_page.'</a></li>';
        }else{ //regular current link
            $pagination .= '<li class="active"><a class="button">'.$current_page.'</a></li>';
        }
                
        for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
            if($i<=$total_pages){
                $pagination .= '<li><a class="button" href="'.$page_url.'?page='.$i.$otherpera.'">'.$i.'</a></li>';
            }
        }
        if($current_page < $total_pages){ 
				$next_link = ($i > $total_pages)? $total_pages : $i;
                $pagination .= '<li><a class="button" href="'.$page_url.'?page='.$next_link.$otherpera.'" title="Next" >NEXT</a></li>'; //next link
                $pagination .= '<li class="last"><a class="button" href="'.$page_url.'?page='.$total_pages.$otherpera.'" title="Last">»</a></li>'; //last link
        }
        
        $pagination .= '</ul>'; 
    }
    return $pagination; //return pagination links
}
?>
