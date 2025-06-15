<?php 
class User {
    public static function getAll() {
        return db_query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
    }
}
