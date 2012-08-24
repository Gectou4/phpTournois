<?php
/***
* fichier Member.class.php : gestion des utilisateurs
* 
* @author: Gectou4
* @package: phpT 4.0
* @since: 15 december 2006
* @version: 1.0
*
*  © phpTournois  
*
***/
//TODO : Ajouter where clause de l'état de validation membre
//TODO : DATA VARS
class Member{
 
	public  $m_ip;	 	 // IP membre
	public  $m_id=0;	 // ID membre
	public  $s_tournois=null;
	public  $s_lang='english';
	//private $m_pwd=null;	 // Pass membre
	
	public function __construct($user=null,$pass=null,$remember=null,$logout=false) {
	 
	 if ($_SERVER['HTTP_CLIENT_IP']) {
		$this->m_ip = $_SERVER['HTTP_CLIENT_IP'];
	}else if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
		$this->m_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else if ($_SERVER['REMOTE_ADDR']) {
		$this->m_ip = $_SERVER['REMOTE_ADDR']; 
	}else {
		$this->m_ip = null;
	}
		
		/***	Test de la présence d'une session  => Login/Purge ***/
		$loguer = $this->member_check();
		/*** Maj de la Session ***/
		
		if($logout){
			$this->logout($this->m_id);
			$this->m_id = 0;			
		}else{
			if(verif($user)&&verif($pass)){
				$this->login($user,$pass);
			}else if ($loguer === true && $this->m_id !=0){
				$this->login_sess();
			}else{
				$this->login(0);
			}
		$this->sess_up($remember);
		}
		
		return $this->getMember();
	}

	public function member_check(){
	    global $Configs,$db,$dbprefix;	

	    $idip = md5($this->m_ip);
		$r = false;
		
		// Renvoie le temps actuel - temps de session max, si la dernière date de login est inférieur à ce temps alors la session à expiré
		$sess_out = time() - 3600; 
		
		/*** On purge la DB ***/
		$db->delete("${dbprefix}sessions");
		$db->where("date < '$sess_out'");
		$db->exec();
		
		if (verif($_COOKIE['phpt_idip']) && $_COOKIE['phpt_idip'] == $idip){
			$r = true;
			$idip = $_COOKIE['phpt_idip'];
			
			if(verif($_COOKIE['phpt_m_id'])){
				$this->m_id=$_COOKIE['phpt_m_id'];
			}
	    }
		if (verif($this->m_ip) && $Configs->session_time > 0){
			
			$req=null;
			$result=null;
			
			$db->select("id,joueur,tournois");
			$db->from("${dbprefix}sessions");
			$db->where("id = '$idip' AND date >= '$sess_out'");
			$req=$db->exec();

	        $result=$db->fetch($res);
	        if (!empty($result)){
	            $r = true;
				$this->m_id = $result->membre;
				$this->s_tournois = $result->tournois;
	        } 
	    }
				
    return $r;
	} 
	
