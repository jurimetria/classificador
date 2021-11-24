    
    <?php 
    function conectar(){
        $hostname="database-2.cjtvzbllncaj.us-east-1.rds.amazonaws.com";
        $username="admin";
        $password="lpdb4444";
        $dbname="lp_db";

        try {
            $pdo = new PDO("mysql:host=$hostname;dbname=$dbname",$username,$password);
            $pdo->exec("SET CHARACTER SET utf8");

        } catch (\Throwable $th) {
            return $th;
            die;
        }

        return $pdo;
    }
    
    



    ?>