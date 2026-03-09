<?php
class DatabaseViewer {
    private $Database;

   
        public function __construct($Database) {
            $this->Database = $Database;
        }   
    



        public function displayUsers($users){
            echo "<h2>Usuarios</h2>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Name</th><th>Last Name</th></tr>";
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($user['id_user']) . "</td>";
                echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                echo "<td>" . htmlspecialchars($user['name']) . "</td>";
                echo "<td>" . htmlspecialchars($user['last_name']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }



}

?>