<?php
  require "class/Database.php";
  require "class/Product.php";
  require "inc/init.php";
  $conn =  new Database();
  $pdo = $conn->getConnect();
  $data = Product::getAll($pdo);
  if(empty($_GET["page"]))
        $page = 1;
    else 
        $page = $_GET["page"];
    $ppp = 3; //3 san pham tren 1 trang
    $limit = $ppp;
    $offset = ($page - 1) * $ppp;
    $data = Product::pagination($pdo, $limit, $offset);
    $countProduct = Product::countProduct($pdo);
    $maxPage = ceil($countProduct / $ppp);
?>
<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <!-- <link rel="shortcut icon" href="images/favicon.png" type=""> -->

  <title> LeVietTuanKhai_DA_Fastfood </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" />
  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
  <style>
        .btn-custom svg {
            width: 15px;
            height: 15px;
            vertical-align: middle;
            margin-right: 5px;
        }
    </style>

</head>
</html>
<?php
    require_once "inc/header.php";
?>

  </div>
  <!-- food section -->
 <section class="food_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Our Menu
        </h2>
      </div>

      <div class="filters-content">
        <div class="row grid">
            <?php foreach($data as $product): ?>
              <div class="col-sm-6 col-lg-4 all pizza"> 
                <div class="box">
                      <div class="img-box">
                          <img src="images/<?= $product->image?>" alt="<?= $product->name ?>">
                      </div>
                    <div class="detail-box">
                        <h5>
                          <a href="product.php?id=<?=$product->id?>"><?=$product->name?></a>
                        </h5>
                      <p>
                        <?= $product->description?>
                      </p>
                      <div class="options">
                        <h6>
                          <?= number_format($product->price, 0, ',', '.')?> VNĐ
                        </h6>
                        <form method="post">
                            <input type="hidden" name="proid" value="<?=$product->id; ?>">
                            <input type="hidden" name="status" value="0">
                            <button type="submit" class="btn btn-primary btn-custom">
                              <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 456.029 456.029" style="enable-background:new 0 0 456.029 456.029;" xml:space="preserve">
                            <g>
                              <g>
                                <path d="M345.6,338.862c-29.184,0-53.248,23.552-53.248,53.248c0,29.184,23.552,53.248,53.248,53.248
                            c29.184,0,53.248-23.552,53.248-53.248C398.336,362.926,374.784,338.862,345.6,338.862z" />
                              </g>
                            </g>
                            <g>
                              <g>
                                <path d="M439.296,84.91c-1.024,0-2.56-0.512-4.096-0.512H112.64l-5.12-34.304C104.448,27.566,84.992,10.67,61.952,10.67H20.48
                            C9.216,10.67,0,19.886,0,31.15c0,11.264,9.216,20.48,20.48,20.48h41.472c2.56,0,4.608,2.048,5.12,4.608l31.744,216.064
                            c4.096,27.136,27.648,47.616,55.296,47.616h212.992c26.624,0,49.664-18.944,55.296-45.056l33.28-166.4
                            C457.728,97.71,450.56,86.958,439.296,84.91z" />
                              </g>
                            </g>
                            <g>
                              <g>
                                <path d="M215.04,389.55c-1.024-28.16-24.576-50.688-52.736-50.688c-29.696,1.536-52.224,26.112-51.2,55.296
                            c1.024,28.16,24.064,50.688,52.224,50.688h1.024C193.536,443.31,216.576,418.734,215.04,389.55z" />
                              </g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                          </svg></button>
                      
                          <!-- </a> -->
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            <?php endforeach; ?>
        </div>
      </div>     
  </section>
  <?php
    // Xác định trang trước và trang tiếp theo
    $previousPage = ($page > 1) ? $page - 1 : 1;
    $nextPage = $page + 1;
    // Xác định liệu có phải trang đầu tiên hay cuối cùng không
    $isFirstPage = ($page == 1) ? true : false;
    $isLastPage = ($page == $maxPage) ? true : false;
  ?>
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
      <!-- Liên kết "Previous" -->
      <li class="page-item <?php echo ($isFirstPage) ? 'disabled' : ''; ?>">
        <a class="page-link" href="menu.php?page=<?php echo $previousPage; ?>" tabindex="-1">Previous</a>
      </li>
      <?php for ($p = 1; $p <= $maxPage; $p++) {
        echo "<li class='page-item'><a class='page-link' href='menu.php?page=$p'>$p</a></li>";
      } ?>
      <!-- Liên kết "Next" -->
      <li class="page-item <?php echo ($isLastPage) ? 'disabled' : ''; ?>">
        <a class="page-link" href="menu.php?page=<?php echo $nextPage; ?>">Next</a>
      </li>
    </ul>
  </nav> 

  <!-- end food section -->

 
  <!-- footer section -->
  <?php
    require_once "inc/footer.php";
    ?>
  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- isotope js -->
  <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
  <!-- nice select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
  </script>
  <!-- End Google Map -->
</body>