<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
$username = $is_logged_in ? $_SESSION['username'] : null;
$profile_picture = $is_logged_in ? ($_SESSION['picture'] ?: 'default.png') : null;

// Pastikan jalur file gambar benar
$profile_picture_path = $is_logged_in ? "/tugaspwpb/images/uploads/" . htmlspecialchars($profile_picture) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="/tugaspwpb/images/logo/AV2.png">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/script.js " defer></script>
    <title>AnimeVerse</title>

</head>
<body>


<?php include('navbar.php'); ?>



<!-- Intro -->
    <section class="intro">
        <div class="container">
            <h1>Selamat Datang di AnimeVerse</h1>
            <p>Temukan dan nikmati berbagai anime populer dari berbagai genre.</p>
        </div>
 </section> 
 <div class="search-bar">
            <form action="search.php" method="GET" style="display: flex;">
                <input type="text" id="searchInput" name="search" placeholder="Cari anime...">
                <button type="submit">Cari</button>
            </form>
            </div>
        </div>

<!-- Manga Gallery -->

<main>

<?php
include 'koneksi.php';

// Default jumlah item per halaman
$defaultItemsPerPage = 21;

// Ambil jumlah item per halaman dari request (jika ada)
$itemsPerPage = isset($_COOKIE['itemsPerPage']) ? (int)$_COOKIE['itemsPerPage'] : $defaultItemsPerPage;

// Hitung total item dan halaman
$totalItemsQuery = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM dbav");
$totalItems = mysqli_fetch_assoc($totalItemsQuery)['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

// Halaman saat ini
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages)); // Validasi halaman

// Data offset
$offset = ($currentPage - 1) * $itemsPerPage;
$data = mysqli_query($koneksi, "SELECT * FROM dbav LIMIT $offset, $itemsPerPage");

// Menampilkan data
echo '<section id="cover-anime" class="cover-anime">';
echo '<h2>Anime Populer</h2>';
echo '<div class="gallery-container">';
echo '<div class="anime-grid" id="animeGrid">';

while ($d = mysqli_fetch_assoc($data)) {
    echo '<div class="anime-card">';
    echo '<a href="preview.php?id=' . htmlspecialchars($d['ID']) . '">';
    echo '<div class="card-overlay"></div>';
    echo '<img src="../images/image/' . htmlspecialchars($d['gambar']) . '" alt="' . htmlspecialchars($d['judul']) . '">';
    echo '<h3>' . htmlspecialchars($d['judul']) . '</h3>';
    echo '<p>Genre: ' . htmlspecialchars($d['genre']) . '</p>';
    echo '<p>Episode: ' . htmlspecialchars($d['episode']) . '</p>'; 
    echo '</a>';
    echo '</div>';
}

echo '</div>';
echo '</div>';
echo '</section>';

// Menampilkan pagination
echo '<div class="pagination">';

// Tombol "min" (halaman pertama)
if ($currentPage > 2) {
    echo '<a href="?page=1" class="min">1</a>';
}

// Tombol halaman tengah (3 tombol)
$startPage = max(1, min($currentPage - 1, $totalPages - 2));
$endPage = min($totalPages, $startPage + 2);

for ($i = $startPage; $i <= $endPage; $i++) {
    $activeClass = $i === $currentPage ? 'active' : '';
    echo '<a href="?page=' . $i . '" class="' . $activeClass . '">' . $i . '</a>';
}

// Tombol "max" (halaman terakhir)
if ($currentPage < $totalPages - 1) {
    echo '<a href="?page=' . $totalPages . '" class="max">' . $totalPages . '</a>';
}

echo '</div>';
?>


<script>

</script>




<div id="ab">
    <div class="container" style="max-width: 800px; margin: 0 auto; text-align: center; padding: 20px;">
        <h1 style="color: #e74c3c;">About Us</h1>
        <hr style="border: 1px solid #e74c3c; width: 60%; margin: 10px auto;">
        <div style="border-top: 4px solid #e74c3c; border-bottom: 4px solid #e74c3c; padding: 20px 0; margin: 20px 0;">
            <p style="line-height: 1.8; text-align: justify; margin: 0;">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit architecto ratione enim sunt eaque porro aperiam omnis? Fugit, optio eius exercitationem accusantium delectus quibusdam mollitia est laboriosam obcaecati placeat sunt quod, praesentium saepe eaque expedita iure, molestias culpa. Labore, ipsam voluptatem! At ut dicta est doloremque cum, libero nihil aperiam!
            </p>
            <p style="line-height: 1.8; text-align: justify; margin: 20px 0;">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque quasi dolorem non totam eaque laboriosam, aperiam architecto velit possimus maxime, magnam reiciendis corporis optio rerum sit repellendus saepe. Veniam laudantium consectetur optio quidem tempore asperiores deleniti a nihil nostrum eius!
            </p>
            <p style="line-height: 1.8; text-align: justify; margin: 0;">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugiat, tenetur explicabo reprehenderit atque facere quam omnis inventore porro eum vitae non delectus ducimus quod eius quisquam tempore magnam itaque dolore?
            </p>
        </div>
    </div>
</div>

<!-- FAQ -->

<section id="faq" class="faq-section">
<h2>FAQs (Frequently Asked Questions)</h2>
    <div class="faq-item">
        <details>
            <summary>Lorem ipsum dolor sit amet.</summary>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nostrum quam optio maxime quod autem vitae vel sed hic obcaecati culpa.</p>
        </details>
    </div>
    <div class="faq-item">
        <details>
            <summary>Lorem ipsum dolor, sit amet consectetur adipisicing.</summary>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam, corrupti atque! Et, aperiam expedita! Dicta voluptatum assumenda harum eos omnis.
            </p>
        </details>
    </div>
    <div class="faq-item">
        <details>
            <summary>Lorem, ipsum dolor.</summary>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia omnis cupiditate deleniti asperiores quos facilis excepturi sint itaque, ex voluptatum!</p>
        </details>
    </div>
    <div class="faq-item">
        <details>
            <summary>Lorem ipsum dolor sit.</summary>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate velit tempore ipsam cupiditate vitae doloremque accusamus, ab fugit modi. Cum.</p>
        </details>
    </div>
    <div class="faq-item">
        <details>
            <summary>Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis!</summary>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quibusdam sed animi officiis recusandae officia culpa. Totam fugit quidem ipsum cum!</p>
        </details>
    </div>
</section>

<!-- contact -->


</main>

<?php include('footer.php'); ?>

</body>
</html>