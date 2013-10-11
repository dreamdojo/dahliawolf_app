<div id="sort-bar">
    <div class="filter-wrap">
        Sort Inspirations By:
        <span class="">
            <a id="filterNewest" class="sort-option <?= ($_GET['sort'] == 'new' || empty($_GET['sort']) ? 'filter-select' : '') ?>" href="/vote?sort=new">newest</a>
        </span> /
        <span class="">
            <a id="filterTrending" class="sort-option <?= ($_GET['sort'] == 'hot' ? 'filter-select' : '') ?>" href="/vote?sort=hot"> trending</a>
        </span>
        <? if (IS_LOGGED_IN): ?>
             / <span class="">
                    <a id="filterFollowing" class="sort-option <?= ($_GET['sort'] == 'following' ? 'filter-select' : '') ?>" href="/spine?sort=following"> following</a>
            </span>
        <? endif ?>
        <span style="float: right;width: 150px;margin-right: -3px;">View: <span class=""><a id="selectSpine" class="sort-option" href="/vote">two</a></span> /
        <span class=""><a id="selectGrid" class="sort-option filter-select" href="/vote"> three</a></span>
        </span>
    </div>
</div>