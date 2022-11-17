<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Us</title>
</head>
<body>
    <h3>Ticket Details:</h3>
    <ul>                        
        <li><b>Reference Number: </b><span>{{$ticket_sale->reference_number}}</span></li>
        <li><b>Date: </b><span>{{$ticket_sale->date}}</span></li>
        <li><b>Time Slot: </b><span>{{$ticket_sale->time_slot}}</span></li>
        <li><b>Room Name: </b><span>{{$ticket_sale->room_name}}</span></li>                            
    </ul>
    <p>Present this QR Code as your electronic-ticket</p>    
    {!! QrCode::size(300)->generate(URL::to('/') . '/e-ticket/' . $ticket_sale->reference_number); !!}        
</body>
</html>