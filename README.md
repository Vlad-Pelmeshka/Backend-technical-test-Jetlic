# Backend-technical-test-Jetlic

Code return general price sum in the given currency.

The program does not require configuration. You need to run only from the server

**Example for incoming data (AJAX):**

{
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
}

**and result (AJAX):**
{
  "checkoutPrice": 112.39,
  "checkoutCurrency": "EUR"
}
