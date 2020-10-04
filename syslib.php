class Sys {

  	public $db;

	public function database(){
		$file=fopen("db/cred.txt", "r") or die("Unable to open file!");
		$cred=fgetcsv($file);
		fclose($file);
		$config=array('host'=>$cred[0],'username'=>$cred[1],'password'=>$cred[2],'dbname'=>$cred[3]);
		try{
			$this->db=new PDO("mysql:host=".$config['host']."; charset=utf8mb4"."; dbname=".$config['dbname'], $config['username'], $config['password']);
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}
		catch(Exception$e){
			echo "Unable to connect: ".$e->getMessage()."<p>";
			throw new PDOException('Could not connect to database, hiding connection details.');
		}
	}
				
	public function getperson($userid) {
		global $sys;
		$sql='SELECT * FROM org_persons WHERE id='.$userid;

		$user=$sys->read($sql,false);
		if (!$user) {
			$user['id']=0;
			$user['email']="*";
			return $user;
		}  else {
			if ($user['email']=='hibratt@gmail.com') {
				$sys->sysadm=true;
				$this->sysadm=true;
			} else {
				$this->sysadm=false;
			}
		return $user;
		}
	}				
				
	public function tut($t) {
		global $user;
		if ($user->sysadm) {
		echo chr(10).'<br><span style="color:red; font-size:0.7rem;">'.$t.'</span>';
		}
	}
        
} //Class Sys      
