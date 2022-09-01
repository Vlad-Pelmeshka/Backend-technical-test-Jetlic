<!DOCTYPE html>
<html lang="uk">
  <head>
  	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<title>Document</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

    <button id="get_current_currency_price">Click me</button>
    <div id="current_currency_price"></div>

    <script>
    	let data = {
        "items": {
          "42": {
            "currency": "EUR",
            "price": 49.99,
            "quantity": 1
          },
          "55": {
            "currency": "USD",
            "price": 12,
            "quantity": 3
          },
          "421": {
            "currency": "EUR",
            "price": 2,
            "quantity": 2
          },
          "50": {
            "currency": "JPY",
            "price": 1700,
            "quantity": 1
          },
          "51": {
            "currency": "USD",
            "price": 5,
            "quantity": 2
          },
        },
        "checkoutCurrency": "EUR"
      };

      function getCurrentCurrencyPrice(){
        let encode_data = JSON.stringify(data);
        $.ajax({
          url: '/class_currency-price.php/lol',
          type: 'POST',
          dataType: 'json',
          data: {
            'data'    : encode_data // return correct result
            //'data'    : 'hello'   // return uncorrect result
          },success: function(data) {
            console.log(data);
            // return result on screen
            current_currency_price.innerHTML = (data == 'Error') ? data : data.checkoutPrice + ' ' + data.checkoutCurrency;
          }
        });
      }

      // call function by button click
      get_current_currency_price.addEventListener("click", getCurrentCurrencyPrice);

    </script>
  </body>
</html>