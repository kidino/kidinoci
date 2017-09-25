<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AppSettings
{
	var $CI;
	var $table = 'app_settings';

	function __construct(){
		$this->CI =& get_instance();
	}
	
	function save( $sett_data ) {
		$save = 0;
		foreach($sett_data as $k => $v) {
			if ( $this->_sett_exists($k) ) {
				$this->CI->db->where('sett_name',$k);
				$this->CI->db->update($this->table, array('sett_value' => $v));
			} else {
				$this->CI->db->insert($this->table, array( 'sett_name' => $k, 'sett_value' => $v ));
			}
			$save += $this->CI->db->affected_rows();
		}
		
		if ($save > 0) { return true; }
		return false;
	}
	
	function get($sett_name) {
		$res = $this->CI->db->get_where($this->table, array('sett_name' => $sett_name), 1);
		if ($res->num_rows() > 0) {
			$row = $res->row_array();
			return $row['sett_value'];
		}
		return '';
	}
	
	function _sett_exists( $sett_name ) {
		$res = $this->CI->db->get_where($this->table, array('sett_name' => $sett_name), 1);
		return ($res->num_rows() > 0);
	}
    
    function get_all(){
		$res = $this->CI->db->get_where($this->table);
		if ($res->num_rows() > 0) {
			$result = $res->result_array();
            $result2 = array();
            foreach($result as $k => $r) {
                $result2[$r['sett_name']] = $r['sett_value'];
                if ($r['sett_name'] == 'paypal_sandbox') {
                    $result2[$r['sett_name']] = ($r['sett_value'] == 'true');
                }
            }
			return $result2;
		}
		return array(); // return empty array
    }
}
?>
