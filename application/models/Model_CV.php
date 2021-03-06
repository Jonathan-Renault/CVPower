<?php

class Model_CV extends CI_Model
{
    public function construct(){
        parent::construct();
    }

    public function get($iduser)
    {

        $this->db->select('*')->from('cvp_c_cv')->where('cvp_c_profile_id', $iduser)->where('status', TRUE);
        return $this->db->get()->result_array();
    }

    public function getCv($id)
    {
        $this->db->select('*')->from('cvp_c_cv')->where('id', $id);
        return $this->db->get()->result_array();
    }

    public function getIdCv($iduser)
    {

        $this->db->select('id');
        $this->db->from('cvp_c_cv');
        $this->db->where('cvp_c_profile_id', $iduser);
        $this->db->order_by('created_at','DESC');
        $result = $this->db->get()->result_array();

        return $result;

    }
    public function getAll()
    {
        return $this->db->select('*')->from('cvp_c_cv')->get();

    }

    public function add($name, $desc, $iduser)
    {

        $data = array(
            'name' => $name,
            'description' => $desc,
            'cvp_c_profile_id' => $iduser
        );

        //	Une fois que tous les champs ont bien été définis, on "insert" le tout
        $this->db->insert('cvp_c_cv', $data);
    }

    public function changeColor($id, $color){
        $data = array(
            'color' => $color,
            'updated_at' => date('Y-m-d H:i:s')
        );

        //	Une fois que tous les champs ont bien été définis, on "update" le tout
        $this->db->where('id',$id);
        $this->db->update('cvp_c_cv', $data);
    }

    public function update($id, $name, $desc)
    {

        $data = array(
            'name' => $name,
            'description' => $desc,
            'updated_at' => date('Y-m-d H:i:s')
        );

        //	Une fois que tous les champs ont bien été définis, on "update" le tout
        $this->db->where('id',$id);
        $this->db->replace('cvp_c_cv', $data);
    }

    public function remove($id)
    {
        $data = array(
            'status' => 0,
            'updated_at' => date('Y-m-d H:i:s')
        );

        //	On place sur le statut l'état "0" (archivé) à l'id sélectionné
        $this->db->where('id', $id);
        $this->db->update('cvp_c_cv', $data);
    }
}