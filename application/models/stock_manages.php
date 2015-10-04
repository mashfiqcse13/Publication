<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Stock_manages extends CI_Model{
    
    function book_details_by_id($id){
        $query=$this->db->query("SELECT * FROM pub_books WHERE book_ID='$id'");
        
        foreach ($query->result_array() as $rowid => $rowdata ){
            $data[$rowid]=$rowdata;
        }
     return $data;   
    }
    
    
    function contact_details_by_type($id){
        
        $query=$this->db->query("SELECT * FROM pub_contacts WHERE contact_ID='$id'");
        foreach($query->result_array() as $contactsid => $contact){
            $data[$contactsid] = $contact;
        }
        return $data;
    }
    
    function find_contactsid_by_type($type1 ='' ,$type2= ''){
       $query=$this->db->query("SELECT contact_ID FROM pub_contacts WHERE contact_type=='$type1' && contact_type=='$type2'");
        foreach($query->result_array() as $contactsid => $contact){
            $data[$contactsid] = $contact;
        }
        return $data; 
    }
 
}