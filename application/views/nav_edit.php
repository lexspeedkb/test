<form action="/navBar/<?=$action?>" method="POST">
    <?php if ($action!='delete'): ?>
        Title: <br>
        <input type="text" name="title" value="<?=$title?>"><br>
        Link: <br>
        <input type="text" name="link" value="<?=$link?>"><br>
        <br>
    <?php else: ?>
        Are you sure? <br>
        <a href="/home"><button type="button">NO</button></a>
    <?php endif ?>
    
    <input type="hidden" name="id" value="<?=$id?>">
    <input type="submit" value="YES">
</form>