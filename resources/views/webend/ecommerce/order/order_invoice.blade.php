
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="style.css">

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap");

        :root {
            font-size: 1.125rem; /* 18px */
            line-height: 1.75rem; /* 28px */
            font-weight: 400;
            --text-primary: 1.125rem;
        }

        body {
            width: 100%;
            height: 100%;
            font-family: "Roboto", sans-serif;
            padding: 0;
            margin: 0;
            background-color: #fff;
            color: #333333;
            -webkit-print-color-adjust: exact !important;
            letter-spacing: -0.02em;
        }


        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        ul,
        li {
            margin: 0;
            padding: 0;
        }

        ul li {
            list-style: none;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            margin: 0;
            padding: 0;
            font-size: var(--text-primary);
            font-weight: 400;
        }

        table, th, td {
            /* border: 1px solid transparent; */
            border-collapse: collapse;
            text-align: left;
            /* border: 1px solid #e3e3e3; */
            padding: 0.5rem;
        }


        /* info */

        .info p {
            font-size: 18px;
            line-height: 1.4em;
        }
        .printButton{
            background: blue;color: white; padding: 11px; margin: 0 auto; border: navajowhite;border-radius: 4px; font-size: 15px;font-weight: 600;
        }

    </style>
</head>
<body>
<div style="width: 130px;margin: 20px auto"><button class="printButton" onclick="print_invoice()">Print Invoice</button></div>
<div class="p-4" id="print_area">

    <table style="width: 297mm; padding: 2rem; margin: 2rem  auto; padding: 15px">
        <thead style="border-bottom: 1px solid #e3e3e3">
        <tr>
            <th colspan="5">
                <div style="display: flex; justify-content: space-between; gap: 2rem; align-items: center;">
                    <div style="display: flex; gap: 2rem; align-items: center; max-width: 40rem;">
                        <img  style="height: 4rem;" src="{{asset('webend/logo.png')}}" alt="dsd">
                        <address style="line-height: 1.5em; font-weight: 400;">
                            <p> Ludo.game.com, 23/3, Shymoli, Dhaka-1000</p>
                            <p>Phone: +880 123 456 7897, Email: admin@ludogame.com</p>
                        </address>
                    </div>
                    <div style="font-weight: 400; padding: 0.5rem;">
                        Invoice ID <span style="font-weight: 600;">#123456789</span>
                    </div>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="5" style="padding: 1rem 0;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">
                    <div class="info" style=" flex: 1 100%;">
                        <h2 style="font-weight: 600;">Order Info</h2>
                        <p>Order Id: <span style="font-weight: 600;">#{{$order->order_number}}</span></p>
                        <p>Placed:  {{date('d F Y, h:i A')}}</p>
                        <p>Payment Method: {{$order->payment->payment_name ?? ''}}</p>
                        <p>Total Product: {{$order->quantity}}</p>
                    </div>
                    <div style=" flex: 1 100%; align-self: center; display: flex; justify-content: center; align-items: center;">
                        <img style="height: 7rem;" src="{{asset('webend/barcode.png')}}" alt="barcode.png">
                    </div>
                    <div class="info" style=" flex: 1 100%;">
                        <h2 style="font-weight: 600;">Customer Info</h2>
                        <p>Name: <span style="font-weight: 600;">{{$order->billing ? $order->billing->name : ""}}</span></p>
                        <p>Address: {{$order->billing ? $order->billing->address : ""}}</p>
                        <p>Phone: {{$order->billing ? $order->billing->phone : ""}}</p>
{{--                        @if(!empty($order->billing)  && $order->billing->email !=null)--}}
                            <p>Email: <span style="font-weight: 600;">{{$order->billing ? $order->billing->email : ""}}</span></p>
{{--                        @endif--}}

                    </div>
                </div>
            </td>
        </tr>
        <tr style="background-color: #e3e3e3;">
            <th>SL</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total Price</th>
        </tr>
        <!-- Product -->
        @foreach($order->order_detail as $item)
            <tr style="border: 1px solid #e3e3e3;">
                <td>{{$loop->iteration}}</td>
                <td style="width: 50%">{{$item->product->title}}</td>
                <td style="font-weight: 500;">{{$item->product_quantity}}</td>
                <td style="font-weight: 500;">{{price_format($item->product->current_price)}}</td>
                <td style="font-weight: 500;">{{price_format($item->product->current_price*$item->product_quantity)}}</td>
            </tr>
        @endforeach

        <!-- Total Sum-->
        <tr>
            <td style="border-right: 1px solid #e3e3e3;" rowspan="5" colspan="2"></td>
        </tr>
        <tr style="border-right: 1px solid #e3e3e3; border-bottom: 1px solid #e3e3e3; font-weight: 500;">
            <td colspan="2">Subtotal</td>
            <td colspan="1">{{price_format($order->sub_total)}}</td>
        </tr>
        <tr style="border-right: 1px solid #e3e3e3; border-bottom: 1px solid #e3e3e3; font-weight: 500;">
            <td colspan="2">VAT</td>
            <td colspan="1">{{price_format($order->tax)}}</td>
        </tr>
        <tr style="border-right: 1px solid #e3e3e3; border-bottom: 1px solid #e3e3e3; font-weight: 500; background-color: #f3f3f3;">
            <td colspan="2">Total</td>
            <td colspan="1">{{price_format($order->shipping_charge)}}</td>
        </tr>
        <tr style="border-right: 1px solid #e3e3e3; background-color: #e0e0e0; font-weight: 500;">
            <td style="border-bottom: 1px solid #e3e3e3" colspan="2">Total Payable</td>
            <td style="border-bottom: 1px solid #e3e3e3" colspan="1">{{price_format($order->grand_total)}}</td>
        </tr>
        </tbody>
    </table>
</div>


<script !src="">
    function print_invoice(){
        var printContents = document.getElementById("print_area").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
</body>
</html>




