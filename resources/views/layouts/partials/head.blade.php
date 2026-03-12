<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113600300-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'UA-113600300-1');
</script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4YSNM6JHV9"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'G-4YSNM6JHV9');
</script>

<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="Villa Fabulosa Temecula Wine Country">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Villa Fabulosa')</title>
<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/fancybox/jquery.fancybox.min.css') }}">

<!-- Favicons -->
<link rel="icon" href="{{ asset('frontend/imgs/favicon.png') }}">

{{-- Tawk.to live chat (commented out by default) --}}
{{--
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5a353083bbdfe97b137fbe1a/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
--}}
