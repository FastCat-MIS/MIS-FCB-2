<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<style>
body {

}
.table__body td {
    border-bottom: 1px solid black;
    font-size: 11px;
    width: 100%;
    padding: 5px;

}

 table__body {
    border-collapse: collapse;
 }
 
 .table__second {
    border-collapse: collapse;
 }
 .table__second td {
    border: 1px solid black;
    text-align:center;
    padding: 5px;
 }
 .table__second td:last-child {
     border-right: none;
 }
 .table__second td:first-child {
     border-left: none;
 }
 .heading__text {
     font-size: 14px;
     font-weight: 600;
     padding: 20px 0;
 }
 .logo {
     font-size: 30px;
     font-weight: 900;
 }

</style>
<body style="margin:0px;padding:0px;">

@foreach($waybills as $waybill)
<table class="table__body" style="font-size:10pt;">
<thead>
 <tr>
 
 <td class="logo" style="border: none"; colspan="2"><img style="width: 150px; height: 75px;"src="https://cdn.jsdelivr.net/gh/tovvydumaplin/image/black_logo.png"></td>
 <td style="border: none"; colspan="4">
    <strong>Archipelago Philippine Ferries Corporation</strong><br>
    <small>Unit 5b, 5th Floor UNIOIL Center Bldg. Commerce Ave.,</small>
    <small>Madrigal Business Park, Ayala Alabang Muntinlupa City</small>
    <small>Tel. No.:831-5212/816-1183 Fax No.:842-93-41/42</small>
    <small>VAT REG. Tin : 223-662-279-000</small>
 </td>
</tr>
<tr>
    <td class="heading__text" style="border: none"; colspan="12"><center>BILL OF LADING</center></td>
</tr>
</thead>
    <tbody class="t__body">
        <tr>
            <td style="width:2.2cm; border: none;">Voyage No.:</td>
            <td>{{ $waybill['voyage_code'] }}</td>
            <td style="padding-left: 10px; width:2.2cm; border: none; margin-left: 10px;">Series Number:</td>
            <td style="width: 100%";>{{ $waybill['series_number'] }}</td>
        </tr>
        <tr>
            <td style="width:2.2cm; border: none;">FERRY:</td>
            <td style="padding-left: 10px;">{{ $waybill['vessel_name'] }}</td>
            <td style="padding-left: 10px; width:2.2cm; border: none;">DATE:</td>
            <td style="padding-left: 10px;">{{ $waybill['travel_date']->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <td style="width:2.2cm; border: none;">SHIPPER:</td>
            <td style="width:6.3cm; padding-left: 10px;">{{ $waybill['shipper'] }}</td>
            <td style="padding-left: 10px; width:2.2cm; border: none;">ADDRESS:</td>
            <td>{{ $waybill['address'] }}</td>
        </tr>  
        <tr>
            <td style="width:2.2cm; border: none;">PT. OF ORIGIN:</td>
            <td style="padding-left: 10px;">{{ $waybill['port_origin'] }}</td>
            <td style="padding-left: 10px; width:2.2cm; border: none;">DESTINATION:</td>
            <td style="padding-left: 10px;">{{ $waybill['port_destination'] }}</td>
        </tr>
    </tbody>
</table>

<table class="table__second" style="margin-top:0.5cm; border: 1px solid black; margin-left:0; font-size:10pt; width: 100%;" cellpadding="0">
    <tbody>
    <tr>
        <td>CLASSIFICATION</td>
        <td>DESCRIPTION</td>
        <td>QTY</td>
        <td>VALUE</td>
        <td>WT</td>
        <td>RATE</td>
        <td>FREIGHT CHARGES</td>
    </tr>
    <tr>
        <td>{{ $waybill['classification'] }}</td>
        <td>{{ $waybill['description'] }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td>{{ $waybill['rate'] }}</td>
        <td>P {{ $waybill['freight_charges'] }}</td>
    </tr>
    <tr>
        <td style="color: transparent">A</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="color: transparent">A</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="color: transparent">A</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="color: transparent">A</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="color: transparent">A</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><strong>TOTAL</strong></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>P {{ $waybill['freight_charges'] }}</td>
    </tr>
</tbody>
</table>
<table class="table__bottom" style="margin-top:0.5cm; margin-left:0; font-size:10pt; width: 100%; border-collapse: collapse; border-spacing: 10px; border: 1px solid black;" cellpadding="0">
<tbody>
    <tr>
        <td colspan="2">Add: Other Charges (Specify)</td>
        <td style="border: none"></td>
        <td colspan="2"></td>
        <td style="border: none"></td>
        <td style="border: none">Admin Fee: {{ $waybill['admin_fee'] }}</td>
        <td style="border: none"></td>
    </tr>
    <tr>
        <td style="border: none"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td style="border: none"></td>
        <td style="border: none"></td>
        <td style="border: none"></td>
    </tr>
    <tr>
        <td style="border: none"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td style="border: none"></td>
        <td style="border: none"></td>
        <td style="border: none"></td>
    </tr>
    <tr>
        <td style="border: none">TOTAL CHARGES</td>
        <td style="border: none"></td>
        <td style="border: none"></td>
        <td style="border: none"></td>
        <td style="border: none"></td>
        <td colspan="2" style="text-align: right">P {{ $waybill['total_charges'] }}</td>
        <td style="border: none"></td>
    </tr>
    <tr>
        <td colspan="8"></td>
    </tr>
    <tr>
        <td style="border: 1px solid black" colspan="8">Amount in Words: <strong>{{ $waybill['amount_in_words'] }}</strong></td>

    </tr>
    <tr>
        <td style="border: 1px solid black; padding-right: 70px;" colspan="4">This is to certify that the shipper is agreeable to the terms and conditions stated on the reverse side of this document</td>
        <td colspan="4" rowspan="2" style="font-size: 15px; text-align: center; font-weight: 600; border: 1px solid black">PERSONAL COPY</td>
    </tr>
    <tr>
        <td colspan="4" style="border: 1px solid black;">Shipper Signature</td>
    </tr>
    <tr>
        <td style="padding: 50px; border: 1px solid black" colspan="2">
            <img src='https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $waybill['qr_data'] }}' width='100' height='100'/>
        </td>
        <td style="border: 1px solid black; padding: 0 100px" colspan="6">This QR code is intended for single-use upon passenger onboarding. Kindly present it to our personnel for verification.</td>
    </tr>
    <tr>
        <td style="border: 1px solid black" colspan="4">Archipelago Philippine Ferries Corporation 6th Floor Unioil Center Bldg., Commerce Avenue corner Acacia Avenue, Madrigal Business Park, Ayala Alabang, Muntinlupa City, 1780</td>
        <td style="border: 1px solid black; text-align: right" colspan="4">customercare@apfc.com.ph</br>fastcatinquiries@apfc.com.ph</br>(632) 8831 5212, 0906-367-0007</td>
    </tr>
</tbody>
</table>
<center>
<div style="position: absolute; top: 25%; left: 7.5%;">
    <div style="width: 100%; z-index: -1; font-weight: 900; font-size: 150px; opacity: 0.05">
        <img style="width: 600px; height: 300px;"src="https://cdn.jsdelivr.net/gh/tovvydumaplin/image/black_logo.png">
    </div>
</div>
</center>

<div style="page-break-after: always;"></div>
@endforeach

</body>
</html>
