<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Page extends CI_Model{

    public function get_all_pages()
    {
        $this->db->order_by('id', 'DESC');
        return $this->db->get('pages')->result_array();
    }

    public function get_page($slug)
    {
        $page = $this->db->get_where('pages', array('slug' => $slug));
        if(!$page->num_rows())
        {
            return false;
        }
        return $page->result_array()[0];
    }
}