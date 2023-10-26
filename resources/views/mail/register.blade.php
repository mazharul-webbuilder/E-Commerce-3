<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<p>{!! $data['body'] !!}</p>

<p>Please Login your account by using this link:</p>
<p>For Merchant: {{route('merchant.login.show')}}</p>
<p>For Reseller: {{route('seller.login.show')}}</p>
<p>For Affiliator: {{route('affiliate.login.show')}}</p>

<p>Thank you,</p>
<p>Please stay with Netel Mart</p>
</body>
</html>


