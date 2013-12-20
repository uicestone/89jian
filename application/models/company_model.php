<?php
class Company_model extends CI_Model{
	
	var $name;
	var $type;
	var $syscode;
	var $sysname;
	
	function __construct(){
		parent::__construct();
		
		$this->recognize($this->input->server('SERVER_NAME'));

		$this->config->company=$this->config();
		
	}

	function recognize($host_name){
		$this->db->select('id,name,type,syscode,sysname')
			->from('company')
			->or_where(array('host'=>$host_name,'syscode'=>$host_name));
		
		$row=$this->db->get()->row();
		
		if(!$row){
			show_error('No company called '.$host_name.' here');
		}
		
		$this->id=intval($row->id);
		$this->name=$row->name;
		$this->type=$row->type;
		$this->syscode=$row->syscode;
		$this->sysname=$row->sysname;
	}
	
	/**
	 * set or get a company config value
	 * or get all config values of a company
	 * json_decode/encode automatically
	 * @param string $key
	 * @param mixed $value
	 */
	function config($key=NULL,$value=NULL){
		
		if(is_null($key)){
			
			$this->db->from('company_config')->where('company',$this->id);

			$config=array_column($this->db->get()->result_array(),'value','key');

			return array_map(function($value){
				
				$decoded=json_decode($value,true);
				
				if(!is_null($decoded)){
					$value=$decoded;
				}
				
				return $value;
				
			}, $config);
			
		}
		elseif(is_null($value)){
			
			$row=$this->db->select('id,value')
				->from('company_config')
				->where('company',$this->id)
				->where('key',$key)
				->get()->row();

			if($row){
				$json_value=json_decode($row->value);
				
				if(is_null($json_value)){
					return $row->value;
				}
				else{
					return $json_value;
				}
			}
			else{
				return false;
			}
		}
		else{
			
			if(is_array($value)){
				$value=json_encode($value);
			}
			
			return $this->db->upsert('company_config', array('value'=>$value));
		}
	}
}
?>