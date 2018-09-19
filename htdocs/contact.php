<?php
session_start();

$pageTitle="Contact CM Business Services for Bookkeeping Services & Financial Reporting";
$metaDescription="Contact your local Madison bookkeeping service provider - CM Business Services. We can provide your small business with expert bookkeeping services. Our experienced team can help with all your financial reporting, payroll management, quickbooks training and bookkeeping duties. And these are just some of the services we offer!";
$metaKeywords="Madison Bookkeeping Services";

$errormsg = '';

if($_REQUEST) {

	include_once 'securimage/securimage.php';
	$securimage = new Securimage();
	if ($securimage->check($_POST['captcha_code']) == false) {
  		$errormsg = 'The verification code you entered was incorrect. Please try again.';
	} else {
        echo 'test0';
	    $debug = true;

        // is the referrer valid
        $parts = parse_url($_SERVER['HTTP_REFERER']);
        if($parts['host'] !== 'cmbusinessservices.com' && $parts['host'] !== 'www.cmbusinessservices.com') exitsend('invalid referrer');

        if($_SERVER['HTTP_USER_AGENT'] == '') { // if this has not been set then assume its not a person and exit
            exitsend('http_user_agent is not set');
        }

        // exit if the fields contain a URL
        foreach($_REQUEST as $key => $name) {
            if(strpos($name,'</a>') !== false) exitsend('field contains link');
            if(strpos($name,'<img') !== false) exitsend('field contains image html');
            if(strpos($name,'< img') !== false) exitsend('field contains image html');
            if(strpos($name,'/>') !== false) exitsend('field contains html');
            if(strpos($name,'/ >') !== false) exitsend('field contains html');

            if(strpos($key,'</a>') !== false) exitsend('key contains link');
            if(strpos($key,'http') !== false) exitsend('key contains link');
            if(strpos($key,'www.') !== false) exitsend('key contains link');
            if(strpos($key,'<img') !== false) exitsend('key contains image html');
            if(strpos($key,'< img') !== false) exitsend('key contains image html');
            if(strpos($key,'/>') !== false) exitsend('key contains html');
            if(strpos($key,'/ >') !== false) exitsend('key contains html');
        }

        $to = 'cara@cmbusinessservices.com';
        //$to = 'q@qto.nz';
		$subject = 'bookkeeping needs';
		//if(trim($_REQUEST['email']) == '') $from = $to; else $from = $_REQUEST['email'];
		$from = $to;
		$body = "Enquiry from website:

Entity: $_REQUEST[entity]
Employees: $_REQUEST[employees]
Type: $_REQUEST[type]
Referral: $_REQUEST[referral]
Name: $_REQUEST[name]
Address: $_REQUEST[address]
City: $_REQUEST[city]
State: $_REQUEST[state]
Zip: $_REQUEST[zip]
Email: $_REQUEST[email]
Comments: $_REQUEST[comments]";


        include_once "swml/lib/swift_required.php";
        $transport = Swift_SmtpTransport::newInstance('email-smtp.us-east-1.amazonaws.com', 25, 'tls');
        $transport->setUsername('AKIAJX37425UYIHJ37FA');
        $transport->setPassword('AqU2hEbGRvOsXJA4kfeONLE40L6NafHzvRBAZPqbuBT/');
        $swift = Swift_Mailer::newInstance($transport);
        $message = new Swift_Message($subject);
        $message->setFrom(array($from => $from));
        $message->setBody($body, 'text/plain');
        $message->setTo($to);
        $recipients = $swift->send($message, $failures);



		header('Location: thankyou.php');
		exit;
	}

}

include("includes/header.php");
?>


			<div id="content">
           
                
             <h1>Contact Us</h1>
             
             <p><strong>C M Business Services Contact Details</strong></p>
             
			<table width="100%" cellpadding="5">
				<tr>
				<td valign="top"><p><strong>Madison Office</strong><br />
					Carson Wilhite, Manager<br />
					6516 Monona Drive, #115<br />
					Madison, WI 53716</p>
             		<p>Phone: (608) 241-4526<br />
             			Fax: (262) 364-2107</p>
				</td>
				<td valign="top"><p><strong>Auckland Office</strong><br />
					Cara Martinson, Owner<br />
					PO Box 305-199<br />
					Triton Plaza, Auckland 0757</p>
					<p>Fax: (262) 364-2107</p>
				</td>
				</tr>
			</table>
                 
             </div>
			</div>
					
		
<?php

function exitsend($reason) {
    global $debug;
	echo 'The sending of this request has been stopped because the information being sent is not trusted. Please go back and change the information or use another means of contact.<br /><br />';
	if($debug === true) echo $reason;
	exit;
}

include("includes/footer.php");

?>