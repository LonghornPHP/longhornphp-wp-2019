<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-touch-icon.png?v=juPH7Puthev2">
<link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png?v=juPH7Puthev2">
<link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png?v=juPH7Puthev2">
<link rel="manifest" href="/icons/manifest.json?v=juPH7Puthev2">
<link rel="mask-icon" href="/icons/safari-pinned-tab.svg?v=juPH7Puthev2" color="#00266a">
<link rel="shortcut icon" href="/icons/favicon.ico?v=juPH7Puthev2">
<meta name="msapplication-config" content="/icons/browserconfig.xml?v=juPH7Puthev2">
<meta name="theme-color" content="#ffffff">

<!-- deploy test -->

<script>
    dataLayer = [{
        'user_is_logged_in': '<?php echo is_user_logged_in() ? 'true' : 'false'; ?>'
    }];
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-N35VHB3');</script>
<!-- End Google Tag Manager -->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N35VHB3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<noscript id="deferred-styles">
    <link rel="stylesheet" type="text/css" href="https://css.tito.io/v1.1"/>
    <link rel="stylesheet" type="text/css" href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css"/>
</noscript>