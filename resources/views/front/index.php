<?php ob_start(); ?>
    <ul>
        <?php foreach ($products as $product): ?>
            <li><h2><a href="<?php echo url('product', $product->id); ?>"><?php echo $product->title; ?></a></h2>

            <?php if($image->productImage($product->id)): ?>
                <img src="<?php echo url('uploads', $image->productImage($product->id)->uri); ?>">
            <?php endif; ?>

            <?php if($tags = $tag->productTags($product->id)) : ?>
            <?php foreach($tags as $t): ?>
                <p><?php echo $t->name; ?></p></li>
            <?php endforeach; ?>
            <?php endif; ?>

        <?php endforeach ?>
    </ul>
<?php $content = ob_get_clean();

include __DIR__ . '/../layouts/master.php';