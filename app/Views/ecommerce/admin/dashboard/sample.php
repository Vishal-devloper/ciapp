<!DOCTYPE html>
<html>
<head>
    <title>Products List</title>
</head>
<body>
    <h1>Product List</h1>

    <?php if (!empty($products) && is_array($products)): ?>
        <table border="1" cellpadding="5">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
            </tr>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= esc($product['id']) ?></td>
                    <td><?= esc($product['name']) ?></td>
                    <td><?= esc($product['phone']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</body>
</html>
