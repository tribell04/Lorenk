<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{
    // Ambil ringkasan laporan berdasarkan tahun
    public function getSummaryByYear($year)
    {
        $this->db->select('SUM(totalDonasi) as totalDonasi, SUM(totalPengeluaran) as totalPengeluaran');
        $this->db->where("YEAR(periode)", $year);
        return $this->db->get('report')->row_array();
    }

    // Ambil detail transaksi berdasarkan tahun
    public function getTransactionsByYear($year)
    {
        $this->db->where("YEAR(periode)", $year);
        return $this->db->get('report')->result_array();
    }
}
?>
