<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->switch_theme('default');
        date_default_timezone_set('PRC');
    }

	// ------------------------------------------------------------------------
	public function index()
	{
		if ($this->session->uid) {
			redirect('/index/index');
		} else {
			$this->load->view('sys_login');
		}
	}

	// ------------------------------------------------------------------------
	public function quit()
	{
		if($this->session->user){
			$this->user_model->writeLog($this->session->user, "用户".$this->session->user."退出登录");
		}
		$this->session->sess_destroy();
		redirect('/login');
	}

      public function login()
      {
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);
             $code = $this->input->post('verify');
             $ip = $this->input->ip_address();
            if ( strtolower($code) !== $this->session->code )
            {
              $this->session->set_flashdata('error', '验证码错误');
              redirect('/login');
            } else {

    		if ( $username AND $password )
             {
    			$admin = ( preg_match('/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i', $username) ) ? $this->user_model->get_full_user_by_username($username, 'email') : $this->user_model->get_full_user_by_username($username);
    			if ( $admin ) {
                    		$throttle = $this->user_model->get_throttle($admin->uid);

                    		if ($throttle) {
                        		$this->session->set_flashdata('error', "密码输入次数过多，账号被禁用半小时，将在".date('Y-m-d H:i:s', strtotime($throttle->created_at) + 1800).'解禁.');
                        		redirect('/login');
                    		}

    				if ($admin->password == sha1($password.$admin->salt)) {
    					if ( $admin->status == 1 ) {
                                        if ( $admin->lock_ip == 0 OR ( $admin->lock_ip == 1 && in_array($ip, explode(',', $admin->ip))  ) )
                                        {
      						   $this->session->set_userdata('uid', $admin->uid);
                                           $this->session->set_userdata('user', $admin->username);
                                           $this->session->set_userdata('role', $admin->role);
                                           $this->user_model->writeLog($this->session->user, "用户".$this->session->user."登录后台");
      						redirect('/index/index');
                                        } else {
                                           $this->session->set_flashdata('error', '你的IP不允许登录');
                                        }
    					} else {
    						$this->session->set_flashdata('error', "帐号被冻结");
    					}
    				} else {
                        		if ( ! $throttles = $this->session->userdata('throttles_'.$username) ) {
                            			$this->session->set_userdata('throttles_'.$username, 1);
                        		} else {
                            			$throttles ++;
                            			$this->session->set_userdata('throttles_'.$username,  $throttles);
                           			if ($throttles > 3) {
                                			$throttle_data['user_id'] = $admin->uid;
                                			$throttle_data['type'] = 'attempt_login';
                                			$throttle_data['ip'] = $this->input->ip_address();
                                			$throttle_data['created_at'] =  $throttle_data['updated_at'] = date('Y-m-d H:i:s');
                                			$this->user_model->add_throttle($throttle_data);
                                			$this->session->set_userdata('throttles_'.$username, 0);
                            			}
                        		}
    					$this->session->set_flashdata('error', "认证失败");
    				}
    			} else {
    				$this->session->set_flashdata('error', '认证失败');
    			}
    		} else {
    			$this->session->set_flashdata('error', '认证失败');
    		}
		$this->load->view('sys_login');
          }
	}
      /**
       *ci自带captcha生成验证码
       */
      protected function code() {
        $this->load->helper('captcha');
        $vals = array(
            "word" => "",
            "img_path" => dirname(BASEPATH) . "/static/captcha/",
            "img_url" => base_url('static/captcha'),
            "img_width" => 100,
            "img_height" => 42,
            "expiration" => 20,
            "word_length" => 5,
            "colors" => array(
                  "background" => array(255, 255, 255),
                  "border" => array(255, 255, 255),
                  "text" => array(0, 0 ,0),
                  "grid" => array(255, 40, 40)
            )
        );
        $cap = create_captcha($vals);
        echo $cap['image'];
      }

      public function get_code()
      {
        $this->load->library('captcha');
        $code = $this->captcha->getCaptcha();
        $this->session->set_userdata('code', $code);
        $this->captcha->showImg();
      }

      public function error_404()
      {
        $this->load->view('404.html');
      }

}
