<?php

require_once 'BaseRepository.php';

class UserRepository extends BaseRepository{

    public function __construct(PDO $pdo){
        parent::__construct($pdo, 'users');
    }

    public function findByEmail(string $email){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}