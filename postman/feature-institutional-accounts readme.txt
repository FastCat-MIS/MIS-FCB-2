Institutional Accounts Management Module - Feature

09/03/2026

Created the following
1. Model - InstitutionalAccount, IADiscount
2. Table - create_institutional_accounts_table, create_ia_discounts_table
3. Controller - InstitutionalAccountController, IADiscountController
4. Actions - CRUD for Institutional Account and IA Discount
5. Seeder - Institutional Account and IA Discount
6. Routes - Institutional Account and IA Discount

 POST      institutional-accounts 
 POST      institutional-accounts/discounts   
 PUT       institutional-accounts/{iaDiscountId}/discounts 
 DELETE    institutional-accounts/{iaDiscountId}/discounts
 GET|HEAD  institutional-accounts/{iaId} 
 PUT       institutional-accounts/{iaId} 
 GET|HEAD  institutional-accounts/{iaId}/discounts 
 POST      institutional-accounts/{iaId}/reset-password 
 
Functions
1. Reset Password function for Institutional Account to default password
2. GET function for IA Discounts is bound to a specific Institutional Discount, NO FUNCTION FOR GET ALL DISCOUNTS -> ONLY DEFINED BY PASSED IA ID
3.  ALL CRUD FOR IA DISCOUNT DEFINED BY PASSED IA DISCOUNT ID

Relations
1. Institutional Account -> Institutional Account Discounts
2. Route -> Institutional Account Discounts

Notes
1. discount_type determins if discount_value is "percentage" or "fixed, to determine computation if percentage discount or a fixed amount
2. discount_name determines what discount is under a route, to clarifiy, every route for each account has different discount rates and discount names (i.e BAT-CAL, PWD/BUS/VIP, etc.) under an account can have multiple discounts with different discount rates per different routes.
3. image variable for insitutional account determines their company/agency logo, pending for proper function.