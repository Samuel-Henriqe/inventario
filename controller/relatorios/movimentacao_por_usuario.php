<?php
// filtro opcional: siape, ordering, min_total_movimentacoes
            $sql = "SELECT * FROM vw_movimentacao_por_usuario WHERE 1=1";
            $params = [];
            if ($siape = param('siape', null)) { $sql .= " AND siape = :siape"; $params[':siape'] = (int)$siape; }
            if ($min = param('min_total_movimentacoes', null)) { $sql .= " AND total_movimentacoes >= :min"; $params[':min'] = (int)$min; }
            $sql .= " ORDER BY total_movimentacoes DESC LIMIT :limit OFFSET :offset";
            $stmt = $conn->prepare($sql);
            foreach ($params as $k => $v) $stmt->bindValue($k, $v);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            jsonResponse(['report'=>'movimentacao_por_usuario', 'page'=>$page, 'limit'=>$limit, 'data'=>$rows]);

?>