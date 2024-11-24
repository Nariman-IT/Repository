<?php

require_once 'UserRepository.php';


$pdo = new PDO('mysql:host=localhost;dbname=anirame', 'root','');

$userRepository = new UserRepository($pdo);


//Получения всех пользователей
$users = $userRepository->all();
// print_r($users);

//Поиск пользователя по id
$user = $userRepository->find(1);
// print_r($user);


//Создание нового пользователя
$newUser = $userRepository->create([
    'user' => 'John Doe',
    'password' => '+79505513421',
]);
// print_r($newUser);



//Обновления существуещего пользователя
$updateUser = $userRepository->update($newUser['id'], [
    'user' => 'John Smith',
]);
// print_r($updateUser);


//Удаление пользователя 
$userRepository->delete($updateUser['id']);
echo "Пользователь удален!";
