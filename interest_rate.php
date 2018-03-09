<?php
$servername = "";
$username = "";
$password = "";
$database = "F16336team2";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
else{
	echo "Connection successful\n";
}
///////////////////////////////////////////////////////////////////
//Get all data
$event="SELECT * FROM currency_exch";
if ($get_fx= $conn->query($event)){
	while ($row=$get_fx->fetch_assoc()) {
    	$fx_data[]=array(
        	'currency_pair' => $row['currency_pair'],
        	'latest_spotrate' => $row['latest_spotrate'],
			'latest_sp_m' => $row['latest_sp_m'],
			'buyer' => $row['buyer'],
        	'highest_bidp_m' => $row['highest_bidp_m'],
        	'curr_num_bids' => $row['curr_num_bids'],
        	'lowest_askp_m' => $row['lowest_askp_m'],
			'curr_num_asks' => $row['curr_num_asks'],
        	'active_traders' => $row['active_traders']
        	);
	}
}
$event="SELECT * FROM exch_stream";
if ($get_es= $conn->query($event)){
    while ($row=$get_es->fetch_assoc()) {
       $es_data[]=array(
           'country' => $row['country'],
           'trader_id' => $row['trader_id'],
            'bid_currency' => $row['bid_currency'],
           'bid_rate' => $row['bid_rate'],
           'ask_currency' => $row['ask_currency'],
           'ask_rate' => $row['ask_rate']
           );
    }
}
$event="SELECT * FROM eu";
if ($get_eu= $conn->query($event)){
	while ($row=$get_eu->fetch_assoc()) {
    	$eu_data[]=array(
        	'currency' => $row['currency'],
        	'ex_rate' => $row['ex_rate'],
        	'curr_sply_m' => $row['curr_sply_m'],
			'bond_sply_m' => $row['bond_sply_m'],
        	'coupon' => $row['coupon'],
			'trade_sr_df_m' => $row['trade_sr_df_m'], 
			'prime_ir' => $row['prime_ir']
        	);
	}
}
$event="SELECT * FROM india";
if ($get_india= $conn->query($event)){
	while ($row=$get_india->fetch_assoc()) {
    	$india_data[]=array(
        	'currency' => $row['currency'],
        	'ex_rate' => $row['ex_rate'],
        	'curr_sply_m' => $row['curr_sply_m'],
			'bond_sply_m'=> $row['bond_sply_m'],
        	'coupon' => $row['coupon'],
			'trade_sr_df_m' => $row['trade_sr_df_m'], 
			'prime_ir' => $row['prime_ir']
        	);
	}
}
$event="SELECT * FROM jp";
if ($get_japan= $conn->query($event)){
	while ($row=$get_japan->fetch_assoc()) {
    	$japan_data[]=array(
        	'currency' => $row['currency'],
        	'ex_rate' => $row['ex_rate'],
        	'curr_sply_m' => $row['curr_sply_m'],
			'bond_sply_m'=> $row['bond_sply_m'],
        	'coupon' => $row['coupon'],
			'trade_sr_df_m' => $row['trade_sr_df_m'], 
			'prime_ir' => $row['prime_ir']
        	);
	}
}
$event="SELECT * FROM uk";
if ($get_uk= $conn->query($event)){
	while ($row=$get_uk->fetch_assoc()) {
    	$uk_data[]=array(
        	'currency' => $row['currency'],
        	'ex_rate' => $row['ex_rate'],
        	'curr_sply_m' => $row['curr_sply_m'],
			'bond_sply_m'=> $row['bond_sply_m'],
        	'coupon' => $row['coupon'],
			'trade_sr_df_m' => $row['trade_sr_df_m'], 
			'prime_ir' => $row['prime_ir']
        	);
	}
}
$event="SELECT * FROM us";
if ($get_us= $conn->query($event)){
	while ($row=$get_us->fetch_assoc()) {
    	$us_data[]=array(
        	'currency' => $row['currency'],
        	'ex_rate' => $row['ex_rate'],
        	'curr_sply_m' => $row['curr_sply_m'],
			'bond_sply_m'=> $row['bond_sply_m'],
        	'coupon' => $row['coupon'],
			'trade_sr_df_m' => $row['trade_sr_df_m'], 
			'prime_ir' => $row['prime_ir']
        	);
	}
}
/////////////////////////////////////////////////////////
//////functions
////PHP Syntax Functions
//Generic function for grabbing DNF of ANDS A.K.A. minterm for array
function fx_to_s($main_array){
	$string=implode(',
', array_map(
        	function ($array) {
            	return sprintf("('%s',%.4f,%.4f,'%s',%.4f,%.4f,%.4f,%.4f,%.4f)",
				$array['currency_pair'], $array['latest_spotrate'], $array['latest_sp_m'],
				$array['buyer'], $array['highest_bidp_m'], $array['curr_num_bids'],
				$array['lowest_askp_m'], $array['curr_num_asks'], $array['active_traders']);
        	},
        	$main_array)).";";
	return $string;
}

