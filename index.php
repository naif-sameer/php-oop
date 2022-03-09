<?php

$db_name = 'e-super';
$connection = mysqli_connect('localhost', 'root', '');

# create DB
$sql = "CREATE DATABASE IF NOT EXISTS {$db_name}";
mysqli_query($connection, $sql);
mysqli_select_db($connection, $db_name);

# create categories table
$sql = "CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255),
    `is_active` INT(1) DEFAULT 1
  )
";
mysqli_query($connection, $sql);


# create products table
$sql = "CREATE TABLE IF NOT EXISTS products (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255),
    `is_active` INT(1) DEFAULT 1,
    `image` VARCHAR(500),
    `category_id` INT
  )
";
echo mysqli_query($connection, $sql) . '<br>';

# insert fake data :)
function fake_data()
{
  global $connection;
  // categories fake data
  mysqli_query($connection, "INSERT INTO `categories` (name) VALUES ('desktop')");

  mysqli_query($connection, "INSERT INTO `categories` (name) VALUES ('mobile')");

  mysqli_query($connection, "INSERT INTO `categories` (name) VALUES ('web')");

  // products fake data
  mysqli_query(
    $connection,
    "INSERT INTO products (`name`, `image`, `category_id`) VALUES ('vscode', '1', 'a.jpg')"
  );


  mysqli_query(
    $connection,
    "INSERT INTO products (`name`, `image`, `category_id`) VALUES ('google store', '2', 'a.jpg')"
  );

  mysqli_query(
    $connection,
    "INSERT INTO `products` (`name`, `is_active`, `image`, `category_id`) VALUES ('vue.js', '1', 'vue.jpg', '1');"
  );
}

// fake_data();


// log mysqli error
echo mysqli_error($connection);


// get categories



class Categories
{

  public function get_categories()
  {
    global $connection;
    $categories = '';

    $rows = mysqli_query($connection, "SELECT * FROM `categories` WHERE is_active = 1");

    // get row data
    while ($row = mysqli_fetch_assoc($rows)) {
      $categories .= "<div class='flex flex-row p-2 rounded bg-gray-700 border border-gray-600'>
      
      <form class='inline-flex  m-0 pr-8' action='' method='post'>
        <input name='update_category_id' type='hidden' value='{$row['id']}'/>
        <input class='bg-gray-600 text-gray-200 rounded px-3 py-2' name='update_category_name' type='text' value='{$row['name']}'/>

        <button class='bg-gray-800 px-4' type='submit'>
          edit
        </button>
      </form>
      
      <form class='flex m-0' action='' method='post'>
        <input name='delete_category_id' type='hidden' value='{$row['id']}'/>

        <button class='bg-red-600 rounded px-4' type='submit'>
          delete
        </button>
      </form>
      </div>";
    }

    return $categories;
  }

  public function add_category($category_name)
  {
    global $connection;

    mysqli_query($connection, "INSERT INTO `categories` (`name`) VALUES ('$category_name')");
  }

  public function update_category($category_id, $category_name)
  {
    global $connection;

    $sql = "UPDATE `categories` SET name = '$category_name' WHERE id = $category_id";

    mysqli_query($connection, $sql);
  }

  public function delete_category($category_id)
  {
    global $connection;

    $sql = "UPDATE `categories` SET is_active = 0 WHERE id = $category_id";

    mysqli_query($connection, $sql);
  }
}

class Products
{

  public function get_products()
  {
    global $connection;
    $products = '';

    $rows = mysqli_query($connection, "SELECT * FROM `products` WHERE is_active = 1");

    // get row data
    while ($row = mysqli_fetch_assoc($rows)) {
      $products .= "<div class='flex flex-row p-2 rounded bg-gray-700 border border-gray-600'>
      
      <form class='inline-flex  m-0 pr-8' action='' method='post'>
        <input name='update_category_id' type='hidden' value='{$row['id']}'/>
        <input class='bg-gray-600 text-gray-200 rounded px-3 py-2' name='update_category_name' type='text' value='{$row['name']}'/>

        <button class='bg-gray-800 px-4' type='submit'>
          edit
        </button>
      </form>

      <div class='border border-gray-500 px-4 mr-2'>category id = {$row['category_id']}</div>
      
      <form class='flex m-0' action='' method='post'>
        <input name='delete_category_id' type='hidden' value='{$row['id']}'/>

        <button class='bg-red-600 rounded px-4' type='submit'>
          delete
        </button>
      </form>
      </div>";
    }

    return $products;
  }

  public function add_product($product_name)
  {
    global $connection;

    $sql = "INSERT INTO `products` (`name`, `image`, `category_id`) VALUES ('$product_name', 'localhost/img/jpg', '1')";


    mysqli_query($connection, $sql);
  }

