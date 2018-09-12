<?php

	class Email {
	
		public static function enviar($from_name, $from_mail, $subject, $msg){			
			
			/*
			Aqui criamos uma nova instância da classe como $mail.
			Todas as características, funções e métodos da classe
			poderão ser acessados através da variável (objeto) $mail.
			*/
			$mail = new PHPMailer(); // 
			$mail->IsMail();
			//$mail->IsSMTP();
			//$mail->SMTPAuth   = "true";
			$mail->Host       = EMAIL_HOST;
			$mail->Username   = EMAIL_LOGIN;
			$mail->Password   = EMAIL_SENHA;
			
			$mail->AddAddress(EMAIL_DESTINATARIO);
			$mail->From       = $from_mail;
			$mail->FromName   = $from_name;

			$mail->IsHTML(true); //

			$mail->CharSet    = "utf-8";
			$mail->Subject    = EMAIL_ASSUNTO . ' ' . $subject;
			$mail->Body       = $msg;
	
			/*	
			$mail->Mailer = "smtp";
			$mail->SMTPSecure = "ssl"; //"tls";
			$mail->Port       = EMAIL_PORTA;
			*/		
	
			//$mail->SMTPDebug  = true;
			
			// Controle de erro ou sucesso no envio
			if (!$mail->Send())
			{
				return false;			 
			} else{
				return true;			 
			}			
		}
	}