<?php
require "../configurações/segurança.php";
try{

    include "../configurações/conexao.php";

    if(!isset($_GET['id'])){
        die('Acesse pela listagem');
    }

    $query = $conexao->PREPARE("SELECT * FROM produto WHERE id=:id");
    $query->bindValue(":id", $_GET['id']);

    $resultado = $query->execute();

    if($query->rowCount()==0){
        exit("Objeto não encontrado");
    }

    $linhaproduto = $query->fetchObject();

}catch (PDOException $exception){
    echo $exception->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Form-Editar produto</title>
</head>
<body>

<?php
include ("../configurações/bootstrap.php");
include ("../configurações/menu.php");

?>

<div class="container">
    <h1> Editar - produto</h1>
    <form action="editar_produto.php" method="post" class="jsonForm">

        <div class="form-group">
            <label for="id">ID</label>
            <input class="form-control" id="id" type="text" name="id" readonly value="<?php echo $linhaproduto->id;?>">
        </div>

        <div class="form-group">
            <label for="nome">Nome</label>
            <input class="form-control" id="nome" type="text" name="nome" value="<?php echo $linhaproduto->nome;?>">
        </div>

        <div class="form-group">
            <label for="valor">valor</label>
            <input class="form-control" id="valor" type="number" name="valor" min="0" step="0.01" value="<?php echo $linhaproduto->valor;?>">
        </div>

        <div class="form-group">
            <label for="descricao">descricao</label>
            <textarea class="form-control" id="descricao" type="text" name="descricao"><?php echo $linhaproduto->descricao;?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar produto</button>
    </form>
</div>

<script>
    $(document).ready(function (){
        $('.jsonForm').ajaxForm({
            dataType: 'json',
            success: function (data) {
                if(data.status==true) {
                    iziToast.success({
                        message: data.mensagem,
                        onClosing: function(){
                            history.back();
                        }
                    });

                }else{
                    iziToast.error({
                        message: data.mensagem
                    });
                }
            },
            error:function (data){
                 iziToast.error({
                       mensage:'Servidor retornou erro. '
                  });
             }
        });
    });
</script>

</body>
</html>
