<?php
 // filtro opcional: dias_threshold (padrão 90)
            $days = (int) param('dias_threshold', 90);
            $sql = "SELECT * FROM vw_itens_sem_movimentacao WHERE dias_sem_movimentar >= :days ORDER BY dias_sem_movimentar DESC LIMIT :limit OFFSET :offset";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':days', $days, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            jsonResponse(['report'=>'itens_sem_movimentacao', 'dias_threshold'=>$days, 'page'=>$page, 'limit'=>$limit, 'data'=>$rows]);


?>