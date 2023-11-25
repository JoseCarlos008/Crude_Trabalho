<html>
<head>
    <title>Usuários Salvos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
       body {background-color: #333;
        color: white;
    }
</style>
<style>
    #formEditar {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #f1f1f1;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 300px;
        color: black;
    }
</style>

</head>
<body>
    <div id="formEditar">
        <span id="close" style="float: right; cursor: pointer;">&times;</span>
        <h2>Editar Usuário</h2>
        <form id="editarForm">
            <label for="nome">Nome:</label><br>
            <input type="text" id="nome" name="nome"><br>
            <label for="nickName">Usuário:</label><br>
            <input type="text" id="nickName" name="nickName"><br>
            <label for="senha">Senha:</label><br>
            <input type="password" id="senha" name="senha"><br>
            <input type="hidden" id="userId" name="userId">
            <input type="submit" value="Salvar">
        </form>
    </div>

<?php
/*
 * Método de conexão sem padrões
*/

$username = "root";
$password = "";


try {
    $conn = new PDO('mysql:host=localhost;dbname=cedup', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = $conn->query('SELECT * FROM usuarios');
    echo '<div class="container">';
    echo '<div class="container">';
    echo '<table id="tabela01" class="table">';
    echo ' <thead>';
    echo '<tr><th>Id</th><th>Nome</th><th>Usuário</th><th>Senha</th><th>Ações</th></tr>';
    echo ' <thead>';
    
    foreach($data as $row) {
        echo '<tr>';
        echo '<td>' . $row["id"] . '</td>';
        echo '<td>' . $row["nome"] . '</td>';
        echo '<td>' . $row["nickName"] . '</td>';
        echo '<td>' . $row["senha"] . '</td>';
        echo '<td><a href="#"><img onclick="excluir('.$row['id'].')" src="lixeira.png" style="width:20px;height:20px></a>
        <a href="#"><img onclick="editar('.$row['id'].')" style="width:20px; heigth:20px;" src="editar.png"></a></td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '</div>';
    echo '</div>';
    
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
 ?>
<script>
    $(document).ready(function(){
            $('#editarForm').on('submit', function(e){
        // Impede o envio normal do formulário
        e.preventDefault();

        // Obtenha os detalhes do usuário do formulário
        var userId = $('#userId').val();
        var nome = $('#nome').val();
        var nickName = $('#nickName').val();
        var senha = $('#senha').val();

        // Faça uma requisição AJAX para atualizar os detalhes do usuário
        $.ajax({
            url: 'atualizarDetalhes.php',
            type: 'POST',
            data: {
                userId: userId,
                nome: nome,
                nickName: nickName,
                senha: senha
            },
            success: function(result){
                // Retorno se tudo ocorreu normalmente
                alert("Detalhes atualizados com sucesso");
                
                // Recarrega a página
                window.location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Retorno caso algum erro ocorra
                alert("Erro ao atualizar detalhes");
            }
            });
        });

    });
</script>

</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    function excluir(userId) {
        // Aqui você pode usar o ID do usuário para a lógica que deseja implementar
         
        // Exemplo: faça uma requisição AJAX para excluir o usuário no servidor
     
      // Dados que você quer enviar
        const datas = {
          'id': userId
         
        };
        var dados = JSON.stringify(datas);

        // Opções da requisição
         $.ajax({
            url: 'excluir.php',
            type: 'POST',
            data: {data: dados},
            success: function(result){
              // Retorno se tudo ocorreu normalmente
              alert("Excluido");
            },
            error: function(jqXHR, textStatus, errorThrown) {
              // Retorno caso algum erro ocorra
              alert("Erro ao excluir");
            }
        });
        // Recarrega a página
        window.location.reload();
       
    }
    function editar(userId) {
    // Aqui você pode usar o ID do usuário para a lógica que deseja implementar
         
    // Exemplo: faça uma requisição AJAX para obter os detalhes do usuário no servidor
     
    // Dados que você quer enviar
    const datas = {
      'id': userId
    };
    var dados = JSON.stringify(datas);

    // Opções da requisição
     $.ajax({
        url: 'obterDetalhes.php',
        type: 'POST',
        data: {data: dados},
        success: function(result){
          // Retorno se tudo ocorreu normalmente
          // Supondo que o resultado seja um objeto JSON com os detalhes do usuário
          var user = JSON.parse(result);
          
          // Preencha os campos do formulário com os detalhes do usuário
          $('#nome').val(user.nome);
          $('#nickName').val(user.nickName);
          $('#senha').val(user.senha);
          $('#userId').val(user.id);
          
          // Mostre o formulário
          $('#formEditar').show();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          // Retorno caso algum erro ocorra
          alert("Erro ao obter detalhes");
        }
    });
}
$('#close').click(function() {
        $('#formEditar').hide();
    });


</script>


</html>