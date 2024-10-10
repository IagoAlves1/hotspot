<?php

if (isset($_POST['submit'])) {
    include_once('conexao.php');

    // Escapando os valores para evitar injeção SQL e inserindo corretamente
    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $celular = mysqli_real_escape_string($conexao, $_POST['celular']);

    // Consulta SQL corrigida com aspas ao redor dos valores
    $query = "INSERT INTO informacoes(cpf, email, celular) VALUES ('$cpf', '$email', '$celular')";

    // Executando a consulta
    $result = mysqli_query($conexao, $query);

   // if ($result) {
   //     echo "Dados inseridos com sucesso!";
   // } else {
    //    echo "Erro ao inserir os dados: " . mysqli_error($conexao);
    //}
}


//
//    echo 'CPF: ' . htmlspecialchars($_POST['cpf']) . '<br>';
//    echo 'E-mail: ' . htmlspecialchars($_POST['email']) . '<br>';
//    echo 'Celular: ' . htmlspecialchars($_POST['celular']) . '<br>';
//}
?>





<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Satélite norte - Login</title>

    <style>
                * {
            margin: 0;
            padding: 0;
            border: 0;
            font-family: sans-serif, Arial;
            box-sizing: border-box;
            font-size: 16px;
        }

        body, html {
            min-height: 100%;
            overflow-x: hidden;
            background-image: url('img/backgroud\ satelite\ norte.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat no-repeat;
            background-attachment: fixed;
        }

        .main {
            min-height: calc(100vh - 90px);
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background-color: rgba(248, 144, 46, 0.3);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 1);
            padding: 40px;
            width: 100%;
            max-width: 370px;
            position: absolute;
            top: 30%;
        }

        input, label {
            display: block;
            width: 100%;
            margin-bottom: 20px;
        }

        input[type=cpf], 
        input[type=text], 
        input[type=email] {
            border: 1px solid #ccc;
            height: 44px;
            padding: 3px 20px;
            border-radius: 6px;
            background-color: #ffffff;
        }

        input[type=submit] {
            background: #ff8b1f;
            color: #000000;
            border: 0;
            cursor: pointer;
            height: 44px;
            border-radius: 6px;
            font-weight: bold;
        }

        input[type=submit]:hover {
            background:  hsl(29, 100%, 60%);
        }

        .info {
            text-align: center;
            margin-top: 20px;
            color: #fff;
        }

        .checkbox-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }

        input[type="checkbox"]:checked {
            accent-color: hsl(32, 100%, 56%); 
        }

        .texto-checkbox{
            color: hwb(0 0% 100%);
            font-weight: bold;
            position: absolute;
            top: 60%;
            left: 20%;
            font-size: 13px;
        }
    </style>

    <script>
        const validaCPF = (cpf) => {
            cpf = cpf.replace(/\D/g, '');

            if (cpf.length !== 11) {
                alert('CPF inválido. Documento não possui 11 caracteres.');
                return false;
            }

            const proximoDigitoVerificador = (cpfIncompleto) => {
                let somatoria = 0;
                for (let i = 0; i < cpfIncompleto.length; i++) {
                    let digitoAtual = cpfIncompleto.charAt(i);
                    let constante = (cpfIncompleto.length + 1 - i);
                    somatoria += Number(digitoAtual) * constante;
                }
                const resto = somatoria % 11;
                return resto < 2 ? "0" : (11 - resto).toString();
            }

            let primeiroDigitoVerificador = proximoDigitoVerificador(cpf.substring(0, 9));
            let segundoDigitoVerificador = proximoDigitoVerificador(cpf.substring(0, 9) + primeiroDigitoVerificador);
            let cpfCorreto = cpf.substring(0, 9) + primeiroDigitoVerificador + segundoDigitoVerificador;

            if (cpf !== cpfCorreto) {
                alert('CPF inválido.');
                return false;
            }

            return true;
        }

        function validarFormulario(event) {
            const cpfInput = document.querySelector('input[name="cpf"]').value;
            if (!validaCPF(cpfInput)) {
                event.preventDefault();
            }
        }
    </script>
</head>

<body>
    <div class="main">
        <div class="card">
            <form name="login" action="alogin.html" method="POST" onsubmit="validarFormulario(event)">
                
                <label>
                    <input name="onibus" type="text" placeholder="Número do ônibus" required />
                </label>

                <label>
                    <input type="text" name="cpf" placeholder="CPF" minlength="11" maxlength="11" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </label>
                
                <label>
                    <input name="username" type="email" placeholder="E-mail" required />
                </label>
                
                <label>
                    <input name="celular" type="text" placeholder="Celular" minlength="11" maxlength="11" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                </label>
                
                <div class="checkbox-container">
                    <label style="display: flex; align-items: center; color: hsl(0, 0%, 100%); font-weight: bold;">
                        <input required name="termos" type="checkbox" style="margin-right: 100%;">
                    </label>
                    <div class="texto-checkbox">
                        Li e estou de acordo com o Termo de Uso e Política de Privacidade
                    </div>
                </div>

                <input type="submit" name="submit" id="submit" />
            </form>
            <p class="info"><b>Powered by StarStore | CNPJ: 48.978.560/0001-41</b></p>
        </div>
    </div>
</body>

</html>
