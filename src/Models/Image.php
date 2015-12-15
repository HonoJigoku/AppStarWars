<?php

namespace Models;


class Image extends Model
{
    protected $table='images';

    public function productImage($productId)
    {
        $sql = sprintf('SELECT * FROM %s WHERE product_id=%d', $this->table, (int) $productId);

        $stmt = $this->pdo->query($sql);

        if(!$stmt) return false;

        return $stmt->fetch();
    }
}