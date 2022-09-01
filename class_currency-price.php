<?php
class CurrencyPrice
{
	// API key for fastforex.io
    const  api_key = 'd2802ce12a-eea7b9e820-rhhkjb';

    private function getCurrencyRatio($from, $to)
    {
    	/*

    		CURL function
			return result of currency difference

    	 */
    	$curl = curl_init();

		$arrayCurl = array(
			'from' => $from,
			'to' => $to,
			'api_key' => self::api_key,
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.fastforex.io/fetch-one?' . http_build_query($arrayCurl),
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = curl_exec($curl);

		curl_close($curl);

		// return only currency difference from all data
		$result = json_decode($response)->result->$to;

    	return $result;
    }

    public function currentCurrencyPrice($data)
    {

    	// decode data
    	$data = json_decode($data);

    	if($data){

    		// current currency
    		$checkoutCurrency = $data->checkoutCurrency;

    		$checkoutPrice = 0;

    		$otherCurrency = array();

    		/*
    			If currency of product = current currency then add item to general sum.
    			Else, create a new array to organize a query to get the currency ratio
			*/
    		foreach ($data->items as $key => $item) {

    			if($item->currency == $checkoutCurrency){
    				$checkoutPrice += $item->price * $item->quantity;
    			}else{
    				$otherCurrency[ $item->currency ][] = $item;
    			}
    		}

    		foreach ($otherCurrency as $key => $currencyItem) {
    			//Serial question of all currencies for each order item
    			$ratio = self::getCurrencyRatio($key, $checkoutCurrency);

    			// Add item to general sum with currency ratio
    			foreach ($currencyItem as $item) {
    				$checkoutPrice += $item->price * $item->quantity * $ratio;
    			}
    		}

    		// Create ansver to json request
    		$result = array(
    			'checkoutPrice' => round($checkoutPrice, 2),
    			'checkoutCurrency' => $checkoutCurrency
    		);

    	}
    	else{
    		$result = 'Error';
    	}
    	return json_encode($result);
    }
}

if($_POST['data']){
	// Create new object and return "checkoutPrice" & "checkoutCurrency"
	$objCurrencyPrice = new CurrencyPrice();
	$result = $objCurrencyPrice->currentCurrencyPrice($_POST['data']);

	// Header json to return result as json from ajax request
	header('Content-Type: application/json');
	echo $result;
}