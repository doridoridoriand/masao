<?php
/* # ミニマム機能
   - パースした結果の表示
*/

require('./elements/header.php');
require('./helpers/parseResultViewHelper.php');
require('./helpers/parseListViewHelper.php');

//sidebar
echo '
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<ul class="nav nav-sidebar">
			';
			$parseResultViewHelper->parseListHTMLConverter();
echo '
			</ul>
		</div>
		';

//main content
echo '
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-contents-position">
			<h1 class="page-header">パースしたコンテンツ</h1>
				<div class="table-responsive">
					<table class="table table-striped">
						<thread>
							<tr>
								<th>記事タイトル</th>
								<th>記事本文一部</th>
								<th>リンク先</th>
								<th>更新日時</th>
							</tr>
						</thread>
						<tbody>
		';
		$listArray = $parseListViewHelper->loadParseList();

		foreach ($listArray as $value) {
			echo '<td id="';
			print(($value[0]));
			echo '">';
			print(($value[0]));
			echo '</td>';
			$parseResultViewHelper->parseContentHTMLConverter($value[0], 'ALL');
		}
echo '
		</div>';		