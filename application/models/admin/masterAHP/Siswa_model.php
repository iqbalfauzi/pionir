<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Siswa_model extends CI_Model
{

    public $table = 'data_siswa';
    public $id = 'nis_siswa';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    function check_exist($dt){
     $this->db->select("nis_siswa");
     $this->db->where($dt);
     return $this->db->get($this->table)->result();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('nis_siswa', $q);
        $this->db->or_like('nama_siswa', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get("normal_data_siswa")->result();
    }
    
    function getWeightedSiswa($limit=0,$start=0,$rekapall=false){
        if($rekapall) {
         $this->db->select("data_siswa.nis_siswa, data_siswa.nama_siswa,data_siswa.kls_siswa,data_siswa.alamat_siswa,data_siswa.nama_ayah_siswa,data_siswa.krj_ayah_siswa,data_siswa.pnd_ayah_siswa,data_siswa.hasil_ayah_siswa,data_siswa.jmsdr_siswa,data_siswa.nrata_siswa,data_siswa.status_siswa");
        } else {
         $this->db->select("data_siswa.nis_siswa, data_siswa.nama_siswa, value_weighted");
        }
        $this->db->order_by("value_weighted","DESC");
        $this->db->join("data_siswa","data_siswa.nis_siswa=weighted_data_siswa.nis_siswa");
        $this->db->limit($limit,$start);
        return $this->db->get("weighted_data_siswa")->result();
    }

    function get_all_max(){
        $this->db->select("max(nrata_siswa) as 'nrata_siswa',max(jmsdr_siswa) as 'jmsdr_siswa',max(pnd_ayah_siswa) as 'pnd_ayah_siswa', max(krj_ayah_siswa) as 'krj_ayah_siswa', max(hasil_ayah_siswa) as 'hasil_ayah_siswa',max(status_siswa) as 'status_siswa'");
        return $this->db->get('data_siswa')->row();
    }

    function get_all_min(){
        $this->db->select("min(nrata_siswa) as 'nrata_siswa',min(jmsdr_siswa) as 'jmsdr_siswa',min(pnd_ayah_siswa) as 'pnd_ayah_siswa', min(krj_ayah_siswa) as 'krj_ayah_siswa', min(hasil_ayah_siswa) as 'hasil_ayah_siswa',min(status_siswa) as 'status_siswa'");
        return $this->db->get('data_siswa')->row();
    }

    function insert($data){
        $this->db->set($data);
        return $this->db->insert("data_siswa");
    }

    function insertBatchSiswa($data){
        return $this->db->insert_batch("data_siswa",$data);
    }

    function insertNormalSiswa($data){
        return $this->db->insert_batch("normal_data_siswa",$data);
    }
    // insert data
    function resetNormalData(){
        return $this->db->truncate("normal_data_siswa");
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        return $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Pendaftar_model.php */
/* Location: ./application/models/Pendaftar_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-04 21:24:34 */
/* http://harviacode.com */