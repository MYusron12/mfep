<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mfep extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
      $data['title'] = 'Dashboard MFEP';
      $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
      $data['penilaian'] = $this->db->get('penilaian')->result_array();
      $data['alternatif_original'] = $this->db->get('alternatif')->result_array();
      // $data['bobot'] = $this->db->get('bobot')->result_array();
      $this->db->select('bobot.id,bobot,faktor_id,kode_faktor');
      $this->db->from('bobot');
      $this->db->join('data_faktor', 'data_faktor.id = bobot.faktor_id');
      $data['bobot'] = $this->db->get()->result_array();
      $query = $this->db->select_sum('bobot')->get('bobot');
      $this->db->select('alternatif.id,alternatif,c1,c2,c3,c4,c5');
      $this->db->from('alternatif');
      $this->db->join('evaluasi', 'evaluasi.alternatif_id = alternatif.id');
      $data['alternatif'] = $this->db->get()->result_array();
      $this->db->select('evaluasi.id,alternatif,c1,c2,c3,c4,c5');
      $this->db->from('evaluasi');
      $this->db->join('alternatif', 'alternatif.id = evaluasi.alternatif_id');
      $data['evaluasi'] = $this->db->get()->result_array();
      $data['c1'] = $this->db->select('bobot AS bobot_c1')->from('bobot')->join('data_faktor', 'data_faktor.id = bobot.faktor_id')->where('kode_faktor', 'C1')->get()->row_array();
      $data['c2'] = $this->db->select('bobot AS bobot_c2')->from('bobot')->join('data_faktor', 'data_faktor.id = bobot.faktor_id')->where('kode_faktor', 'C2')->get()->row_array();
      $data['c3'] = $this->db->select('bobot AS bobot_c3')->from('bobot')->join('data_faktor', 'data_faktor.id = bobot.faktor_id')->where('kode_faktor', 'C3')->get()->row_array();
      $data['c4'] = $this->db->select('bobot AS bobot_c4')->from('bobot')->join('data_faktor', 'data_faktor.id = bobot.faktor_id')->where('kode_faktor', 'C4')->get()->row_array();
      $data['c5'] = $this->db->select('bobot AS bobot_c5')->from('bobot')->join('data_faktor', 'data_faktor.id = bobot.faktor_id')->where('kode_faktor', 'C5')->get()->row_array();
      $data['faktor'] = $this->db->get('data_faktor')->result_array();
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('mfep/index', $data);
      $this->load->view('templates/footer');
    }

    // Faktor
    public function faktor()
    {
      $data['title'] = 'Faktor';
      $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
      $data['faktor'] = $this->db->get('data_faktor')->result_array();
      $this->form_validation->set_rules('kode_faktor', 'Kode Faktor', 'required');
      $this->form_validation->set_rules('keterangan_faktor', 'Keterangan Faktor', 'required');
      if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mfep/faktor', $data);
        $this->load->view('templates/footer');
      } else {
        $kode_faktor = $this->input->post('kode_faktor');
        $keterangan_faktor = $this->input->post('keterangan_faktor');
        $this->db->where('kode_faktor', $kode_faktor);
        $duplicate_kode = $this->db->get('data_faktor')->num_rows();
        $this->db->where('keterangan_faktor', $keterangan_faktor);
        $duplicate_keterangan = $this->db->get('data_faktor')->num_rows();
        if ($duplicate_kode > 0 || $duplicate_keterangan > 0) {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Duplicate entry found! Either Kode Faktor or Keterangan Faktor already exists.</div>');
          redirect('mfep/faktor');
        } else {
          $this->db->insert('data_faktor', [
            'kode_faktor' => $kode_faktor,
            'keterangan_faktor' => $keterangan_faktor,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => 'Admin'
          ]);
          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New faktor added!</div>');
          redirect('mfep/faktor');
        }
      }
    }

    public function delete_faktor($id)
    {
      $this->db->where('id', $id);
      $this->db->delete('data_faktor');
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Faktor has been deleted!</div>');
      redirect('mfep/faktor');
    }

    public function get_faktor_by_id()
    {
      $id = $this->input->post('id');
      $query = $this->db->get_where('data_faktor', ['id' => $id]);
      $data = $query->row_array();
      echo json_encode($data);
    }

    public function update_faktor()
    {
      $id = $this->input->post('id');
      $data = [
        'kode_faktor' => $this->input->post('kode_faktor'),
        'keterangan_faktor' => $this->input->post('keterangan_faktor')
      ];
      $this->db->where('id', $id);
      $this->db->update('data_faktor', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Faktor updated successfully</div>');
      redirect('mfep/faktor');
    }
    // End Faktor

    // Penilaian
    public function penilaian()
    {
      $data['title'] = 'Penilaian';
      $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
      $data['penilaian'] = $this->db->get('penilaian')->result_array();
      $this->form_validation->set_rules('nilai', 'Nilai', 'required');
      $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
      if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mfep/penilaian', $data);
        $this->load->view('templates/footer');
      } else {
        $nilai = $this->input->post('nilai');
        $keterangan = $this->input->post('keterangan');
        $this->db->where('nilai', $nilai);
        $duplicate_kode = $this->db->get('penilaian')->num_rows();
        $this->db->where('keterangan', $keterangan);
        $duplicate_keterangan = $this->db->get('penilaian')->num_rows();
        if ($duplicate_kode > 0 || $duplicate_keterangan > 0) {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Duplicate entry found! Either Nilai or Keterangan already exists.</div>');
          redirect('mfep/penilaian');
        } else {
          $this->db->insert('penilaian', [
              'nilai' => $nilai,
              'keterangan' => $keterangan,
              'created_at' => date('Y-m-d H:i:s'),
              'created_by' => 'Admin'
          ]);
          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Nilai added!</div>');
          redirect('mfep/penilaian');
        }
      }
    }

    public function delete_penilaian($id)
    {
      $this->db->where('id', $id);
      $this->db->delete('penilaian');
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Penilaian has been deleted!</div>');
      redirect('mfep/penilaian');
    }

    public function get_penilaian_by_id()
    {
      $id = $this->input->post('id');
      $query = $this->db->get_where('penilaian', ['id' => $id]);
      $data = $query->row_array();
      echo json_encode($data);
    }

    public function update_penilaian()
    {
      $id = $this->input->post('id');
      $data = [
        'nilai' => $this->input->post('nilai'),
        'keterangan' => $this->input->post('keterangan')
      ];
      $this->db->where('id', $id);
      $this->db->update('penilaian', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Penilaian updated successfully</div>');
      redirect('mfep/penilaian');
    }
    // End Penilaian

    // Alternatif
    public function alternatif()
    {
      $data['title'] = 'Alternatif';
      $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
      $data['alternatif'] = $this->db->get('alternatif')->result_array();
      $this->form_validation->set_rules('alternatif', 'Alternatif', 'required');
      if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mfep/alternatif', $data);
        $this->load->view('templates/footer');
      } else {
        $alternatif = $this->input->post('alternatif');
        $this->db->where('alternatif', $alternatif);
        $alternatif_data = $this->db->get('alternatif')->num_rows();
        if ($alternatif_data > 0) {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Duplicate entry found! Either Alternatif already exists.</div>');
          redirect('mfep/alternatif');
        } else {
          $this->db->insert('alternatif', [
              'alternatif' => $alternatif,
              'created_at' => date('Y-m-d H:i:s'),
              'created_by' => 'Admin'
          ]);
          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Alternatif Nilai added!</div>');
          redirect('mfep/alternatif');
        }
      }
    }

    public function delete_alternatif($id)
    {
      $this->db->where('id', $id);
      $this->db->delete('alternatif');
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Alternatif has been deleted!</div>');
      redirect('mfep/alternatif');
    }

    public function get_alternatif_by_id()
    {
      $id = $this->input->post('id');
      $query = $this->db->get_where('alternatif', ['id' => $id]);
      $data = $query->row_array();
      echo json_encode($data);
    }

    public function update_alternatif()
    {
      $id = $this->input->post('id');
      $data = [
        'alternatif' => $this->input->post('alternatif')
      ];
      $this->db->where('id', $id);
      $this->db->update('alternatif', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Alternatif updated successfully</div>');
      redirect('mfep/alternatif');
    }
    // End Alternatif

    // Bobot
    public function bobot()
    {
      $data['title'] = 'Bobot Faktor';
      $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
      // $data['bobot'] = $this->db->get('bobot')->result_array();
      $this->db->select('bobot.id,bobot,faktor_id,kode_faktor');
      $this->db->from('bobot');
      $this->db->join('data_faktor', 'data_faktor.id = bobot.faktor_id');
      $data['bobot'] = $this->db->get()->result_array();
      $query = $this->db->select_sum('bobot')->get('bobot');
      $data['total_bobot'] = $query->row()->bobot;
      $data['faktor'] = $this->db->get('data_faktor')->result_array();
      $this->form_validation->set_rules('bobot', 'Bobot', 'required');
      $this->form_validation->set_rules('faktor_id', 'Faktor', 'required');
      if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mfep/bobot', $data);
        $this->load->view('templates/footer');
      } else {
        $bobot = $this->input->post('bobot');
        $faktor_id = $this->input->post('faktor_id');
        // $this->db->where('bobot', $bobot);
        // $bobot_cek = $this->db->get('bobot')->num_rows();
        $this->db->where('faktor_id', $faktor_id);
        $faktor_id_cek = $this->db->get('bobot')->num_rows();
        if (/* $bobot_cek > 0 || */ $faktor_id_cek > 0) {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Duplicate entry found! Either Bobot or Faktor already exists.</div>');
          redirect('mfep/bobot');
        } else {
          $this->db->insert('bobot', [
              'bobot' => $bobot,
              'faktor_id' => $faktor_id,
              'created_at' => date('Y-m-d H:i:s'),
              'created_by' => 'Admin'
          ]);
          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Bobot added!</div>');
          redirect('mfep/bobot');
        }
      }
    }

    public function delete_bobot($id)
    {
      $this->db->where('id', $id);
      $this->db->delete('bobot');
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Bobot has been deleted!</div>');
      redirect('mfep/bobot');
    }

    public function get_bobot_by_id()
    {
      $id = $this->input->post('id');
      // var_dump($id);die;
      $query = $this->db->get_where('bobot', ['id' => $id]);
      $data = $query->row_array();
      echo json_encode($data);
    }

    public function update_bobot()
    {
      $id = $this->input->post('id');
      $data = [
        'bobot' => $this->input->post('bobot'),
        'faktor_id' => $this->input->post('faktor_id')
      ];
      $this->db->where('id', $id);
      $this->db->update('bobot', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Bobot updated successfully</div>');
      redirect('mfep/bobot');
    }
    // End Bobot

    // Evaluasi
    public function evaluasi()
    {
      $data['title'] = 'Evaluasi';
      $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
      // $data['evaluasi'] = $this->db->get('evaluasi')->result_array();
      $this->db->select('evaluasi.id,alternatif,c1,c2,c3,c4,c5');
      $this->db->from('evaluasi');
      $this->db->join('alternatif', 'alternatif.id = evaluasi.alternatif_id');
      $data['evaluasi'] = $this->db->get()->result_array();
      $data['alternatif'] = $this->db->get('alternatif')->result_array();
      $this->form_validation->set_rules('alternatif_id', 'Alternatif', 'required');
      if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mfep/evaluasi', $data);
        $this->load->view('templates/footer');
      } else {
        $alternatif_id = $this->input->post('alternatif_id');
        $c1 = $this->input->post('c1');
        $c2 = $this->input->post('c2');
        $c3 = $this->input->post('c3');
        $c4 = $this->input->post('c4');
        $c5 = $this->input->post('c5');
        $this->db->where('alternatif_id', $alternatif_id);
        $cek_alternatif_id = $this->db->get('evaluasi')->num_rows();
        if ($cek_alternatif_id > 0 ) {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Duplicate entry found! Either Alternatif already exists.</div>');
          redirect('mfep/evaluasi');
        } else {
          $this->db->insert('evaluasi', [
              'alternatif_id' => $alternatif_id,
              'c1' => $c1,
              'c2' => $c2,
              'c3' => $c3,
              'c4' => $c4,
              'c5' => $c5,
              'created_at' => date('Y-m-d H:i:s'),
              'created_by' => 'Admin'
          ]);
          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Nilai added!</div>');
          redirect('mfep/evaluasi');
        }
      }
    }

    public function delete_evaluasi($id)
    {
      $this->db->where('id', $id);
      $this->db->delete('evaluasi');
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Evaluasi has been deleted!</div>');
      redirect('mfep/evaluasi');
    }

    public function get_evaluasi_by_id()
    {
      $id = $this->input->post('id');
      $query = $this->db->get_where('evaluasi', ['id' => $id]);
      $data = $query->row_array();
      echo json_encode($data);
    }

    public function update_evaluasi()
    {
      $id = $this->input->post('id');
      $data = [
        'alternatif_id' => $this->input->post('alternatif_id'),
        'c1' => $this->input->post('c1'),
        'c2' => $this->input->post('c2'),
        'c3' => $this->input->post('c3'),
        'c4' => $this->input->post('c4'),
        'c5' => $this->input->post('c5')
      ];
      $this->db->where('id', $id);
      $this->db->update('evaluasi', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Evaluasi updated successfully</div>');
      redirect('mfep/evaluasi');
    }
    // End Evaluasi
}
