<?php
function cek_login()
{

	$ci = get_instance();
	if (!$ci->session->userdata('username')) {

		redirect('auth');
	}
}
function cek_user()
{
	$ci = get_instance();
	$user = $ci->db->get_where('user', ['username' => $ci->session->userdata('username'),'cabang' => $ci->session->userdata('cabang')])->row_array();
	if ($user['tipe'] != 'Administrator') {
		redirect('auth/blocked');
	}
}

function infoLogin()
{
	$ci = get_instance();
	return $ci->db->get_where('user', ['username' => $ci->session->userdata('username'),'cabang' => $ci->session->userdata('cabang')])->row_array();
}
