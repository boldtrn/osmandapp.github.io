<?
include_once 'db_queries.php';
$res = getRecipients();
$cnt = getCountries();
// "All payments are done from <strong>1GRgEnKujorJJ9VBa76g8cp3sfoWtQqSs4</strong> Bitcoin address. ";
//  "The payouts are distributed based on the ranking which is available on the OSM Contributions tab, the last ranking has weight = 1, the ranking before the last has weight = 2 and so on till the 1st ranking.<br>";
// var rg = recipientRegionName == '' ? 'Worldwide' : recipientRegionName; 
$explanation = "All donations are distributed between registered recipients according 
	to their ranking based on the number of changes done in the selected region. 
	Half of donations is distributed between all osm editors and displayed for the 'Worldwide' region. 
	The other half is distributed between osm editors of specific regions which are selected as 'Preferred region' by supporters.";
$visibleReg = $res->region;
if($res->region == '') {
	$visibleReg = "Worldwide";
} else {
	for($i = 0; $i < count($cnt->rows); $i++) {
		if($cnt->rows[$i]->downloadname == $res->region) {
			$visibleReg = $cnt->rows[$i]->name;
			break;
		}
	}
}
if(is_null(getReport('getBTCValue'))) {
	$res->message = $explanation;
	$res->message = $res->message . "<br><br>Approximate collected sum is <strong>" . 
					number_format($res->btc * 1000, 3) . "</strong> mBTC in total " .
					"and specially collected for <strong>{$visibleReg}</strong> region is <strong>"  .
				  	number_format($res->regionBtc*1000, 3) . "</strong> mBTC.<br>";

} else {
	$res->message = $explanation;
	$res->message = $res->message . "<br><br>Collected sum is <strong>" . 
					number_format($res->btc * 1000, 3) . "</strong> mBTC in total " .
					"and specially collected for <strong>{$visibleReg}</strong> region is <strong>"  .
				  	number_format($res->regionBtc*1000, 3) . "</strong> mBTC.<br><br>";
	if($res->month == '2016-01') {
		$res->message = $res->message . 'Payouts: <a href="https://blockchain.info/tx/d5d780bb8171e6438531d4b439d55f6e299c5f70d352ade6db98c7d040baf02c">Transaction #1</a>';
	} else if($res->month == '2016-02') {
		$res->message = $res->message . 'Payouts: <a href="https://blockchain.info/tx/8158da594891265e36ec2ba531061e7edcde27e2a46b459c9019bfa280b2cf85">Transaction #1</a>';
	} else if($res->month == '2016-03') {
		$res->message = $res->message . 'Payouts: <a href="https://blockchain.info/tx/3972ae6a30ed4a97f3b448f5bef360e6ca9858dec4e2c1fce4d5971b0897823e">Transaction #1</a>';
		$res->message = $res->message . ',<nbsp><a href="https://blockchain.info/tx/3f1fc2d9bd0abc184d77d5457c915ed5252bce21dfda0299347fee863423ee73">Transaction #2</a>';
		$res->message = $res->message . ',<nbsp><a href="https://blockchain.info/tx/b86aa1773e2c256da33632c725b1d5c5227aad406bff5fbf27924c30298ec426">Transaction #3</a>';
		$res->message = $res->message . ',<nbsp><a href="https://blockchain.info/tx/513f7ada01e01cbb56f87ea8d70c8da4e3b8c9e49e19c44813f7a56669b499d3">Transaction #4</a>';
		
	}
}
        
echo json_encode($res);
?>
