<?php
// filtros opcionais: min_qtd, status_item, id_localizacao, id_categoria, nome_item_like
            $sql = "SELECT * FROM vw_estoque_atual WHERE 1=1";
            $params = [];

            if (($min_qtd = param('min_qtd', null)) !== null) {
                $sql .= " AND quantidade_atual >= :min_qtd";
                $params[':min_qtd'] = (float)$min_qtd;
            }
            if (($status = param('status_item', null)) !== null) {
                $sql .= " AND status_item = :status_item";
                $params[':status_item'] = $status;
            }
            if (($id_local = param('id_localizacao', null)) !== null) {
                $sql .= " AND id_localizacao = :id_localizacao";
                $params[':id_localizacao'] = (int)$id_local;
            }
            if (($categoria = param('nome_categoria', null)) !== null) {
                $sql .= " AND nome_categoria = :nome_categoria";
                $params[':nome_categoria'] = $categoria;
            }
            if (($like = param('nome_item_like', null)) !== null) {
                $sql .= " AND nome_item LIKE :like";
                $params[':like'] = "%$like%";
            }
            $sql .= " ORDER BY nome_item ASC LIMIT :limit OFFSET :offset";

            $stmt = $conn->prepare($sql);
            // bind numeric limit/offset explicitly
            foreach ($params as $k => $v) $stmt->bindValue($k, $v);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            jsonResponse(['report'=>'estoque_atual', 'page'=>$page, 'limit'=>$limit, 'data'=>$rows]);
?>