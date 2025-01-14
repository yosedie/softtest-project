<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{__('Laravel Generate QR Code Examples')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
    <div class="container-xl mt-4">
        <div class="card">
            <div class="card-header">
                <h2>{{__('Simple QR Code')}}</h2>
            </div>
            <div class="card-body">
                
                <?php 
                    $path= url('/register') . '/?ref=' . Auth::user()->affiliate_id;
                ?>

                {!! QrCode::size(300)->generate($path) !!}
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h2>{{__('Color QR Code')}}</h2>
            </div>
            <div class="card-body">
                {!! QrCode::size(300)->backgroundColor(255,90,0)->generate('http://localhost/eclass_4.6/public/register/?ref=G$2EWVVR') !!}
            </div>
        </div>
    </div>
</body>
</html>
