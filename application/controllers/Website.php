<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends CI_Controller {

	public function index()
	{
		$this->load->view('Include_web/header');
		$this->load->view('Website/index');
		$this->load->view('Include_web/footer');
	}

	public function about()
	{
		$this->load->view('Include_web/header');
		$this->load->view('Website/about');
		$this->load->view('Include_web/footer');
	}

	public function contact()
	{
		$this->load->view('Include_web/header');
		$this->load->view('Website/contact');
		$this->load->view('Include_web/footer');
	}
	public function blog()
	{
		$this->load->view('Include_web/header');
		$this->load->view('Website/blog');
		$this->load->view('Include_web/footer');
	}
	public function service()
	{
		$this->load->view('Include_web/header');
		$this->load->view('Website/service');
		$this->load->view('Include_web/footer');
	}
	public function testimonial()
	{
		$this->load->view('Include_web/header');
		$this->load->view('Website/testimonial');
		$this->load->view('Include_web/footer');
	}
}