  public function update_product($product_id, $product_name)
  {
    global $connection;

    $sql = "UPDATE `products` SET name = '$product_name' WHERE id = $product_id";

    mysqli_query($connection, $sql);
  }

  public function delete_product($product_id)
  {
    global $connection;

    $sql = "UPDATE `products` SET is_active = 0 WHERE id = $product_id";

    mysqli_query($connection, $sql);
  }
}

$categories = new Categories;
$products = new Products;
echo mysqli_error($connection);


/*
while ($row = mysqli_fetch_assoc($rows)) {
  $products .= '
  <div class="overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
  <div class="px-4 py-2">
    <h1 class="text-3xl font-bold text-gray-700 uppercase dark:text-white">
    ' . $row['title'] . '
    </h1>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
    ' . $row['description'] . '
    </p>
  </div>

  <img class="object-cover w-full h-48 mt-2" 
    
    src="' . $row['image'] . '"
    alt="NIKE AIR">

  <div class="flex items-center justify-between px-4 py-2 bg-gray-800">
    <h5 class="text-lg font-bold text-white">$' . $row['price'] . '</h5>

    <form action="cart.php" method="POST">
      <input type="hidden" name="id" value="' . $row['id'] . '">
      <button class="px-2 py-1 text-xs font-semibold text-gray-800 uppercase transition-colors duration-200 transform bg-white rounded hover:bg-gray-200 focus:bg-gray-400 focus:outline-none">Add to cart</button>
    </form>
  </div>
</div>
';
}
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/output.css">
  <title>products</title>
</head>

<body class="bg-gray-900 text-white p-8">


  <!-- categories -->
  <div class="border border-dashed p-4 rounded">
    <h1 class="text-3xl my-4">Categories</h1>

    <section class="p-6 mx-auto bg-white rounded-md shadow-md bg-inherit">
      <!-- add new item form -->
      <form action="" method="POST" class="flex mt-8 sm:flex-row sm:justify-center sm:-mx-2">
        <input type="text" name="category_name" class="px-4 py-2 text-gray-700 bg-white border border-r-0 rounded-md rounded-r-none  dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40" placeholder="category name...">

        <button type="submit" class="px-4 py-2 text-sm font-medium tracking-wide text-white capitalize border  transition-colors duration-200 transform rounded-md rounded-l-none dark:bg-gray-800  ">
          Add
        </button>
      </form>

      <!-- list -->
      <div class="space-y-4">
        <!-- render items -->
        <?php echo $categories->get_categories(); ?>
      </div>
    </section>
  </div>

  <!-- products -->
  <div class="border border-dashed p-4 rounded">
    <h1 class="text-3xl my-4">Products</h1>

    <section class="p-6 mx-auto bg-white rounded-md shadow-md bg-inherit">
      <!-- add new item form -->
      <form action="" method="POST" class="flex mt-8 sm:flex-row sm:justify-center sm:-mx-2">
        <input type="text" name="product_name" class="px-4 py-2 text-gray-700 bg-white border border-r-0 rounded-md rounded-r-none  dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40" placeholder="product name...">


        <button type="submit" class="px-4 py-2 text-sm font-medium tracking-wide text-white capitalize border  transition-colors duration-200 transform rounded-md rounded-l-none dark:bg-gray-800  ">
          Add
        </button>
      </form>

      <!-- list -->
      <div class="space-y-4">
        <!-- render items -->
        <?php echo $products->get_products(); ?>
      </div>
    </section>
  </div>



  <!-- reload -->
  <button id="reload" class="mt-8 px-2 py-3 bg-gray-600 text-white">
    Reload
  </button>
  <script>
    document.querySelector("#reload").onclick = () => window.location = '/'
  </script>

</body>

</html>
<?php
# categories
// add
if (isset($_POST['category_name']) && strlen($_POST['category_name']) > 1) {
  $categories->add_category($_POST['category_name']);
}

// update
if (isset($_POST['update_category_id'])) {
  $categories->update_category($_POST['update_category_id'], $_POST['update_category_name']);
}

// delete
if (isset($_POST['delete_category_id'])) {
  $categories->delete_category($_POST['delete_category_id']);
}

# product 
// add
if (isset($_POST['product_name']) && strlen($_POST['product_name']) > 1) {
  $products->add_product($_POST['product_name']);
}

// update
if (isset($_POST['update_product_name'])) {
  $products->update_product($_POST['update_product_id'], $_POST['update_product_name']);
}

// delete
if (isset($_POST['delete_product_id'])) {
  $products->delete_product($_POST['delete_product_id']);
}

?>