<form itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction" role="search" method="get" id="search-form" class="search-box" action="/" aria-labelledby="search-label">
      <div id="search-label" hidden>Site</div>
    <input itemprop="query-input" type="search" placeholder="Search…" aria-label="Search" aria-describedby="button-addon2"
        name="s">
    <button type="submit" id="button-addon2">Search</button>
    <meta itemprop="target" content="<?php echo esc_attr( home_url( '/?s={search} ' ) ) ?>"/>
</form>