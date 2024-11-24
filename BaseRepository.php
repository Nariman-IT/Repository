<?php

require_once 'RepositoryInterface.php';


class BaseRepository implements RepositoryInterface {

    protected $pdo;
    protected $table;



    public function __construct(PDO $pdo, string $table){
        $this->pdo = $pdo;
        $this->table = $table;
    }


    public function all(){
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function find(int $id){
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function create(array $data){
        $keys = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($keys) VALUES ($placeholders)");
        $stmt->execute($data);

        return $this->find($this->pdo->lastInsertId());
    }



    public function update(int $id, array $data){
        $fields = implode(' = ?, ', array_keys($data)) . ' = ?';
        $values = array_values($data);
        $values[] = $id;

        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET $fields WHERE id = ?");
        $stmt->execute($values);

        return $this->find($id);
    }


    public function delete(int $id){
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

}