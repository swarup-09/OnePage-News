<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>OnePage News</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page " style="background-color: #F8F8FF;">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">

        <h1 class="sitename">OnePage News</h1>
      </a>

      
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><div>
            <form class="search-form d-flex align-items-center" method="GET" action="">
              <input type="text" name="query" placeholder="Enter Search keyword" title="Enter search keyword" required>
              <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
          </div>
          </li>
        </ul><i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>



    </div>
  </header>
  <section id="hero" class="hero section">

    <img src="assets/img/hero-bg-abstract.jpg" alt="" data-aos="fade-in" class="">

    <div class="container">
      <div class="row justify-content-center" data-aos="zoom-out">
        <div class="col-xl-7 col-lg-9 text-center">
          <h1>One Page Bootstrap Website Template</h1>
          <p>We are team of talented designers making websites with Bootstrap</p>
        </div>
      </div>
      <div class="text-center" data-aos="zoom-out" data-aos-delay="100">
        <a href="#about" class="btn-get-started">Get Started</a>
      </div>
    </div>
  </section>
  <main class="main">


    <!-- News & Updates Section -->
    <section class="section dashboard container " data-aos="fade-up" style="background-color: #F8F8FF;">
      <?php

      $apiKey = '9e070c4a7a9c4be6a81762010d30cb66';
      $endpoint = 'https://newsapi.org/v2/everything';

      $currentYear = date('Y');
      $currentMonth = date('m');

      $fromDate = date("Y-m-d", strtotime("$currentYear-$currentMonth-01")); // First day of the month
      $toDate = date("Y-m-t", strtotime("$currentYear-$currentMonth")); // Last day of the month
      
      // search query and other parameters
      $query = isset($_GET['query']) ? $_GET['query'] : 'programming language';
      ;
      $language = 'en';

      //  API request URL
      $requestUrl = "$endpoint?q=" . urlencode($query) .

        "&language=$language" .
        "&from=$fromDate" .
        "&to=$toDate" .
        "&apiKey=$apiKey";

      // Initialize cURL session
      $curl = curl_init($requestUrl);

      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'User-Agent: TechSeedDashboard'
      ]);
      $response = curl_exec($curl);
      curl_close($curl);

      // Decode API response
      $apiResult = json_decode($response, true);
      // Check if there is an error in the API response
      if (isset($apiResult['status']) && $apiResult['status'] === 'error') {
        $errorMessage = $apiResult['message'] ?? 'Unknown error';
        $errorcode = $apiResult['code'] ?? 'Unknown Code';

        // Display user-friendly error message
        echo "<div class='alert alert-danger' role='alert'>";
        echo "An error occurred while fetching news articles: " . htmlspecialchars($errorMessage);
        echo "</div> ";

        // Log error details to console
        echo "<script>console.error('API Error Code: " . addslashes($errorcode) . "');</script>";
        echo "<script>console.error('API Error: " . addslashes($errorMessage) . "');</script>";
      }

      ?>
      <div class="card" style="background-color: ;">
        <div class="card-body pb-0">


          <div class="news">
            <?php
            // Check if the response contains articles
            if (isset($apiResult['articles']) && is_array($apiResult['articles'])) {
              // Loop through the articles and generate HTML for each one
              foreach ($apiResult['articles'] as $article) {
                $title = $article['title'] ?? 'No Title';
                $description = $article['description'] ?? 'No Description';
                $url = $article['url'] ?? '#';
                $imageUrl = $article['urlToImage'] ?? 'assets/img/news-5.jpg'; // Use a default image if none is provided
                $publishedAt = date('F j, Y', strtotime($article['publishedAt'])); // Format the date
            
                echo '
                <div class="post-item clearfix" data-aos="fade-up-right">
                  <p><small>' . htmlspecialchars($publishedAt) . '</small></p>
                  <img src="' . htmlspecialchars($imageUrl) . '" alt="' . htmlspecialchars($title) . '">
                  <h4><a href="' . htmlspecialchars($url) . '" target="_blank">' . htmlspecialchars($title) . '</a></h4>
                  <p>' . htmlspecialchars($description) . '</p>
                  <br>
                </div>';
              }
            } else {
              echo '<p>No news articles available at the moment.</p>';
            }
            ?>
          </div><!-- End sidebar recent posts -->

        </div>
      </div><!-- End News & Updates -->
    </section>


  </main>

  <footer id="footer" class="footer light-background">

    <div class="container footer-top">

    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">OnePage News</strong> <span>All Rights Reserved</span>
      </p>
      <div class="credits">
        Designed by <a href="https://github.com/swarup-09">swarup-09</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>