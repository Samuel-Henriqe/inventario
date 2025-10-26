<?php
$id_item = param('id_item', null);
            if (!$id_item) jsonResponse(['error'=>'Informe id_item'], 400);
            $stmt = $pdo->prepare("SELECT i.*, c.nome_categoria, l.nome_local FROM item i LEFT JOIN categoria c ON i.id_categoria = c.id_categoria LEFT JOIN localizacao l ON i.id_localizacao = l.id_localizacao WHERE i.id_item = :id_item");
            $stmt->execute([':id_item' => (int)$id_item]);
            $row = $stmt->fetch();
            if (!$row) jsonResponse(['error'=>'Item não encontrado'], 404);
            jsonResponse(['report'=>'item', 'data'=>$row]);

?>