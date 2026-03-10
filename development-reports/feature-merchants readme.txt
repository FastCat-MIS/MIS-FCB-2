Merchants Management Module - Feature

09/03/2026

Created the following
1. Model - Merchant, MerchantDiscount
2. Table - create_merchants_table, create_merchant_discounts_table
3. Controller - MerchantController, MerchantDiscountController
4. Actions - CRUD for Merchant and Merchant Discount
5. Seeder - Merchant and Merchant Discount
6. Routes - Merchant and Merchant Discount

  GET|HEAD  merchants 
  POST      merchants 
  POST      merchants/discounts
  PUT       merchants/{merchantDiscountId}/discounts 
  DELETE    merchants/{merchantDiscountId}/discounts 
  PUT       merchants/{merchantId} 
  DELETE    merchants/{merchantId} 
  GET|HEAD  merchants/{merchantId} 
  GET|HEAD  merchants/{merchantId}/discounts 
  POST      merchants/{merchantId}/reset-password 

Functions
1. Reset Password function for Merchant to default password
2. GET function for IA Discounts is bound to a specific Merchant Discount, NO FUNCTION FOR GET ALL DISCOUNTS -> ONLY DEFINED BY PASSED IA ID
3.  ALL CRUD FOR IA DISCOUNT DEFINED BY PASSED IA DISCOUNT ID

Relations
1. Merchant -> Merchant Discounts
2. Route -> Merchant Discounts

Notes
1. discount_type determins if discount_value is "percentage" or "fixed, to determine computation if percentage discount or a fixed amount
2. discount_name determines what discount is under a route, to clarifiy, every route for each account has different discount rates and discount names (i.e BAT-CAL, PWD/BUS/VIP, etc.) under an account can have multiple discounts with different discount rates per different routes.
3. image variable for insitutional account determines their company/agency logo, pending for proper function.