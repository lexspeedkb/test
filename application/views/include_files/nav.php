<?=$navBar?>

<?php if (!empty($navBar)): ?>    
    <form class="form-inline my-2 my-lg-0" method="GET" action="/navBar/search">
        <input class="form-control mr-sm-2"name="s" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
<?php endif ?>