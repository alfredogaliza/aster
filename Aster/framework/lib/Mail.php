<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


class Mail extends PHPMailer{
	
	public function __construct($destinatarios = [], $assunto ="", $mensagem = ""){
		
		parent::__construct();
		
		$this->setLanguage('br');
		$this->SMTPDebug = 2;
		
		$this->IsSMTP();
		$this->Timeout = 10;
		$this->Charset = 'utf8_decode()';
		
		$this->Port  = '587';
		
		// Dados do UOL
		$this->SMTPAuth  = true;
		$this->Host  = 'smtp.app.institutoaster.org.br';
		$this->Username  = 'admin@app.institutoaster.org.br';
		$this->Password  = '1Careca@';
		$this->From  = 'admin@app.institutoaster.org.br';
				
		$this->FromName  = utf8_decode('Instituto Áster');		
		$this->Subject  = utf8_decode($assunto);
		$this->Body  = utf8_decode($mensagem);
		$this->IsHTML(true);
		
		foreach($destinatarios as $nome => $endereco)
			$this->AddAddress($endereco, utf8_decode($nome));
		
	}	
	
}