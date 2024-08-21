<?php
/**
 * @version		1.2.0 - 2023-09
 * @author	    web-eau.net
 * @package		mod_callback
 * @copyright	Copyright (C) 2022 - web-eau.net - All rights reserved.
 * @license		GNU General Public License version 2 or later; 
 */
 
 
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

$showform = true;
$errormessage = "";
$request = Factory::getApplication()->input->request;

$buttonSubmit =$request->get('mod_callback_form_submit');
$recipient = $params->get('mod_callback_recipient');
$mod_callback_phonenumber_length =  $params->get('mod_callback_phonenumber_length');

$contact_phone	= $request->get('contact_phone');
$contact_name	= $request->get('contact_name');

$subjectandbody = $contact_name.' '.JText::_( 'MOD_CALLBACK_MAIL_TEXT' ).' : '.$contact_phone."\r\n\r\n";


if(isset($_POST['mod_callback_form_submit'])){

	if($contact_phone != "" && $contact_phone != JText::_( 'MOD_CALLBACK_PHONE' ) && $contact_name != "" && $contact_name != JText::_( 'MOD_CALLBACK_NAME' ) && strlen($contact_phone) >= $mod_callback_phonenumber_length && !containsIlligalStringscallback($subjectandbody)) 
	{
		// if($recipient == "demo@web-eau.net")
		// {
		// 	$errormessage = "Message not send. The module is in demo mode";	
		// }
		// else
		// {
			$mail = JFactory::getMailer();
			if(stripos($recipient,";") > 0){
				$recipient = explode(";", $recipient);
			}		
			$mail->addRecipient($recipient);
			$mail->setSubject($subjectandbody);
			$mail->setBody($subjectandbody);
			if ($mail->Send() === true)
			{
				
				$redirectUrl =  $params->get('mod_callback_redirect');
				if($redirectUrl != ""){
					
					header("Location: ".$redirectUrl, true);
				}
				else
				{
					$showform = false;
				}
			}
			else
			{
				$errormessage = "Mail could not be send. Please check your mail settings in Joomla global configuration.";	
			}
		//}
	}
	else
	{
		$errormessage = "Form is not valid";	
	}
}

function containsIlligalStringscallback($str)
{
	$str = strtolower($str);
	if(strpos($str, "@") !== false) return true;
	if(strpos($str, "http") !== false) return true;
	if(strpos($str, "www") !== false) return true;
	if(strpos($str, "viagra") !== false) return true;
	if(strpos($str, "penis") !== false) return true;
	
	return false;
}
?>

<script type="text/javascript">
<!--
	function validateForm( frm ) {
		if(frm.contact_name.value == '') {
			alert("<?php echo JText::_( 'MOD_CALLBACK_NAME_ERROR' );?>");
			return false;
		}
		if(frm.contact_name.value == '<?php echo JText::_( 'MOD_CALLBACK_NAME' );?>') {
			alert( "<?php echo JText::_( 'MOD_CALLBACK_NAME_ERROR' );?>");
			return false;
		}
		if(frm.contact_phone.value == '<?php echo JText::_( 'MOD_CALLBACK_PHONE' );?>') {
			alert( "<?php echo JText::_( 'MOD_CALLBACK_PHONE_ERROR' );?>");
			return false;
		}
		if(frm.contact_phone.value == '') {
			alert( "<?php echo JText::_( 'MOD_CALLBACK_PHONE_ERROR' );?>");
			return false;
		}
		if(frm.contact_phone.value.length < <?php print $mod_callback_phonenumber_length; ?> ) {
			alert( "<?php echo JText::sprintf( 'MOD_CALLBACK_PHONE_NUMBER_LENGTH_ERROR',$mod_callback_phonenumber_length );?>");
			return false;
		}
		
		return true;
	}
// -->
<!--
	function doClear( formField ) {
		if (formField.value == '<?php echo JText::_( 'MOD_CALLBACK_NAME' );?>' ){
				formField.value = "";
			}
		if (formField.value == '<?php echo JText::_( 'MOD_CALLBACK_PHONE' );?>' ){
				formField.value = "";
			}
	}
// -->

</script>


<?php
	if ($showform == true){
	if($params->get('mod_callback_headline') != ""){
?>
    <h4 class="callback_headline"><?php echo $params->get('mod_callback_headline');?></h4>
<?php
	}
?>
    <p class="callback_pretext"><?php echo $params->get('mod_callback_intro');?></p>
    <form action="" method="post" class="form-validate" id="mod_itf_form" name="mod_itf_form" onsubmit="return validateForm(this);">
    <input type="hidden" name="action" value="CallMeUp" />
    <p class="callback_form_name"><input onclick="doClear(this)" type="text" id="contact_name" name="contact_name" value="<?php echo JText::_( 'MOD_CALLBACK_NAME' );?>" class="inputbox input-medium" /></p>
    <p class="callback_form_phone"><input type="text"  onclick="doClear(this)" id="contact_phone" name="contact_phone" value="<?php echo JText::_( 'MOD_CALLBACK_PHONE' );?>" class="inputbox input-medium" /></p>
    <p class="callback_form_submit"><input type="submit" name="mod_callback_form_submit" value="<?php echo JText::_( 'MOD_CALLBACK_SUBMIT' );?>" class="button" /></p>
    </form>
<?php
	}else{			
?>
	<h4 class="callback_headline"><?php echo $params->get('mod_callback_headline');?></h4>
	<p class="callback_confirm_text"><?php echo $params->get('mod_callback_confirm');?></p>
<?php
	}
	
	if($errormessage != "")
	{
		print "<div style=\"color: red;\">".$errormessage."</div>";	
	}
	$hidelink = "";
	 if ($params->get('mod_callback_hide_credit')==1){
		 $hidelink = "display: none;";
	 }
	 print "<div style=\"text-align: right; padding-right: 4px; font-size: 10px;".$hidelink."\"><a title=\"". JText::_( 'MOD_CALLBACK_CREDIT_LINK_TITLE' )."\"  href=\"https://web-eau.net\" style=\"color:#aaaaaa;\">web-eau.net</a></div>";
?>

