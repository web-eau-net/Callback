<?php
/**
 * @version		1.2.0 - 2023-09
 * @author	    web-eau.net
 * @package		mod_callback
 * @copyright	Copyright (C) 2022 - web-eau.net - All rights reserved.
 * @license		GNU General Public License version 2 or later; 
 */
 
// No direct access
defined('_JEXEC') or die;
	
	class modCallBackHelper
	{
	    function SendCallMeBack( $recipient,$subject, $body )
	    {
				$mail = JFactory::getMailer();
				
				if(stripos($recipient,";") > 0){
					$recipient = explode(";", $recipient);
				}
			/*	
				if($recipient == "demo@web-eau.net")
				{
					return true;	
				}*/

				$mail->addRecipient($recipient);
				$mail->setSubject($subject);
				$mail->setBody($body);
				$sent = $mail->Send();
				return $sent;
	    }
	}
?>