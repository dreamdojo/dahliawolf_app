<div id="sort-bar">
    <div class="filter-wrap">
        Sort Inspirations By:
        <span class="">
            <a id="filterNewest" class="sort-option <?= ($_GET['sort'] == 'new'  ? 'filter-select' : '') ?>" href="/vote?sort=new">newest</a>
        </span> /
        <span class="">
            <a id="filterTrending" class="sort-option <?= (empty($_GET['q']) ? 'filter-select' : '') ?>" href="/vote?sort=hot"> trending</a>
        </span> /
        <span class="">
            <a id="filterPopular" class="sort-option"> Popular</a>
        </span>
        <? if (IS_LOGGED_IN): ?>
             / <span class="">
                    <a id="filterFollowing" class="sort-option <?= ($_GET['sort'] == 'following' ? 'filter-select' : '') ?>" href="/vote?sort=following"> following</a>
            </span>
        <? endif ?>
        <? if(!empty($_GET['q'])): ?>
            / <span>
                <a id="filterFollowing" class="sort-option filter-select" href="/vote"> search results: <?= $_GET['q'] ?></a>
            </span>
        <? endif ?>
        <?php if(empty($_GET['q'])): ?>
            <span style="float: right;width: 140px;margin-right: -3px;">View: <span class=""><a id="selectSpine" class="sort-option" href="/vote">two</a></span> /
            <span class=""><a id="selectGrid" class="sort-option filter-select" href="/vote"> three</a></span>
            </span>
        <? endif ?>
    </div>
</div>