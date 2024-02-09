
<?php
require "config.php";


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title><?php echo $lang['home']; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> -->
  <link rel="stylesheet" type="text/css" href="css/style1.css">
  <link rel="stylesheet" type="text/css" href="css/footerstyle.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
  
  
  
  <style>

        /* .a {
            background-color: #8C4040;

        } */
      .e{
      
     background-color: #8C4040;

      
      }
        .s {
            background-color: #D0C7C7;
            border-radius: 10px;

        }
        /* .btn {
            background-color: #8C4040;
            border-radius: 30px;
            color: white;
            box-shadow: #D0C7C7 1px 2px 3px ;
        }
        .btn:hover{
          color: #8C4040;
          background-color: #ffffff;
          
        } */
        .form-control {
  border: none;
  padding: 0;
  background:white;
}

input.form-control {
  display: block;
  padding: 3px 4px 3px 40px;
  background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E") no-repeat 13px center;
}
    </style> 
  <!-- Bootstrap Stylesheet -->
</head>

<body>

<?php require("header.php"); ?>

<div class="container-lg my-5">
  <div class="row gy-3"> 
    <div class="col-sm-12 col-md-8 col-lg-8">
      <div class="d-flex flex-column flex-md-row">
        <div class="flex-grow-1">
          <input type="text" id="live_search" class="form-control" placeholder="<?php echo $lang['search_by']; ?>">
        </div>
        <button id="searchButton" class="btn btn-grey"><?php echo $lang['search']; ?></button>

        <div class="mt-3 mt-md-0 mx-md-3">
          <form>
            <div class="d-flex flex-wrap">
              <div class="form-group mr-md-3">
                <!-- <label for="filter">Select a filter:</label> -->
                <select id="filter" name="filter" class="form-control">
                  <option value="all"><?php echo $lang['all']; ?></option>
                  <option value="Boutique"><?php echo $lang['boutique']; ?></option>
                  <option value="Cosmotics"><?php echo $lang['cosmotics']; ?></option>
                  <option value="Furniture"><?php echo $lang['furniture']; ?></option>
                </select>
              </div>
              <button type="submit" class="btn e"><?php echo $lang['filter']; ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-4">
      <div class="d-none d-md-block">
      </div>
    </div>
  </div>
</div>




<?php 

?>
<div id = "search_result"></div>
<?php
require "Connection.php";
if (isset($_GET['filter'])) {
  $filter = $_GET['filter'];
} else {
  $filter = "all";
}

// construct the SQL query
if ($filter == "all") {
  $sql1 = "SELECT * FROM shop";
} else {
  $sql1 = "SELECT * FROM shop WHERE shop_category='$filter'";
}


// $sql1 = "SELECT * FROM shop";
$query1 = mysqli_query($conn, $sql1);
$result1 = array(mysqli_fetch_array($query1));


$data = array();
$data = [
$result1[0]
];
while ($row = mysqli_fetch_assoc($query1)) {
    $data[] = $row;
}

// define an array of images and their corresponding titles
$images = array(
    array("src" => "shop_images/s-1.jpg", "title" => "Image 1"),
    array("src" => "shop_images/s-2.jpg", "title" => "Image 2"),
    array("src" => "shop_images/s-3.jpg", "title" => "Image 3"),
    array("src" => "shop_images/s-4.jpg", "title" => "Image 4"),
    array("src" => "shop_images/s-5.jpg", "title" => "Image 5"),
    array("src" => "shop_images/s-6.jpg", "title" => "Image 6"),

);

// determine how many columns to display per row
$columns_per_row = 3;

// loop through the images and generate the cards
for ($i = 0; $i < count($data); $i++) {
  // if this is the first column in a new row, create the row
  if ($i % $columns_per_row == 0) {
      echo "<div class='row gy-3 mb-5 mdd-5'>";
  }
  
  // create the card with the image
  echo "<div class='col-sm-4 col-lg-4' onclick=\"location.href='detailed_page.php?shop_id={$data[$i]['shop_id']}&shop_category={$data[$i]['shop_category']}'\">";
  echo "<div class='card'>";
  echo "<img class='card-img-top' src='shop_images2/".$data[$i]["shop_image"]."' alt='' style='height: 300px;'>";
  echo "<div class='card-body'>";
  echo "<h5 class='card-title'>" . $data[$i]["shop_name"] . "</h5>";
  echo "<p class='card-text'>" . $lang['category_of_shop'] . " : " . $lang[$data[$i]["shop_category"]] . "</p>";
  echo "<p class='text-center'><a href='detailed_page.php?shop_id={$data[$i]['shop_id']}&shop_category={$data[$i]['shop_category']}' class='btn btn-success' style='background-color: #8C4040;'>".$lang['see_shop']."</a></p>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  
  // if this is the last column in the row, close the row
  if (($i + 1) % $columns_per_row == 0 || $i == count($data) - 1) {
      echo "</div>";
  }
}
?>

















  <!-- Modal -->
  <div class="modal fade" id="gallery-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- <div class="modal-body">
          <img src="" class="modal-img" alt="modal img" >
        </div> -->
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type = "text/javascript">
$(document).ready(function(){
  $("#live_search").keyup(function(){
    var input = $(this).val();
    if(input != ""){
      $.ajax({
        url:"livesearch.php",
        method: "POST",
        data: {input:input},
        success: function(data) {
          $("#search_result").html(data);
          // show the search results div
          $("#search_result").css("display","block");
        }
      });
    } else {
      // clear the search results div and hide it
      $("#search_result").html("");
      $("#search_result").css("display","none");
    }
  });
});
  </script>


<script>
$(document).ready(function() {
  $('#category').change(function() {
    var category = $(this).val();
    $.ajax({
      url: 'fetch_data.php',
      type: 'POST',
      data: {category: category},
      success: function(data) {
        $('#results').html(data);
      }
    }); 
  });
});

</script>

<script>
    document.getElementById("searchButton").addEventListener("click", function() {
        var input = document.getElementById("live_search").value; // Get the search input value
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "search.php", true); // Replace "search.php" with the path to your PHP file containing the live search logic
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("search_result").innerHTML = xhr.responseText; // Update the search results container with the response from the server
          }
        };
        xhr.send("input=" + input); // Send the search input value to the server
    });
</script>

</body>
<?php include 'footerr.php' ?>

</html>