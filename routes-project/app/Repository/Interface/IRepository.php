<?php

namespace App\Repository\Interface;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
interface IRepository{
    public function findAll(): array;
    public function save($p): object | null;
    public function findById($id): object | null;
    public function findByUniqueKey($uniqueKey): object | null; 
    public function update($p): bool;
    public function delete($id): bool;
}
    
?>