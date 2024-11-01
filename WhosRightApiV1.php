<?php
require_once('config.php');
	
class WhosRightApiV1 {
    private $api_key;
	private $shared_secret;
	private $url;
	private $status;
	private $use_auth;
	private $username;
	private $password;
	 
	public function __construct($p_api_key, $p_shared_secret, $p_url= 'http://whosright.com/api/v1/', $p_use_auth=USE_HTTP_AUTH, $p_username=WR_API_USER, $p_password=WR_API_PASS) {
		$this->api_key = $p_api_key;
		$this->shared_secret = $p_shared_secret;
		$this->url = $p_url;
		
		$this->use_auth = $p_use_auth;
		$this->username = $p_username;
		$this->password = $p_password;
	}

	// must be called before appending any other parameters
	private function getBaseUrlWithSignature ($url) {
		$timestamp = gmdate('D, d M Y H:i:s \G\M\T');
		$signature = base64_encode(hash_hmac('sha1', $timestamp, $this->shared_secret));
		
		$url = $url."?api_key=".urlencode($this->api_key)."&timestamp=".urlencode($timestamp)."&signature=".urlencode($signature);

		return $url;
	}
	
	private function makeRequest($url, $isPost=false, $postFieldArray=false){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if ($isPost) {
			curl_setopt($ch, CURLOPT_POST, TRUE);
		}
		if ($postFieldArray) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postFieldArray);
		}
		if ($this->use_auth) {
			curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
		}
		$content = curl_exec($ch);
		$this->status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return $content;
	}
	
	public function getPoll ($poll_id, $api_token=false) {
		$url = $this->url."getpoll.json";
		$url = $this->getBaseUrlWithSignature ($url);
		if ($api_token !== false) {
			$url = $url."&api_token=$api_token";
		}
		$url = $url."&poll_id=$poll_id";
		
		$response = $this->makeRequest($url);
		
		return $response;
	}
	
	public function loginFacebook($access_token) {
		return $this->makeRequest($this->getBaseUrlWithSignature($this->url.'loginfacebook.json')."&access_token=$access_token");
	}
	
	public function loginTwitter($twitter_oauth_token, $twitter_oauth_token_secret, $twitter_user_id, $twitter_screen_name) {
		return $this->makeRequest(
			$this->getBAseUrlWithSignature($this->url.'logintwitter.json')
			."&twitter_oauth_token=$twitter_oauth_token&twitter_oauth_token_secret=$twitter_oauth_token_secret&twitter_user_id=$twitter_user_id&twitter_screen_name=$twitter_screen_name"
		);	
	}
	
	public function deletePoll ($poll_id, $api_token=false) {
		$url = $this->url."deletepoll.json";
		$url = $this->getBaseUrlWithSignature ($url);
		if ($api_token !== false) {
			$url = $url."&api_token=$api_token";
		}
		$url = $url."&poll_id=$poll_id";
		
		$response = $this->makeRequest($url);
		
		return $response;
	}

	public function getPolls ($start=0, $limit=10) {
		$url = $this->url."getpolls.json";
		$url = $this->getBaseUrlWithSignature ($url);

		$url = $url."&start=$start";
		$url = $url."&limit=$limit";
		
		$response = $this->makeRequest($url);
		
		return $response;
	}

	public function uploadAttachment ($temp_file_name, $orig_file_name) {
		$url = $this->url."uploadattachment.json";
		$url = $this->getBaseUrlWithSignature ($url);
		$postFieldArray = array ('photo' => "@$temp_file_name", 'name' => "$orig_file_name");
		
		$response = $this->makeRequest($url, true, $postFieldArray);
		
		return $response;
	}

	public function addPoll ($post_params) {
		$url = $this->url."addpoll.json";
		$url = $this->getBaseUrlWithSignature ($url);
		$postFieldArray = array ('post_params' => json_encode($post_params));
		
		$response = $this->makeRequest($url, true, $postFieldArray);
		
		return $response;
	}
	
	public function editPoll ($post_params) {
		$url = $this->url."editpoll.json";
		$url = $this->getBaseUrlWithSignature ($url);
		$postFieldArray = array ('post_params' => json_encode($post_params));

		$response = $this->makeRequest($url, true, $postFieldArray);
		
		return $response;
	}
	
	public function isTokenValid ($api_token) {
		$url = $this->url."istokenvalid.json";
		$url = $this->getBaseUrlWithSignature ($url);
		$url = $url."&api_token=$api_token";
		
		$response = $this->makeRequest($url);
		
		return $response;
	}
	
	public function vote ($poll_id, $option_index, $code, $api_token=false) {
		$url = $this->url."vote.json";
		$url = $this->getBaseUrlWithSignature ($url);
		
		if ($api_token !== false) {
			$url = $url."&api_token=$api_token";
		}
		$url = $url."&poll_id=$poll_id";
		$url = $url."&option_index=$option_index";
		$url = $url."&code=$code";
		
		$response = $this->makeRequest($url);
		
		return $response;
	}
	
	public function addComment ($poll_id, $comment, $parent_id=0, $attach_media = '', $anonymous = false, $api_token=false) {
		$url = $this->url."addcomment.json";
		$url = $this->getBaseUrlWithSignature ($url);
		
		$comment = urlencode($comment);
		
		if ($api_token !== false) {
			$url = $url."&api_token=$api_token";
		}
		$url = $url."&poll_id=$poll_id";
		$url = $url."&comment=$comment";
		$url = $url."&parent_id=$parent_id";
		$url = $url."&attach_media=$attach_media";
		$url = $url."&anonymous=$anonymous";
		
		$response = $this->makeRequest($url);
		return $response;
	}
	
	public function editComment ($poll_id, $comment_id, $api_token, $comment) {
		$url = $this->url."editcomment.json";
		$url = $this->getBaseUrlWithSignature ($url);
		
		$comment = urlencode($comment);
		
		$url = $url."&api_token=$api_token";
		$url = $url."&poll_id=$poll_id";
		$url = $url."&comment=$comment";
		$url = $url."&comment_id=$comment_id";

		$response = $this->makeRequest($url);
		
		return $response;
	}

	public function deleteComment ($poll_id, $comment_id, $api_token) {
		$url = $this->url."deletecomment.json";
		$url = $this->getBaseUrlWithSignature ($url);
		
		$comment = urlencode($comment);
		
		$url = $url."&api_token=$api_token";
		$url = $url."&poll_id=$poll_id";
		$url = $url."&comment_id=$comment_id";

		$response = $this->makeRequest($url);
		
		return $response;
	}

	public function getAdmin () {
		$url = $this->url."getadmin.json";
		$url = $this->getBaseUrlWithSignature ($url);
				
		$response = $this->makeRequest($url);
		
		return $response;
	}
	
}
?>
