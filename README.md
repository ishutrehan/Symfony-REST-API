# Symfony-REST-API
- Language: **PHP**
- Framework: **Symfony**
1) Create Account `(POST)` <br>
`/api/account/create` <br>
 `parameters are : name, email, password and initial_amount`
 2) Transfer Amount `(POST)`<br>
  `/api/account/transfer`<br>
  `parameters are: sender_id, receiver_id, amount` 
 3) Reterive Balance `(GET)`<br>
  `/api/account/balance/{id}`
 4) Reterive All Customers `(GET)` <br>
  `/api/customers/`
 5) Transfer History `(GET)` <br>
  `api/account/history/{account_id}`
                                 
