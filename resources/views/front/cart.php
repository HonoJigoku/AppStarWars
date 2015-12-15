<?php $title = 'Panier'; ?>
<?php ob_start() ?>
    <section class="content">
        <?php foreach ($products as $name => $p): ?>
            <h1>
                <?php echo $name ?>
            </h1>
            <img src="<?php echo url('uploads', $image->find($p['product_id'])->uri); ?>">
            <p> quantity: <?php echo $p['quantity'] ?>, total
                : <?php echo $p['total'] ?></p>
            <a href="<?php echo url('restore', $p['product_id']); ?>">restore</a>
        <?php endforeach; ?>
    </section>

<form action="<?php echo url('store'); ?>">
    <input type="email" name="email" value="<?php echo (!empty($_SESSION['old']['email']))? '<small>'.$_SESSION['old']['email'].'</small>': '' ;?>">
    <?php echo (!empty($_SESSION['error']['email'])) ? '<small>'.$_SESSION['error']['email'].'</small>':''; ?>
    <input type="number" name="number" value="<?php echo (!empty($_SESSION['old']['number']))?'<small>'.$_SESSION['old']['number'].'</small>': '' ;?>">
    <?php echo (!empty($_SESSION['error']['number'])) ? '<small>'.$_SESSION['error']['number'].'</small>':''; ?>
    <textarea name="address"></textarea>
    <input type="submit" value="Payer">
</form>
<?php $content = ob_get_clean() ?>
<?php include __DIR__ . '/../layouts/master.php' ?>