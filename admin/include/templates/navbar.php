<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php">Home</a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav count">
        <li><a href="categories.php">Categories</a></li>
        <li><a href="items.php"><span><?php echo checkitem("Approve","items","0"); ?></span>Items</a></li>
        <li><a href="members.php"><span><?php echo checkitem("Regstatus","users","0"); ?></span>Members</a></li>
        <li><a href="comments.php"><span><?php echo checkitem("Status","comments","0"); ?></span>Comments</a></li>
        <li><a href="orders.php"><span><?php echo checkitem("delivered","orders","0"); ?></span>Orders</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['user'] ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php">Visit Shop</a></li>
            <li><a href="members.php?do=Edit&UserId=<?php echo $_SESSION['Id'] ?>">Edit Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>