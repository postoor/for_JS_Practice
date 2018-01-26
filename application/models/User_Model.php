<?php
class User_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getList($page = 0, $perPage = 10)
    {
        $UserList = $this->db->select(['user_id AS id',
                                      'user_name AS username',
                                      'user_email AS email'])
                             ->from('user')
                             ->where('delete_time is null')
                             ->limit($perPage, ($page)? $page*$perPage : $page)
                             ->get();

        $isValue = $UserList->num_rows();
        if ($isValue) {
            return $UserList->result();
        } else {
            return FALSE;
        }
    }

    public function create($data)
    {
        $UserCheck = $this->db->select('user_id')
                              ->from('user')
                              ->where('user_email', $data['user_email'])
                              ->limit(1)
                              ->get();
        
        $isExist = $UserCheck->num_rows();
        if ($isExist) {
            return FALSE;
        } else {
            $isInsert = $this->db->insert('user', $data);
            return $isInsert;
        }
    }

    public function delete($data)
    {
        $UserCheck = $this->db->select('user_id')
                              ->from('user')
                              ->where('user_id', $data['id'])
                              ->limit(1)
                              ->get();
        $isExist = $UserCheck->num_rows();
        if ($isExist) {
            $now = new Datetime();
            $isDel = $this->db->set('delete_time', $now->format('Y-m-d H:i:s'))
                              ->where('user_id', $data['id'])
                              ->update('user');
                            //   echo $this->db->last_query();exit;
            return $isDel;
        } else {
            return FALSE;
        }
    }

    public function edit($data)
    {
        $UserCheck = $this->db->select('user_id')
                              ->from('user')
                              ->where('user_id', $data['id'])
                              ->limit(1)
                              ->get();
                              
        $isExist = $UserCheck->num_rows();
        if ($isExist) {
            $isUpdate = $this->db->set('user_name', $data['user_name'])
                                 ->where('user_id', $data['id'])
                                 ->update('user');
            return $isUpdate;
        } else {
            return FALSE;
        }
    }
}