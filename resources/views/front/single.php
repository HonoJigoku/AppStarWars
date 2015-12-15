<?php ob_start(); ?>
    <h1><?php echo $product->title; ?></h1>

    <ul>
        <?php if($image->productImage($product->id)): ?>
            <img src="<?php echo url('uploads', $image->productImage($product->id)->uri); ?>">
        <?php endif; ?>

        <?php if($tags = $tag->productTags($product->id)) : ?>
            <?php foreach($tags as $t): ?>
                <p><?php echo $t->name; ?></p></li>
            <?php endforeach; ?>
            <?php endif; ?>
    </ul>

    <form action="<?php echo url('command') ?>" method="post">
        <input type="hidden" name="price" value="<?php echo $product->price; ?>">
        <input type="hidden" name="name" value="<?php echo $product->id; ?>">
        <select name="quantity">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
        </select>
        <input type="submit" value="Buy">
    </form>
<?php $content = ob_get_clean();

include __DIR__ . '/../layouts/master.php';