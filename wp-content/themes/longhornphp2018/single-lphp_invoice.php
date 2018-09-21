<?php
get_header();

$publicKey = ($_GET['testMode'] ?? false) ? get_field('stripe_public_key_test', 'options') : get_field('stripe_public_key', 'options');
$invoice_name = get_field('invoice_name');
$invoice_description = get_field('invoice_description');
$charge = get_field('price');

if (get_field('include_stripe_fee')) {
    $charge = round(($charge + .3) / 0.971, 2) * 100;
} else {
    $charge = (int)$charge * 100;
}

if (count($_POST)):
    $token = $_POST['stripeToken'];
    $email = $_POST['stripeEmail'];

    $secretKey = ($_GET['testMode'] ?? false) ? get_field('stripe_secret_key_test', 'options') : get_field('stripe_secret_key', 'options');

    if ($token && $email && $secretKey) {
        $ch = curl_init('https://api.stripe.com/v1/charges');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => $secretKey . ':',
            CURLOPT_HTTPHEADER => ['Content-type: application/x-www-form-urlencoded'],
            CURLOPT_POSTFIELDS => http_build_query([
                'amount' => $charge,
                'currency' => 'usd',
                'description' => $invoice_description,
                'source' => $token,
                'receipt_email' => $email
            ])
        ]);
        $res = curl_exec($ch);
        $message = curl_getinfo($ch)['http_code'] === 200 ? 'Payment processed successfully!' : 'Payment failed: ' . json_decode($res)->error->message;
    }
endif;

?>

<div class="container">
    <div class="row">
        <main class="site-main col-sm-9 mx-sm-auto">
            <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php if ( !post_password_required() ) : ?>
                        <header>
                            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        </header>
                        <div class="entry-content">
                            <?php the_content(); ?>
                            <?php if (isset($message)) : ?>
                                <p><?php echo $message; ?></p>
                            <?php else : ?>
                                <form method="POST">
                                  <script
                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="<?php echo $publicKey; ?>"
                                    data-amount="<?php echo $charge; ?>"
                                    data-name="<?php echo $invoice_name; ?>"
                                    data-description="<?php echo $invoice_description; ?>"
                                    data-locale="auto"
                                    data-zip-code="true">
                                  </script>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>
                        <?php echo get_the_password_form(); ?>
                    <?php endif; ?>
                </article>

            <?php endwhile; ?>
        </main>
    </div>
</div>

<?php
get_footer();
