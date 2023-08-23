<head>
        <meta charset="utf-8" />
        <title>Admin - {{$title ?? 'Dashboard'}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Pichforest" name="author" />
        <link rel="shortcut icon" href="{{asset('backend')}}/assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="{{asset('backend')}}/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('backend')}}/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('backend')}}/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Dark Mode Css-->
        <link href="{{asset('backend')}}/css/dark-layout.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{asset('backend/css/quicksand.css')}}">

        @stack('custom_styles')
</head>