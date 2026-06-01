@foreach($tickets as $ticket)
<body style="margin:0px;padding:0px;">
<table style="margin-top:1.9cm;margin-left:1.3cm;font-size:10pt">
    <tbody>
        <tr>
            <td style="width:5.1cm"></td>
            <td>{{ $ticket['accommodation'] }}</td>
            <td>{{ $ticket['passenger_type'] }}</td>
        </tr>
    </tbody>
</table>
<table style="margin-top:1.5cm;margin-left:1.3cm;font-size:10pt;" cellpadding="0">
    <tbody>
        <tr>
            <td style="width:2.2cm"></td>
            <td colspan="4">{{ $ticket['fullname'] }}</td>
        </tr>
        <tr>
            <td style="width:2.2cm"></td>
            <td style="width:3.2cm">{{ $ticket['travel_date']->format('Y-m-d') }} {{ date('h:i a', strtotime($ticket['departure_time'])) }}</td>
        </tr>
        <tr>
            <td style="width:2.2cm"></td>
            <td style="width:3.2cm">{{ date('Y-m-d') }}</td>
            <td style="width:2.2cm"></td>
            <td style="width:3.2cm"></td>
        </tr>
        <tr>
            <td style="width:2.2cm"></td>
            <td style="width:3.2cm">{{ $ticket['id_number'] }}</td>
        </tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr>
            <td style="width:2.2cm"></td>
            <td style="width:3.2cm"></td>
        </tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr>
            <td style="width:2.2cm"></td>
            <td style="width:3.2cm">{{ $ticket['seat_number'] }}</td>
        </tr>
        <tr>
            <td style="width:2.2cm"></td>
            <td style="width:3.2cm"></td>
            <td style="width:2.2cm"></td>
            <td style="width:3.2cm">{{ $ticket['contact'] }}</td>
        </tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr>
            <td style="width:2.2cm"></td>
            <td style="width:3.2cm">{{ $ticket['fare'] }}</td>
        </tr>
        <tr>
            <td style="width:2.2cm"></td>
            <td style="width:3.2cm">{{ $ticket['convenience_fee'] }}</td>
        </tr>
        <tr>
            <td style="width:2.2cm"></td>
            <td style="width:3.2cm">{{ $ticket['discount'] }}</td>
        </tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr>
            <td style="width:2.2cm"></td>
            <td style="width:3.2cm">{{ $ticket['amount'] }}</td>
        </tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr><td colspan="4"></td></tr>
        <tr>
            <td style="width:2.2cm"></td>
            <td colspan="4">Issued by: {{ $ticket['issued_by'] }}</td>
        </tr>
    </tbody>
</table>
</body>
@endforeach
