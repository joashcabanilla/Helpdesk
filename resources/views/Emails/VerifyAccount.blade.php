<!DOCTYPE html>
<html>
<style>
h3,p{
    font-family: Arial;
}
p{
    font-size: 1rem !important;
}
</style>
<head>
    <title>Verify Your Email Address</title>
</head>
<body>
    <div class="card w-50 m-3 p-3 d-flex flex-column jutify-content-center align-items-center">
        <div class="d-flex flex-row flex-nowrap justify-content-start align-items-center mb-3">
            <h3 class="m-2">{{ config('app.name', 'Laravel') }}</h3>
        </div>
        <p>Welcome to {{ config('app.name', 'Laravel') }}!</p>
        <p>Please use the OTP below to verify your account:</p>
        <h3 class="fw-bolder">{{isset($code) ? $code : ""}}</h3>
    </div>
</body>
</html>