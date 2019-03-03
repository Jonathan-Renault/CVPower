<?php

class Model_Education extends CI_Model
{
    public function construct(){
        parent::construct();
    }

    public function get($idcv)
    {
        $this->db->select('*')->from('cvp_c_education')->where('cvp_c_cv_id', $idcv);
        return $this->db->get()->result_array();
    }

    public function add($school, $diploma, $yearbegin, $yearend, $idcv)
    {

        $data = array(
            'school' => $school,
            'diploma' => $diploma,
            'beginning' => $yearbegin,
            'ending' => $yearend,
            'cvp_c_cv_id' => $idcv
        );

        //	Une fois que tous les champs ont bien été définis, on "insert" le tout
        $this->db->insert('cvp_c_education', $data);
    }

    public function update($id, $school, $diploma, $yearbegin, $yearend)
    {

        $data = array(
            'school' => $school,
            'diploma' => $diploma,
            'beginning' => $yearbegin,
            'ending' => $yearend,
            'updated_at' => date('Y-m-d H:i:s')
        );

        //	Une fois que tous les champs ont bien été définis, on "update" le tout
        $this->db->where('id', $id);
        $this->db->update('cvp_c_education', $data);
    }

    public function remove($id)
    {
        $data = array(
            'status' => 0
        );

        //	On place sur le statut l'état "0" (archivé) à l'id sélectionné
        $this->db->where('id', $id);
        $this->db->update('cvp_c_education', $data);
    }
}