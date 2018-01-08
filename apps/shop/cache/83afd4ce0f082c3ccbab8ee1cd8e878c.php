<!DOCTYPE html>
<html lang="vi"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="keywords" content="footer, address, phone, icons"><title>Christmas Store</title><!-- CSS --><link rel="stylesheet" href="/resources/css/font-awesome.min.css"><link rel="stylesheet" href="/resources/css/style.css"><!-- JS --><script src="/resources/js/jquery-3.2.1.min.js"></script><script language="javascript" src="/resources/js/common.js"></script><script language="javascript" src="/resources/js/custom.js"></script></head><body>
<header><?php /**
 * @var \apps\shop\model\object\Category[] $categories
 */
?><div class="row bg-danger">
    <div class="col-3">
        <div class="img">
            <img src="/resources/images/nav_logo.png"></div>
    </div>
    <form action="#" class="col-4">
        <div class="col-7">
            <input class="input" type="text" placeholder="Chọn sản phẩm cần tìm" name="search"></div>
        <button id="btn" class="btn" type="submit"><i class="fa fa-search" aria-hidden="true">search</i>
        </button>
    </form>
    <div class="col-3 text-right">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        <img src=""><a href="">Đăng nhập</a>
    </div>
</div>
<div class="row bg-success">
    <?php $wActionObject = new \apps\shop\controller\web\NavGeneratorAction(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse()); $wActionObject->doGet(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse(), new \core\app\AppView(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse()))?>
</div>
</header><div class="link">
    <a href=""></a>
</div>
<div class="slider">

    <!-- Full-width images with number and caption text -->
    <div class="mySlides fade">
        <div class="numbertext">1 / 4</div>
        <img class="img-responsive" alt="Quà tặng giáng sinh" src="https://cdn-quatructuyen.r.worldssl.net/media/wysiwyg/quatt/banner-christmas.jpg" title="Quà tặng giáng sinh" style="width:100%"><div class="text">Caption Text</div>
    </div>

    <div class="mySlides fade">
        <div class="numbertext">2 / 4</div>
        <img class="img-reponsive" alt="quà tặng giáng sinh" src="https://wallpaper.wiki/wp-content/uploads/2017/05/Christmas-Wallpaper-HD-Download-Desntop.jpg"><div class="text">Caption Two</div>
    </div>

    <div class="mySlides fade">
        <div class="numbertext">3 / 4</div>
        <img class="img-reponsive" alt="quà tặng giáng sinh" src="https://lh3.ggpht.com/y9Sqq9XPPetLcYitxTJXmvPaIFU0vQ20JudZSWiweDfaNV6uV2xT3lieZpJTeVCMRCk=h900"><div class="text">Caption Three</div>
    </div>
    <div class="mySlides fade">
        <div class="numbertext">4/ 4</div>
        <img class="img-reponsive" alt="Quà tặng giáng sinh" src="https://s-media-cache-ak0.pinimg.com/originals/45/93/6e/45936e18560b41afa65d53089e441dbb.jpg"><div class="text">Caption Four</div>
    </div>

    <!-- Next and previous buttons -->
    <a class="prev" onclick="plusSlides(-1)">❮</a>
    <a class="next" onclick="plusSlides(1)">❯</a>
</div>
<br><!-- The dots/circles --><div style="text-align:center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
</div>
<footer class="footer"><div class="contact">
    <b>GIẢI ĐÁP THÔNG TIN.</b><br><p>Liên hệ : Trường đại học công nghệ thông tin , Khu phố 6, phường Linh
        Trung ,quận Thủ Đức, tp. HCM</p>
    <p>Số điện thoại : 1900-82234-4754</p>
    <a href="">Hướng dấn đổi trả.</a>
</div>
<div class="information">
    <b>MERY CHISTHMUS STORE</b>
    <p>Cửa hàng của chúng tôi rất vui lòng được phục vụ quý khách.
    </p>
</div>
<div class="social">
    <b> CÁC CỔNG THÔNG TIN CHÍNH CỦA CỬA HÀNG .</b><br><i class="fa fa-facebook-official" aria-hidden="true"></i><br><p>Facebook</p>
    <i class="fa fa-envelope-o" aria-hidden="true"></i><br><p>twiter </p>
    <i class="fa fa-twitter" aria-hidden="true"></i><br><p>Gmail</p>
</div>
<div class="logo">
    <img src="/resources/images/nav_logo.png"><b>HỆ THỐNG CÁC CỬA HÀNG :</b>
    <ul><li>Cơ sở 1 : Khu phố 6, phường Linh Trung ,quận Thủ Đức, tp. HCM</li>
        <li>Cơ sở 2 : Khu phố 6, phường Linh Trung ,quận Thủ Đức, tp. HCM</li>
        <li>Cơ sở 3 : Khu phố 6, phường Linh Trung ,quận Thủ Đức, tp. HCM</li>
        <li>Cơ sở 4 : Khu phố 6, phường Linh Trung ,quận Thủ Đức, tp. HCM</li>
    </ul></div>
</footer></body></html>
