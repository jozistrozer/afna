<?php
include_once 'header.php';
include_once 'session.php';
include_once 'db.php';

if (isset($_GET['q'])) {
    $query_s = $_GET['q'];
} else {
    $query_s = null;
}
?>
<style>
    #container {
        display: flex;
        justify-content:center;
        margin-top:15px;
        gap: 25px;
        flex-wrap:wrap;
    }
    #container > .card {
        margin: 6px;
    }
</style>
<script>
    function Search() {
        var w_search_value = document.getElementById('searchBar').value;

        if (w_search_value.length != 0) {
            window.location.href = "followers.php?q=" + w_search_value;
        }
    }
</script>

<div class="input-group" style="display:flex;justify-content:center;margin-top:5px;">
  <div class="form-outline" data-mdb-input-init>
    <input type="search" id="searchBar" class="form-control" />
  </div>
  <button type="button" class="btn btn-primary" value="Išči" onclick="Search()">
    <span>Išči</span>
  </button>
</div>

<div id="container">
<?php
    /*
        Iskanje sledilcev, listanje uporabnikov.
    */
    include_once 'db.php';
    $query = "SELECT *, profile_picture(id) pic FROM tab_users where id <> :id
    and concat(first_name, ' ', last_name) like nvl(:query  ,concat(first_name, ' ', last_name))";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $_SESSION['user_id'], 'query'=>'%'.$query_s.'%']);


    while ($result = $stmt->fetch()) {
?>
    <div class="card" style="width: 18rem;">
    <img class="card-img-top" src="..." alt="">
    <div class="card-body">
        <img src="<?php echo $result['pic']; ?>" width=25 height=25>
        <h5 class="card-title"><a href="<?php echo 'user.php?user_id='.$result['id'] ?>"><?php echo $result['first_name'] . ' ' . $result['last_name']; ?></a></h5>
        <p class="card-text"><?php echo $result['description']; ?></p>
    </div>
    </div>
<?php } ?>
</div>