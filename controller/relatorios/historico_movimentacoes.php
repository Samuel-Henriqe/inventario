<?php
// filtros: start_date (YYYY-MM-DD), end_date, siape, tipo_movimentacao, id_local_origem, id_local_destino, nome_item_like
            $sql = "SELECT * FROM vw_historico_movimentacoes WHERE 1=1";
            $params = [];

            if ($sd = param('start_date', null)) { $sql .= " AND STR_TO_DATE(data_movimentacao, '%d/%m/%Y') >= :start_date"; $params[':start_date'] = $sd; }
            if ($ed = param('end_date', null))   { $sql .= " AND STR_TO_DATE(data_movimentacao, '%d/%m/%Y') <= :end_date"; $params[':end_date'] = $ed; }
            if ($siape = param('siape', null))   { $sql .= " AND usuario_responsavel LIKE :siape"; $params[':siape'] = "%$siape%"; }
            if ($tipo = param('tipo_movimentacao', null)) { $sql .= " AND tipo_movimentacao = :tipo"; $params[':tipo'] = $tipo; }
            if ($lo = param('id_local_origem', null)) { $sql .= " AND local_origem = (SELECT nome_local FROM localizacao WHERE id_localizacao = :lo)"; $params[':lo'] = (int)$lo; }
            if ($ld = param('id_local_destino', null)) { $sql .= " AND local_destino = (SELECT nome_local FROM localizacao WHERE id_localizacao = :ld)"; $params[':ld'] = (int)$ld; }
            if ($like = param('nome_item_like', null)) { $sql .= " AND nome_item LIKE :like"; $params[':like'] = "%$like%"; }

            $sql .= " ORDER BY STR_TO_DATE(data_movimentacao, '%d/%m/%Y') DESC, id_movimentacao DESC LIMIT :limit OFFSET :offset";
            $stmt = $conn->prepare($sql);
            foreach ($params as $k => $v) $stmt->bindValue($k, $v);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            jsonResponse(['report'=>'historico_movimentacoes', 'page'=>$page, 'limit'=>$limit, 'data'=>$rows]);

?>