function cx_to_s($main_array){
	$string=implode(',
', array_map(
        	function ($array) {
            	return sprintf("('%s',%.4f,%.4f,%.4f,%.4f,%.4f,%.4f)",
				$array['currency'], $array['ex_rate'],
				$array['curr_sply_m'], $array['bond_sply_m'],
				$array['coupon'],$array['trade_sr_df_m'], $array['prime_ir']);
        	},
        	$main_array)).";";
	return $string;
}

function es_to_s($main_array){
    $string=implode(',', array_map(
            function ($array) {
                return sprintf("('%s',%.4f,%.4f,%.4f,%.4f,%.4f)", $array['country'],
                $array['trader_id'],$array['bid_currency'],$array['bid_rate'],
                $array['ask_currency'],$array['ask_rate']);
            },
            $main_array));
    return $string.";";
}

function &get_tuple(array &$tbl, $currency){
	foreach($tbl as &$tuple)
		if($tuple['currency']==$currency)
			return $tuple;
}

function generic_currency_output($data,$country){
	$string="
		REPLACE ".$country." (currency, ex_rate, 
		curr_sply_m, bond_sply_m, coupon, trade_sr_df_m, prime_ir)
			VALUES 
".cx_to_s($data);
	return $string;
}

//turn standard words to Jiacao's table names
function jiacao_trnsltr($country){
	switch ($country){
		case "EU":
			return 'eu';
			break;
		case "INDIA":
			return 'india';
			break;
		case "JAPAN":
			return 'jp';
			break;
		case "UK":
			return 'uk';
			break;
		case "US":
			return 'us';
			break;
	}
}

////Get Functions
function &get_tbl($currency){
	switch ($currency){
		case "EURO":
			global $eu_data;
			return $eu_data;
			break;
		case "RUPEE":
			global $india_data;
			return $india_data;
			break;
		case "YEN":
			global $japan_data;
			return $japan_data;
			break;
		case "POUND":
			global $uk_data;
			return $uk_data;
			break;
		case "USD":
			global $us_data;
			return $us_data;
			break;
	}
}

function &get_tbl2($country){
	switch ($country){
		case "EU":
			global $eu_data;
			return $eu_data;
			break;
		case "INDIA":
			global $india_data;
			return $india_data;
			break;
		case "JAPAN":
			global $japan_data;
			return $japan_data;
			break;
		case "UK":
			global $uk_data;
			return $uk_data;
			break;
		case "US":
			global $us_data;
			return $us_data;
			break;
	}
}

function get_country($currency){
	switch ($currency){
		case "EURO":
			return 'EU';
			break;
		case "RUPEE":
			return 'INDIA';
			break;
		case "YEN":
			return 'JAPAN';
			break;
		case "POUND":
			return 'UK';
			break;
		case "USD":
			return 'US';
			break;
	}
}

////Helper Functions
function remove($string,$trash){
	return str_replace("-", "",str_replace($trash, "",$string));
}
////Table Modifying Functions
//increase supply to buy bonds
function increase_supply($buyers_currency,$cur_sold,$amount){
	$buyer=&get_tbl($buyers_currency);
	$deduct=round($amount/get_tuple($buyer,$cur_sold)['ex_rate'],2);
	foreach($buyer as &$tuple){
		//deplete current own supply
		if($tuple['currency']==$buyers_currency)
			$tuple['curr_sply_m']-=$deduct;
		//replenish current other supply
		if($tuple['currency']==$cur_sold)
			$tuple['curr_sply_m']+=$amount;
	}
}

function update_transaction(array $data,$country, $cur_sold){
	$position=strpos($data[0], "-");
	$from=substr($data[0], 0, $position);
	$to=substr($data[0], $position+1);
	$from_tbl;

	//update the bidder that won: loses money and gains bonds
	if($from==$cur_sold){
		$from_tbl=&get_tbl($to);
		$to=$from;
	}
	else $from_tbl=&get_tbl($from);
	
	foreach($from_tbl as &$tuple)
		if($tuple['currency']==$to){
			$tuple['curr_sply_m']=round($tuple['curr_sply_m']-$data[1]/$tuple['ex_rate'],2);
			$tuple['bond_sply_m']=round($tuple['bond_sply_m']+$data[1]/$tuple['ex_rate'],2);
		}
		
	//Is the asker its own country or is it foreign country
	//Update the asker: get money from the currency sold
	$ask_tbl=&get_tbl2($country);
	foreach($ask_tbl as &$tuple)
		if($tuple['currency']==$cur_sold){
			$tuple['curr_sply_m']+=$data[1];
			//If foreign country
			if($country!=get_country($cur_sold))
				$tuple['bond_sply_m']-=$data[1];
		}
}

