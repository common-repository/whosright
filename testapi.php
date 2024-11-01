<?php
	require_once('WhosRightApiV1.php');
	
	//echo "test";
	$wr = new WhosRightApiV1('R1_4c71b6cb49f9a682524147', 'ecacc0f0b638f3de478212fb514831e0', 'http://localhost/api/v1/');                                // localhost
	//$wr = new WhosRightApiV1('R1_4c71d19408742175100087', '24369ac7334847a4b658b0fcd4a9d40d');                                                              // production
	//$wr = new WhosRightApiV1('R1_4c71d19408742175100087', '24369ac7334847a4b658b0fcd4a9d40d', 'http://v2.whosrite.com/api/v1/', true, 'wr', 'beta123');   // dev
	//$response_json = $wr->getPoll(6808, 'e2ce1977eb7b66cbe0c96b23bcf551ea');
	//$response_json = $wr->getPolls();
	//$response_json = $wr->uploadAttachment ("C:\Users\Owner\Pictures\england\IMG_0471.JPG");
	//$response_json = $wr->addPoll(array('title' => 'test api title', 'desc' => 'test api desc', 'tags' => 'test api tags', 'category' => 1, 'option_1' => 'yes', 'option_2' => 'no'));
	//$response_json = $wr->editPoll(array('poll_id' => '6714', 'title' => 'test api titlehaha', 'desc' => 'test ap"i desc', 'tags' => 'test api tags', 'category' => 1, 'option_1' => 'yes', 'option_2' => 'no'));
	//$response_json = $wr->isTokenValid ('1c00d8416978fdce5370e3e9f025ca1c');
	//$response_json = $wr->isTokenValid ('123');
	//$response_json = $wr->vote (6693, 1, 'e2ce1977eb7b66cbe0c96b23bcf551ea');
	//$response_json = $wr->addComment (6693, 'test api comment', 63229, 'e2ce1977eb7b66cbe0c96b23bcf551ea');
	//$response_json = $wr->editComment (6693, 63229, 'e2ce1977eb7b66cbe0c96b23bcf551ea', "updated comment bla'h");
	
	echo $response_json;
?>