	public function sess_up($remember=''){
	
	 global $Configs,$db,$dbprefix;	
	
	    $idip = md5($this->m_ip);
		$data ='';
				
			if ($remember == 'ok'){
		        setcookie('phpt_idip', $idip, 'phpt_time');
		        setcookie('phpt_m_id', $this->m_id, 'phpt_time');        
			}else{
		        setcookie('phpt_idip', $idip);
		        setcookie('phpt_m_id', $this->m_id);
		    } 
			
			$db->query("INSERT INTO ${dbprefix}sessions ( `id` , `joueur` , `date` , `last_used`, `ip` , `vars` )
						VALUES ( '".$idip."' , '".$this->m_id."' , '".time()."', 0, '".base64_encode($this->m_ip)."', '".$data."' )
						ON DUPLICATE KEY UPDATE vars='".$data."', date='".time()."', joueur='".$this->m_id."';
						");
				
			$db->exec();
		return true;
	}
		
	public function login($user=0,$pass=null){
	
		global $Configs,$db,$dbprefix,$u_prefix,$u_prefixID,$u_pseudo;	
		
		$req = null;
		$valide=null;
		$r = false;

		if(verif($user) && verif($pass)){
			$valide=true;
			
			$db->select("*");
			$db->from("${dbprefix}joueurs");
			$db->where("pseudo = '$user' AND passwd = '".md5($pass)."' AND passwd != '' AND passwd is not null");
			$req=$db->exec();		
							
		}else if ($user===0 && $pass===null){
			$valide=false;
			
			$db->select("*");
			$db->from("${dbprefix}joueurs");
			$db->where("id = '0'");
			$req=$db->exec();
			
		}
		if ($valide!==null){
			$result = null;
			$result = $db->fetch($req);
			
				if(!empty($result->id)){
					$r = true;
					foreach($result as $k=>$v)
					{
						$this->$k=$v;
					}
					$this->m_id = $result->id;
				}
			$req=null;
			$result = null;
			
			if($valide===true){
				$db->update("${dbprefix}joueurs");
				$db->set("ext_ip = '".$this->m_ip."'");
				$db->set("datelogin = '".time()."'");
				$db->where("pseudo = '$user' AND passwd = '".md5($pass)."' AND passwd != '' AND passwd is not null");
				$db->exec();
			}
		}
							
		return $r;
	}
	
	public function login_sess(){
	
		global $Configs,$db,$dbprefix,$u_prefix,$u_prefixID,$u_pseudo;	
		
		$req=null;
		$r=false;
			
			$db->select("*");
			$db->from("${dbprefix}joueurs");
			//$db->where("id= '".$this->m_id."' && ext_ip='".$this->m_ip."'");
			$db->where("id= '".$this->m_id."'");
			$req=$db->exec();
			
			$result=null;		
			$result = $db->fetch($req);
			
			if(!empty($result->id)){
					$r=true;
				foreach($result as $k=>$v)
				{
					$this->$k=$v;
				}	
			}
		$result=null;
		$req=null;
		return $r;
	}
	
	public function getMember(){
		
		foreach($this as $key => $value) 
		{
		 $Member->$key = $value;
		}
		
		return $Member;
	}
	
	public function logout($m_id){
		global $db,$dbprefix;
		
		$db->delete("${dbprefix}sessions");
		$db->where("joueur = '".$this->m_id."'");
		$db->exec();
		
		 setcookie('phpt_idip', '','-99999');
		 setcookie('phpt_m_id', '','-99999');
				
		
		return true;
	}
	
	public function tournois($id,$j_id){
		global $db,$dbprefix;
				
				// $ j_id is used for fx a bug on ifrance type site where a pub (shit) is upper the kernel on the displaying herarchie
				$db->update("${dbprefix}sessions");
				$db->set("tournois = '".$id."'");
				$db->where("joueur = '".$j_id."'");
				$db->exec();
				$this->s_tournois = $id;
		
		return true;
	}
	
	public function getTournois(){
		global $db,$dbprefix;
			$req=null;
			$result=null;
			$db->select("tournois");
			$db->from("${dbprefix}sessions");
			$db->where("joueur= '".$this->m_id."'");
			$req=$db->exec();
			$result = $db->fetch($req);
			//echo $result;
		return $result;
	}
	
	public function lang($lang,$j_id){
		global $db,$dbprefix;
				
				$db->update("${dbprefix}sessions");
				$db->set("lang = '".$lang."'");
				$db->where("joueur = '".$j_id."'");
				$db->exec();
				$this->s_lang = $lang;
				
				if ($j_id != 0){
					$db->update("${dbprefix}joueurs");
					$db->set("langue = '".$lang."'");
					$db->where("id = '".$j_id."'");
					$db->exec();
					$this->s_lang = $lang;
				}
		
		return true;
	}
	
	public function getLang(){
		global $db,$dbprefix;
			$req=null;
			$result=null;
			$db->select("lang");
			$db->from("${dbprefix}sessions");
			$db->where("joueur= '".$this->m_id."'");
			$req=$db->exec();
			$result = $db->fetch($req);
			//echo $result;
		return $result;
	}
	
}
?>
