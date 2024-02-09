<?php
require "Connection.php";
require "config.php";

if (isset($_POST['input'])) {
    $input = $_POST['input'];
    $shopQuery = "
        SELECT
            shop.shop_id,
            shop.shop_name,
            shop.shop_category,
            shop.shop_image
        FROM
            shop
        WHERE
            shop.shop_name LIKE '%{$input}%'
        ORDER BY
            shop.shop_name;
    ";
    $productQuery = "
        SELECT
            shop.shop_id,
            shop.shop_name,
            shop.shop_category,
            shop.shop_image,
            product.produt_name,
            product.product_image,
            product.product_price,
            product.product_id
        FROM
            shop
            LEFT JOIN product ON shop.shop_id = product.shop_id
        WHERE
            (shop.shop_category LIKE '%{$input}%'
            OR product.produt_name LIKE '%{$input}%'
            OR product.product_category LIKE '%{$input}%')
        ORDER BY
            product.product_price ASC;
    ";
    $shopResult = mysqli_query($conn, $shopQuery);
    $productResult = mysqli_query($conn, $productQuery);
    
    $foundShops = array();
    if (mysqli_num_rows($shopResult) > 0) {
        while ($row = mysqli_fetch_assoc($shopResult)) {
            $shopId = $row['shop_id'];
            $shopName = $row['shop_name'];
            $category = $row['shop_category'];
            $shopImage = $row['shop_image'];

            $foundShops[$shopId] = array(
                'shopName' => $shopName,
                'category' => $category,
                'shopImage' => $shopImage,
                'products' => array()
            );
        }
    }
    
    $foundProducts = array();
    if (mysqli_num_rows($productResult) > 0) {
        while ($row = mysqli_fetch_assoc($productResult)) {
            $shopId = $row['shop_id'];
            $shopName = $row['shop_name'];
            $category = $row['shop_category'];
            $shopImage = $row['shop_image'];
            $productName = $row['produt_name'];
            $productImage = $row['product_image'];
            $productPrice = $row['product_price'];
            $productId = $row['product_id'];

            if (!isset($foundProducts[$shopId])) {
                $foundProducts[$shopId] = array(
                    'shopName' => $shopName,
                    'category' => $category,
                    'shopImage' => $shopImage,
                    'products' => array()
                );
            }

            if ($productName !== null) {
                $foundProducts[$shopId]['products'][] = array(
                    'productName' => $productName,
                    'productImage' => $productImage,
                    'productPrice' => $productPrice,
                    'productId' => $productId
                );
            }
        }
    }

    if (!empty($foundShops)) {
        foreach ($foundShops as $shopId => $shop) {
            $shopName = $shop['shopName'];
            $category = $shop['category'];
            $shopImage = $shop['shopImage'];

            ?>
            <div class='row gy-3 mb-5 mdd-5'>
                <div class='col-sm-3 col-md-4 col-lg-4'>
                    <div class='card'>
                        <img class='card-img-top' src='shop_images2/<?php echo $shopImage ?>' alt='' style='height: 300px;'>
                        <div class='card-body'>
                            <h5 class='card-title'><?php echo $shopName; ?></h5>
                            <p class='card-text'><?php echo $lang['category_of_shop']; ?> :- <?php echo $lang[$category]; ?></p>
                            <p class='text-center'><a href='detailed_page.php?shop_id=<?php echo $shopId ?>&shop_category=<?php echo $category ?>' class='btn btn-success'><?php echo $lang['see_shop'] ?></a></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } elseif (!empty($foundProducts)) {
        foreach ($foundProducts as $shopId => $shop) {
            $shopName = $shop['shopName'];
            $category = $shop['category'];
            $shopImage = $shop['shopImage'];
            $products = $shop['products'];

            foreach ($products as $product) {
                $productName = $product['productName'];
                $productImage = $product['productImage'];
                $productPrice = $product['productPrice'];
                $productId = $product['productId'];

                ?>
                <div class='row gy-3 mb-5'>
                <div class='col-sm-3 col-md-4 col-lg-4'>
                    <div class='card'>
                        <img class='card-img-top' src='products_image/<?php echo $productImage ?>' alt='' style='height: 300px;'>
                        <div class='card-body'>
                            <h5 class='card-title'><?php echo $productName; ?></h5>
                            <p class='card-text'><?php echo $lang['price']; ?> : <?php echo $productPrice ; ?> <?php echo   $lang['etb']; ?></p>
                            <p class='text-center'><a href='detailed_product.php?shop_id=<?php echo $shopId ?>&product_id=<?php echo $productId ?>' class='btn btn-success'><?php echo $lang['see_product'] ?></a></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    } else {
        echo "<h6>Not Found</h6>";
    }
}
?>