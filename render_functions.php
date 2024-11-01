<?php
unset($wr_user);
if (isset($_COOKIE['wr_user_id']) && isset($_COOKIE['wr_api_token'])) {
	$token_status = json_decode($whosright_api->isTokenValid($_COOKIE['wr_api_token']), true);
	//print_r($token_status);
	if ($token_status['status'] == 'ok') {
		$wr_user = $token_status['user'];
	}
}

function shorten($text, $chars) { 
	if (strlen($text) > $chars) {
		$text = $text." "; 
		$text = substr($text,0,$chars); 
		$text = substr($text,0,strrpos($text,' ')); 
		$text = $text."..."; 
	}
	return $text; 
} 

class WhosrightPoll {
	var $wr_poll;
	var $wr_pager;
	var $wr_related;
	var $wr_host;
	var $wr_plugin_url;
	var $wr_image_host;
	var $wr_user;
	var $wr_id;
	var $wordpress_id;
	var $api;

	function __construct($wordpress_id) {
		$this->wr_host = $this->wr_image_host = WR_API_HOST;
		$this->wr_image_host = 'http://whosright.com';
		$this->wr_plugin_url = get_option('siteurl')."/wp-content/plugins/whosright";
		$this->wr_id = get_post_meta($wordpress_id, '_whosright_id', true);
		global $wr_user;
		$this->wr_user = $wr_user;
		global $whosright_api;
		$this->api = $whosright_api;
		$this->wordpress_id = $wordpress_id;

		if ($this->wr_id) {
			$poll_data_json = $this->api->getPoll($this->wr_id, @$_COOKIE['wr_api_token']);
			if (isset($_GET['debug'])) {
				echo $poll_data_json;
			}
			$data = json_decode($poll_data_json, true);
			if (substr($data['post']['user']['thumb'], 0, 1) == '/') {
				$data['post']['user']['thumb'] = $host.$data['post']['user']['thumb'];
				$data['post']['user']['small_thumb'] = $host.$data['post']['user']['small_thumb'];
			}

			if (!$this->wr_user) {
				$poll_id = $data['post']['id'];
				if (isset($_COOKIE['voted_'.$poll_id]) && $data['post']['hide_results'] == 0) {
					$letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
					$vote_choice = $_COOKIE['voted_'.$poll_id];
					$ret = $letters[$vote_choice];
					$data['post']['vote_result'] = $letters[$vote_choice];
				}
			}

			$this->wr_poll = $data['post'];
			$this->wr_pager = $data['pages'];

			global $wpdb;
	//		print_r($wr_poll);
	//		print_r($data);

			if (isset($this->wr_poll['related'])) {
				$tmp = array();
				for ($i = 0; $i < count($this->wr_poll['related']); $i++) {
					$wr_id = $this->wr_poll['related'][$i]['id'];
					$query = "SELECT post_id FROM wp_postmeta WHERE meta_key = '_whosright_id' AND meta_value = '{$wr_id}' LIMIT 1";
					$result = $wpdb->get_results($query, OBJECT);
					if (count($result)) {
						$wp_id = $result[0]->post_id;
						$this->wr_poll['related'][$i]['permalink'] = get_permalink($wp_id);
						$tmp[] = $this->wr_poll['related'][$i];
					}
				}
				$this->wr_poll['related'] = $tmp;
				$this->wr_related = $this->wr_poll['related'];
				//print_r($wr_related);
			} else {
				$this->wr_related = array();
			}

			$wr_poll = $this->wr_poll;
			$wr_pager = $this->wr_pager;
			$wr_related = $this->wr_related;
			$wr_host = $this->wr_host;
			$wr_plugin_url = $this->wr_plugin_url;
			$wr_image_host = $this->wr_image_host;
			$wr_user = $this->wr_user;

			//print_r($this->wr_poll);
			if (isset($_GET['no_layout'])) {
				if ($this->wr_poll['advanced']) {
					require_once('tpl/wr_poll_full_advanced_options.php');
				} else {
					if ($_GET['mode'] == 'list') {
						require_once('tpl/wr_poll_in_list.php');
					} else {
						require_once('tpl/wr_poll_full_header.php');
					}
				}
				exit;
			}
		}
	}

	function getCommentCount() {
		if ($this->wr_poll) {
			return $this->wr_poll['comments'];
		}
		return 0;
	}

	function render_poll() { 
		require_once('user_styles.php');
		$wr_poll = $this->wr_poll;
		$wr_pager = $this->wr_pager;
		$wr_related = $this->wr_related;
		$wr_host = $this->wr_host;
		$wr_plugin_url = $this->wr_plugin_url;
		$wr_image_host = $this->wr_image_host;
		$wr_user = $this->wr_user;
		$auto_generated = get_post_meta($this->wordpress_id, '_whosright_autogenerated', true);
		if ($auto_generated == '' && $wr_poll['title'] != '') {
			echo "<div id='whosright'><div class='poll_full_wrapper'>";
			if ($wr_poll['advanced']) { 
				include('tpl/wr_poll_full_advanced.php');
			} else {
				include('tpl/wr_poll_full.php');
			}
			echo "</div></div>";
		}
	}

	function render_comments() {
		require_once('user_styles.php');
		$wr_poll = $this->wr_poll;
		$wr_pager = $this->wr_pager;
		$wr_related = $this->wr_related;
		$wr_host = $this->wr_host;
		$wr_plugin_url = $this->wr_plugin_url;
		$wr_image_host = $this->wr_image_host;
		$wr_user = $this->wr_user;

		echo "<div id='whosright'>";
		include('tpl/wr_comments.php');
		include('tpl/wr_pager.php');
		echo "</div>";
	}

	function whosright_poll_short() {
		require_once('user_styles.php');
		$wr_poll = $this->wr_poll;
		$wr_pager = $this->wr_pager;
		$wr_related = $this->wr_related;
		$wr_host = $this->wr_host;
		$wr_plugin_url = $this->wr_plugin_url;
		$wr_image_host = $this->wr_image_host;
		$wr_user = $this->wr_user;
		if (!isset($this->wr_poll['related'])) { $this->wr_poll['related'] = $this->wr_related; }

		echo "<div id='whosright'><div class='poll_full_wrapper'>";
		if ($wr_poll['advanced']) { 
			//$wr_poll['list_mode'] = 1;
			include('tpl/wr_poll_full_advanced.php');
		} else {
			include('tpl/wr_poll_in_list.php');
		}
		echo "</div></div>";
	}
}
