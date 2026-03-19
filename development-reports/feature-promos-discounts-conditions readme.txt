Promos and Discounts Condition Feature

19/03/2026

Created the following
1. Model - Promos Condition, Discount Condition
2. Table - create_promo_conditions_table, create_discount_conditions_table
3. Controller - PromoConditionController, DiscountConditionController
4. Actions - Modified CreatePromoAction, CreateDiscountAction, GetPromoAction, GetDiscountAction
5. Seeder - Discounts and Promos
6. Routes - None
 
Functions
1. Created conditions/criteria for both promos and discounts to indicate the condition needed to availe the promo.
2. Created a function to generate a control number for both promos and discounts.
3. Control Number is for tracking and limiting creation of promo and discount PER MONTH.
4. Control Number converts date created to hexadecimal + incremental decimal 00 to 99 to limit only to 100 creation per month.
5. Control Number generation -> YYYY-MM-00 -> 2026-03-00 -> HEXA-HEXA-DECIMAL -> 7EA-3-00.
 

Relations
1. Promo Conditions 
-> Promo
-> Schedule 
-> Ports
-> Vehicle
-> Passenger Type
-> Passenger Accommodation 

2. Discount Conditions
-> Discount
-> Schedule 
-> Port
-> Vehicle
-> Passenger Type 
-> Passenger Accommodation

Notes
1. status indentifer
0 -> pending
1 -> approved/active
2 -> inactive/expired
3 -> cancelled