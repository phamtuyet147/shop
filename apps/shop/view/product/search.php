<h1>Kết quả tìm kiếm::"{w:text keyword}"</h1>
{w:func foreach ($products as $product) { }
    <div class="well">
        <h2><a href="/product/{w:var product->getShortTag() }">
                {w:text product->getTitle() }
            </a></h2>
        <hr>
        {w:text product->getShortDesc() }
    </div>
{/w:func}