function update_fx_rate($data,$cur_sold){
	$position=strpos($data[0], "-");
	$other=substr($data[0], $position+1);
	//update the fx of cur_sold
	$divide=false;
	if($other==$cur_sold)
		$other=substr($data[0], 0, $position);
	//increase rate for this country
	$cur_tbl=&get_tbl($cur_sold);
	foreach($cur_tbl as &$tuple)
		if($tuple['currency']==$other)
			$tuple['ex_rate']*=1+$data[2];
	
	//reduce rate for other country: so reverse divide
	$other_tbl=&get_tbl($other);
	foreach($other_tbl as &$tuple)
		if($tuple['currency']==$cur_sold)
			$tuple['ex_rate']*=1-$data[2];
}

//// Ask/Bid Function
function seller($country, $cur_bought, $cur_sold, $amount, $spot_price){
	echo "\nCommensing Raise of interest rate via increase of coupon...\n";
	global $fx_data;
	//getting the lowest ask
	$ask=PHP_INT_MAX;
	//records which currency in fx_data are bidders
	$bidders=array();
	//records which currency in fx_data needs division
	$div_table=array();
	for($i=0; isset($fx_data[$i]); $i++){
		$pair= $fx_data[$i]['currency_pair'];
		$low_p=$fx_data[$i]['lowest_askp_m'];
		$currency1=strpos($pair,$cur_sold.'-');
		$currency2=strpos($pair,'-'.$cur_sold);
		if($currency1!==false){
			array_push($bidders,$i);
			$div_table[$pair]=0;
			$fx_data[$i]['buyer']=get_country(substr($pair,$currency1+1));
			if($ask>$low_p && $low_p!=0)
				$ask=$low_p*.99;
		}
		if($currency2!==false){
			array_push($bidders,$i);
			$div_table[$pair]=1;
			$fx_data[$i]['buyer']=get_country(substr($pair,0,$currency2));
			if($ask>$low_p/$fx_data[$i]['latest_spotrate'] && $low_p!=0)
				$ask=floor($low_p/$fx_data[$i]['latest_spotrate']*99)/100;
		}
	}
	//set ask amount
	if($ask==PHP_INT_MAX || $ask>$amount)
		$ask=$amount;
	//update asks
	foreach($fx_data as &$tuple){
		$pair=$tuple['currency_pair'];
		$right=strpos($pair,$cur_sold.'-');
		$left=strpos($pair,'-'.$cur_sold);
		if($right!==false){
			$tuple['buyer']=get_country(substr($pair, strpos($pair, "-")+1));
			$tuple['curr_num_bids']=$amount;
			$tuple['lowest_askp_m']=$ask;
		}
		if($left!==false){
			$tuple['buyer']=get_country(substr($pair, 0, $left));
			$tuple['curr_num_bids']=round($amount/$tuple['latest_spotrate'],2);
			$tuple['lowest_askp_m']=round($ask/$tuple['latest_spotrate'],2);
		}
	}
				
	//random bidders outbit previous bids
	$sold=false;
	$track_bids=array(0,0,0,0);
	$bidder=0;
	$bid=$ask;
	//position of the winning exchange;
	$main_bidder;
	echo "\nInitiating Bidding...\n";
	while(!$sold){
		$last_bidder=$bidder;
		$main_bidder=$bidders[$last_bidder];
		$random=mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
		$bidder=floor($random*4);
		$place_holder=$bidder;
		//Checks whether something was tested
		while($track_bids[$bidder] && !$sold){
			$bidder=($bidder+1)%4;
			if($place_holder==$bidder){
				if($div_table[$fx_data[$main_bidder]['currency_pair']])
					$fx_data[$main_bidder]['highest_bidp_m']=
						round($bid/$fx_data[$main_bidder]['latest_spotrate'],2);
				else $fx_data[$main_bidder]['highest_bidp_m']=$bid;
				$sold=true;
			} 
		}
		if(!$sold){
			$random=mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
			$bid=floor($bid*(1+$random*.03)*100)/100;// raise by 2%
			$c_bidder=$bidders[$bidder];
			$track_bids[$bidder]=1;
			$buyers_currency=remove($fx_data[$c_bidder]['currency_pair'],$cur_sold);
			$current_tuple=get_tuple(get_tbl($buyers_currency),$cur_sold);
			if($current_tuple['curr_sply_m']-$bid<0)
				increase_supply($buyers_currency,$cur_sold,200);
			if($div_table[$fx_data[$c_bidder]['currency_pair']])
				$fx_data[$c_bidder]['curr_num_bids']=
					round($bid/$fx_data[$c_bidder]['latest_spotrate'],2);
			else
				$fx_data[$c_bidder]['curr_num_bids']=$bid;
			$fx_data[$c_bidder]['active_traders']++;
			echo "<Bidder:".get_country($buyers_currency).
			     " , Buying:".$cur_sold." , Selling:".$buyers_currency." , Bid:".$bid.">\n";
		}
	}
	//spot_rate changes
	$new_rate_multiplier=.01+floor(mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax()*10)*.01;
	if($div_table[$fx_data[$main_bidder]['currency_pair']])
		$fx_data[$main_bidder]['latest_spotrate']*=1-$new_rate_multiplier;
	else $fx_data[$main_bidder]['latest_spotrate']*=1+$new_rate_multiplier;
	//will return the list of the last pair bid (winner) and how much
	return array($fx_data[$main_bidder]['currency_pair'],$bid,$new_rate_multiplier);
}

