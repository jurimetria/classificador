    
    <?php 
    function conectar(){

	$hostname="127.0.0.1";
	$username="root";
	$password="Lp1406@";


    	#$hostname="lp-db.cjtvzbllncaj.us-east-1.rds.amazonaws.com";
	#$username="admin";
	#$password="Lp140622";
	

	#$hostname="ec2-54-157-224-251.compute-1.amazonaws.com:3306";
	#$username="root";
	#$password="Lp1406@";

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