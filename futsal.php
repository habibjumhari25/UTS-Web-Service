<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class futsal extends REST_Controller{

    function __construct($config = "rest"){
        parent::__construct($config);
        $this->load->database();
    }

    public function index_get(){

        $id = $this->get('id');
        $nilai=[];
        if($id == ''){
            $data = $this->db->get('futsal')->result();
            foreach($data as $row=>$key):
                $Futsal[]=["idFutsal"=>$key->idFutsal,
                            "Nama"=>$key->Nama,
                            "NoPanggung"=>$key->NoPanggung,
                            "_links"=>[(object)["href"=>"Futsal{$key->idFutsal}",
                                        "rel"=>"futsal",
                                        "type"=>"GET"]]
                        ];
                    endforeach;
        }else{
            $this->db->where('idFutsal', $id);
            $nilai = $this->db->get('Futsal')->result();
        }
        $result=["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                 "code"=>200,
                 "message"=>"Response Successfully",
                 "data"=>$idFutsal];
        $this->response($result, 200);
    }

    public function index_post(){
        $data = array(
                    'idFutsal' => $this->post('idFutsal'),
                    'Nama' => $this->post('Nama'),
                     'NoPanggung' => $this->post('NoPanggung'));
        $insert = $this->db->insert('futsal', $data);
        if($insert){
            $result = ["took" => $_SERVER["REQUEST_TIME_FLOAT"],
                       "code"=>201,
                       "message"=>"Data has successfully added",
                       "data"=>$data];
            $this->response($result, 201);
        }else{
            $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                       "code"=>502,
                       "message"=>"Failed adding data",
                       "data"=>null];
            $this->response($result, 502);
        }
    }

    function index_put(){
        $id = $this->get('id');
        $data = array(
                    'idFutsal' => $this->put('idFutsal'),
                    'Nama' => $this->put('Nama'));
        $this->db->where('idFutsal', $id);
        $update = $this->db->update('Futsal', $data);
        if($update){
            $this->response($data, 200);
        } else{
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_delete() {
        $id = $this->get('id');
        $this->db->where('idFutsal', $id);
        $delete = $this->db->delete('Futsal');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else{
            $this->response(array('status' => 'fail', 502));
        }
    }
}

?>