<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Ticket</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <style>
        body {
            font-size: 8px;
        }
        .table {
            font-size: 8px;
            margin-right: 50px;
            margin-top: 60px;
            margin-bottom: 50px;
        }
        .table td, .table th {
            border: none; /* Remove table borders */
        }
        @media print {
            body, .table {
                font-size: 8px;
            }
            .download-hide, .return-hide {
                display: none !important;
            }
            @page {
                size: 56mm roll;
            }
        }

        .hidden {
            display: none;
        }
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            cursor: pointer;
        }
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            color: #fff;
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-primary:focus, .btn-primary.focus {
            box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .5);
        }
        .button-container {
            display: flex;
            flex-direction: column;
        }
        
        .left-button, .right-button {
            width: 50%;
        }
        
        .left-button {
            float: left;
        }
        
        .right-button {
            float: right;
        }
        
        /* Optional: Add margin or padding for spacing */
        .left-button {
            margin-bottom: 10px; /* Adjust as needed */
        }
        
        .right-button {
            margin-bottom: 10px; /* Adjust as needed */
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .button-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-bottom: 10px; /* Adjust as needed */
        }
        
        button {
            width: auto;
        }
        
    </style>
    <script>
        function printPage() {
            // Call the print function defined in the Android interface
            Android.printPage();
        }
    </script>
</head>
<body>

@foreach($tickets as $ticket)
    <center>
        <table class="table table-responsive">
            <tbody>
            <tr>
                <td colspan="2">
                    <center><img src="/assets/img/fastcat.png" width="50"/></center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center>Archipelago Philippine Ferries Corporation<br/><br/><small>TEL NO. : (02) 8842 9341</small></center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center>Ticket No</center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center>{{ $ticket['booking_number'] }}</center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center><img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $ticket['qr_data'] }}" id="qrcode" width="80" height="80"/></center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center>
                        <b>Date</b><br/>
                        {{ $ticket['travel_date']->format('F j, Y') }}
                    </center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center><b>Fullname</b><br/>{{ $ticket['fullname'] }}</center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center><b>Accommodation</b><br/>{{ $ticket['accommodation'] }}</center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center><b>Seat No</b><br/>{{ $ticket['seat_number'] }}</center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                   <center>
                        <b>Departure Time</b><br/>
                        {{ date('g:i A', strtotime($ticket['departure_time'])) }}
                    </center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center><b>Discount</b><br/>{{ $ticket['discount'] }}%</center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center><b>Amount</b><br/>{{ $ticket['amount'] }}</center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center><b>Vehicle Type</b><br/>{{ $ticket['vehicle_type'] ?? 'N/A' }}</center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center><b>Plate No</b><br/>{{ $ticket['plate_number'] ?? 'N/A' }}</center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center><b>Passenger's Copy</b></center>
                </td>
            </tr>
            </tbody>
        </table>
        <br/>

    </center>
@endforeach

<center>    
    <div class="button-container">
        <div class="left-button">
            <button id="downloadButton" class="btn btn-primary download-hide" onclick="downloadPageAsPDF()" style="width: 100%">Print/Download Ticket</button>
        </div>
        <div class="right-button">
            <button id="returnhome" class="btn btn-primary return-hide" style="width: 100%" onclick="window.location.href = 'https://fastcat-book.com/teller';">Return to Home</button>
        </div>
    </div>
</center>
<script>
function redirectToExternalPage() {
    // Communicate with the Android app to open the browser
    Android.openExternalPage("https://www.google.com");
}
</script>
<script type="text/javascript">
    document.body.addEventListener('click', function() {
        var button = document.getElementById('downloadButton');
        var button2 = document.getElementById('returnhome');
        button.style.display = 'block';
        button2.style.display = 'block';
    });
    function downloadPageAsPDF() {
        
        // Hide the buttons immediately when clicked
        const downloadButton = document.getElementById('downloadButton');
        downloadButton.classList.add('hidden');
        const returnhome = document.getElementById('returnhome');
        returnhome.classList.add('hidden');
        
        if (window.AndroidPrint) {
        window.AndroidPrint.printWebView("My Print Job");
            function showButtons() {
                document.getElementById('downloadButton').style.display = 'block';
                document.getElementById('returnhome').style.display = 'block';
            }
        } else {
            console.error("AndroidPrint interface is not available.");
        }
    }
    

    
</script>
</body>
</html>
