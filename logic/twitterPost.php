<?php
//twitteroauthを読み込んで、contentSorterから渡されたコンテンツ内容を指定されたアカウントでつぶやく

require ('./helpers/twitteroauth.php');

class twitterPoster {

	/* contentSorterから受け取った配列の要素を順番にpostする
	*/
	public function post() {

	}

	/* twitterAPIを叩くために使用する、twitteroauthライブラリ設定値など
	*/
	public function twitterConfigure() {
		//$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
		$connection = new TwitterOAuth('soeDsIdILfaMrIsaDu5JBuYjU', 'NuTI6Gdfqk5Zx52gyR9ENjRdQDf3TK8tOHfEfF1fBVmDQqolZH');
		var_dump($connection);
		$temporary_credentials = $connection->getRequestToken(OAUTH_CALLBACK);
		var_dump($temporary_credentials);
		//$redirect_url = $connection->getAuthorizeURL($temporary_credentials);
		$redirect_url = $connection->getAuthorizeURL($temporary_credentials, FALSE);

		$account = $connection->get('account/verify_credentials');
		var_dump($account);
		$status = $connection->post('statuses/update', array('status' => 'Text of status here', 'in_reply_to_status_id' => 123456));
		var_dump($status);
		//$status = $connection->delete('statuses/destroy/12345');
	}
}

$twitterPoster = new twitterPoster;
$twitterPoster->twitterConfigure();
