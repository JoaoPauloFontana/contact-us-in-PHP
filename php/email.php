<?php
    //Função para evitar um possível XSS
    function contraXSS($valor){
      $valor = trim($valor);
      $valor = stripslashes($valor);
      $valor = htmlspecialchars($valor);
      return $valor;
    }

    //Variáveis
    $erroNome = '';
    $erroEmail = '';
    $erroMensagem = '';
    $erroAssunto = '';

    //Fazendo as devidas validações
    if(empty($_POST['nome'])){
      $erroNome = "Preencha seu nome!";
    }else{
      $nome = contraXSS($_POST['nome']);
      if(!preg_match('/^[a-zA-Z \p{L}]+$/ui', $nome)){
        $erroNome = "Digite apenas letras!";
      }
    }

    if(empty($_POST['email'])){
      $erroEmail = "Informe um email!";
    }else{
      $email = contraXSS($_POST['email']);
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erroEmail = "Email inválido!";
      }
    }

    if(empty($_POST['assunto'])){
      $erroAssunto = "Informe um assunto!";
    }else{
      $assunto = contraXSS($_POST['assunto']);
    }

    if(empty($_POST['mensagem'])){
      $erroMensagem = "Informe uma mensagem!";
    }else{
      $mensagem = contraXSS($_POST['mensagem']);
    }

    //Definindo horário para o Brasil
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('d/m/Y');
    $hora = date('H:i:s', time());
    
    //Se não possuir erros, email será enviado
    if((($erroNome == '') && ($erroEmail == '') && ($erroMensagem == '') && ($erroAssunto == ''))){
    
      //Corpo EMAIL
      $corpo = "<html>
            <p><b>Nome: </b>$nome</p>
            <p><b>E-mail: </b>$email</p>
            <p><b>Mensagem: </b>$mensagem</p>
            <p>Este e-mail foi enviado em <b>$data</b> às <b>$hora</b></p>
          </html>";
        
      //Email de quem irá receber
      $destino = "seu_email@email.com";
      
      //Exibir no padrão UTF-8 os caracteres
      $cabecalho  = "MIME-Version: 1.0\n";
      $cabecalho .= "Content-type: text/html; charset=utf-8\n";
      $cabecalho .= "From: $nome <$email>";
      
      if (mail($destino, $assunto, $corpo, $cabecalho)){
        echo "Email enviado com sucesso!";
      }
    }else{
		  echo "Email não pôde ser enviado";
	  }
      
    echo "<meta http-equiv='refresh' content='10;URL=../index.html'>";
?>