///////////////////////////////////////////////////////////////////////////
//First choose the country, currency, etc...
$country_list=array('EU', 'INDIA', 'JAPAN', 'UK', 'US');
//trigger can't update own country so make a variable
$update_own_country=false;
$fx_country='INDIA'; //EU, INDIA, JAPAN, UK, US
$fx_cur_bought='';
$fx_cur_sold='RUPEE';
$fx_amount=100+floor(mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax()*100);//By millions
$fx_spot_price=1; //Depends on the country it is doing business with

//Must increase money supply to increase coupon bonds
$coupon="UPDATE ".jiacao_trnsltr($fx_country)." SET coupon=coupon+1
	WHERE currency='".$fx_cur_sold."'";

//Bids starts
$trigger_coupon="
CREATE TRIGGER coupon_trig
BEFORE UPDATE ON ".jiacao_trnsltr($fx_country)."
FOR EACH ROW BEGIN
	IF OLD.coupon!=NEW.coupon THEN
		REPLACE currency_exch (currency_pair, latest_spotrate, latest_sp_m, buyer,
		highest_bidp_m, curr_num_bids, lowest_askp_m, curr_num_asks, active_traders)
		VALUES 
";
	//start bidding
	$data_to_update=seller($fx_country,$fx_cur_bought,$fx_cur_sold,$fx_amount,$fx_spot_price);
	$trigger_coupon.=fx_to_s($fx_data);
	
	//Update the tables after bidding
	update_transaction($data_to_update, $fx_country, $fx_cur_sold);
	update_fx_rate($data_to_update,$fx_cur_sold);
	foreach($country_list as $country){
		if($country!=$fx_country)
			$trigger_coupon.=generic_currency_output(get_tbl2($country),jiacao_trnsltr($country));
		else $update_own_country=true;
	}
$trigger_coupon.="
	END IF;
END;";

//Since trigger can't update it's own table we make our own update.
$self_update=generic_currency_output(get_tbl2($fx_country),jiacao_trnsltr($fx_country));

//Either way we want to update table if any update happens on currency_exch table
$fx_trigger="CREATE TRIGGER fx_trig
BEFORE UPDATE ON currency_exch
FOR EACH ROW BEGIN
	IF OLD<>NEW THEN";
	foreach($country_list as $country)
		$fx_trigger.=generic_currency_output(get_tbl2($country),jiacao_trnsltr($country));
$fx_trigger.="
	END IF;
END;";

if ($conn->query($trigger_coupon)) {echo "\nCoupon Trigger Updated\n";}
else {echo "\nError: Coupon Trigger not updated\n" . $conn->error."\n";}

//That is if coupon trigger was successful
if($update_own_country){
	if ($conn->query($self_update)){
		echo "\n'".$fx_country."' Updated: since Coupon Trigger can't update its own table.\n";
		}
	else {
		echo "\nError:'".$fx_country."' not updated: since Coupon Trigger can't update its own table,
			so this needs to be updated.\n" . $conn->error."\n";
		}
	$update_own_country=false;
}

if ($conn->query($fx_trigger)) {echo "\nFX Trigger Updated\n";}
else {echo "\nError: FX Trigger not updated\n" . $conn->error."\n";}

if ($conn->query($coupon)) {echo "\nCoupon Updated\n";}
else {echo "\nError: Coupon not updated\n" . $conn->error."\n";}

$conn->close();
?>
