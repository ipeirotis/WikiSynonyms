<div class="hero-unit">
    <h1>An Error has Occured</h1>
    <p>
        <strong>Code:</strong><?php echo $exception->getCode(); ?>
    </p>
    <p>
        <strong>Message:</strong>
        <?php echo $exception->getMessage(); ?>
    </p>
    <p><strong>Exception:</strong><?php echo $exception; ?></p>
</div>
