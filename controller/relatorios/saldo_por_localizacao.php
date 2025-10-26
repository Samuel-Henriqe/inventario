<?php
 // filtro opcional id_localizacao
            $sql = "SELECT * FROM vw_saldo_por_localizacao WHERE 1=1";
            $params = [];
            if ($id_loc = param('id_localizacao', null)) { $sql .= " AND id_localizacao = :id_loc"; $params[':id_loc'] = (int)$id_loc; }
            if ($id_item = param('id_item', null)) { $sql .= " AND id_item = :id_item"; $params[':id_item'] = (int)$id_item; }
            $sql .= " ORDER BY nome_local ASC, nome_item ASC LIMIT :limit OFFSET :offset";
            $stmt = $conn->prepare($sql);
            foreach ($params as $k => $v) $stmt->bindValue($k, $v);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            jsonResponse(['report'=>'saldo_por_localizacao', 'page'=>$page, 'limit'=>$limit, 'data'=>$rows]);

?>