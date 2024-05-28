<?php

namespace App\Helpers;

class UserHelper {
    public static function getUserById($id) {
        $users = [
            [
                'id' => 1,
                'name' => 'Ardyan Satya',
                'email' => 'ardyan.satya@gmail.com',
                'photo' => 'images/ardyan_satya.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Ridwan Kamil',
                'email' => 'kang.emil@gmail.com',
                'photo' => 'images/ridwan_kamil.jpg'
            ],
            [
                'id' => 3,
                'name' => 'Captain Tsubasa',
                'email' => 'tsubasa.ozora@gmail.com',
                'photo' => 'images/tsubasa_ozora.jpg'
            ],
        ];

        foreach ($users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }

        return null;
    }
     
}