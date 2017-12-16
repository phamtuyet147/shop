<div class="scroll-btn" id="scrollBtn">
    <a href="nav" data-toggle="tooltip"
       title="Intro"><i class="fa fa-circle"></i></a>
    <a href="#introduce" data-toggle="tooltip"
       title="Giới thiệu hệ thống"><i class="fa fa-circle"></i></a>
    <a href="#rule" data-toggle="tooltip"
       title="Quy định chung"><i class="fa fa-circle"></i></a>
    <a href="#acm_index" data-toggle="tooltip"
       title="UIT ACM Index"><i class="fa fa-circle"></i></a>
</div>
<div class="row home-parts" id="parts">
    <div class="trans animation-element bounce-up" id="intro">
        <div id="intro-video"></div>
        <div id="video-unmute"><i class="fa fa-volume-up"></i></div>
        <div class="overlay-info">
            <h3>CUỘC THI LẬP TRÌNH THUẬT TOÁN</h3>
            <h1>UIT ACM</h1>
            <div class="info-bottom">
                <h4>CUỘC THI LẬP TRÌNH THUẬT TOÁN DANH GIÁ NHẤT UIT</h4>
                <a class="home-info" id="showInfoBtn" href="#introduce">>>> MORE
                    <<<</a>
            </div>
        </div>
    </div>
    <div id="introduce" class="trans animation-element bounce-up">
        <div class="container">
            <h2>GIỚI THIỆU</h2>
            {w:view introduce}
        </div>
    </div>
    <div id="rule" class="trans animation-element bounce-up">
        <div class="container">
            {w:view rule}
        </div>
    </div>
    <div id="acm_index" class="trans animation-element bounce-up">
        <div class="container">
            {w:view acm_index}
        </div>
    </div>
</div>
<script type="text/javascript" src="/resources/js/home.js"></script>