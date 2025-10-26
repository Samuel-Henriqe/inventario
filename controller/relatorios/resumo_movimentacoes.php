<?php
// filtros: start_date, end_date, tipo_movimentacao, nome_categoria
            $sql = "SELECT * FROM vw_resumo_movimentacoes WHERE 1=1";
            $params = [];
            if ($sd = param('start_date', null)) { $sql .= " AND ultima_data >= :start_date"; $params[':start_date'] = $sd; }
            if ($ed = param('end_date', null))   { $sql .= " AND primeira_data <= :end_date"; $params[':end_date'] = $ed; }
            if ($tipo = param('tipo_movimentacao', null)) { $sql .= " AND tipo_movimentacao = :tipo"; $params[':tipo'] = $tipo; }
            if ($cat = param('nome_categoria', null)) { $sql .= " AND nome_categoria = :cat"; $params[':cat'] = $cat; }
            $sql .= " ORDER BY tipo_movimentacao ASC, nome_categoria ASC LIMIT :limit OFFSET :offset";

            $stmt = $conn->prepare($sql);
            foreach ($params as $k => $v) $stmt->bindValue($k, $v);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            jsonResponse(['report'=>'resumo_movimentacoes', 'page'=>$page, 'limit'=>$limit, 'data'=>$rows]);
?>