<?php
include_once("conn.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $pedidosQuery = $conn->query("SELECT * FROM pedidos");
    $pedidos = $pedidosQuery->fetchAll(PDO::FETCH_ASSOC);
    
    // Buscar os status cadastrados
    $statusQuery = $conn->query("SELECT * FROM status");
    $status = $statusQuery->fetchAll(PDO::FETCH_ASSOC);


    $pizzas = [];

    foreach ($pedidos as $pedido) {
        $pizza = [];

        // Definindo o array para pizza
        $pizza["id"] = $pedido["pizza_id"];

        // Resgatando a pizza
        $pizzaQuery = $conn->prepare("SELECT * FROM pizzas WHERE id = :pizza_id");
        $pizzaQuery->bindPARAM(":pizza_id", $pizza["id"]);
        $pizzaQuery->execute();
        $pizzaData = $pizzaQuery->fetch(PDO::FETCH_ASSOC);

        // Resgatando a borda da pizza
        $bordaQuery = $conn->prepare("SELECT * FROM bordas WHERE id = :borda_id");
        $bordaQuery->bindPARAM(":borda_id", $pizzaData["borda_id"]);
        $bordaQuery->execute();
        $borda = $bordaQuery->fetch(PDO::FETCH_ASSOC);
        $pizza["borda"] = $borda["tipo"];

        // Resgatando a massa da pizza
        $massaQuery = $conn->prepare("SELECT * FROM massas WHERE id = :massa_id");
        $massaQuery->bindPARAM(":massa_id", $pizzaData["massa_id"]);
        $massaQuery->execute();
        $massa = $massaQuery->fetch(PDO::FETCH_ASSOC);
        $pizza["massa"] = $massa["tipo"];

        // Resgatando os sabores da pizza
        $saboresQuery = $conn->prepare("SELECT * FROM pizza_sabor WHERE pizza_id = :pizza_id");
        $saboresQuery->bindPARAM(":pizza_id", $pizza["id"]);
        $saboresQuery->execute();
        $sabores = $saboresQuery->fetchAll(PDO::FETCH_ASSOC);

        // Resgatando os nomes dos sabores
        $saboresDaPizza = [];

        foreach ($sabores as $sabor) {
            $saborQuery = $conn->prepare("SELECT * FROM sabores WHERE id = :sabor_id");
            $saborQuery->bindPARAM(":sabor_id", $sabor["sabor_id"]);
            $saborQuery->execute();
            $saborPizza = $saborQuery->fetch(PDO::FETCH_ASSOC);
            array_push($saboresDaPizza, $saborPizza["nome"]);
        }

        $pizza["sabores"] = $saboresDaPizza;

        // Adicionar status do pedido
        $pizza["status"] = $pedido["status_id"];

        // Adiciona ao array de pizzas
        $pizzas[] = $pizza;
    }

    // Retorna os pedidos em formato JSON
    // echo json_encode($pizzas);

} else if ($method === "POST") {
    // Código para tratar requisições POST

    $type = $_POST ["type"];

    if($type ==="delete") {
        $pizzaId = $_POST["id"];

        $deleteQuery = $conn->prepare("DELETE FROM pedidos WHERE pizza_id =:pizza_id;");

        $deleteQuery->bindParam(":pizza_id", $pizzaId, PDO::PARAM_INT);

        $deleteQuery->execute();

        $_SESSION["msg"] = 'Pedido removido com sucesso';
        $_SESSION["status"] = "success";
    
    //ATUALIZA STATUS DO PEDIDO
    } else if($type == "update"){
        $pizzaId = $_POST["id"];
        $statusId = $_POST["status"];

        if ($statusId === "" || !is_numeric($statusId)) {
            $_SESSION["msg"] = 'Erro: Status inválido!';
            $_SESSION["status"] = "error";
            header("Location: ../dashboard.php");
            exit;
        }
        
        $updateQuery = $conn->prepare("UPDATE pedidos SET status_id = :status_id WHERE pizza_id = :pizza_id");

        $updateQuery->bindParam(":pizza_id", $pizzaId, PDO::PARAM_INT);
        $updateQuery->bindParam(":status_id", $statusId, PDO::PARAM_INT);

        $updateQuery->execute();  

        $_SESSION["msg"] = 'Pedido atualizado com sucesso';
        $_SESSION["status"] = "success";
    
        
    }

    /*retonar usuário para dashboard*/

    header("Location: ../dashboard.php");
        
}
?>
