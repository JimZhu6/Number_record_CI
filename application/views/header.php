
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>号码记录</title>
  <link rel="stylesheet" href="/assets/css/icon/family.css" />
  <link rel="stylesheet" href="/assets/css/base.css" />
  <link rel="stylesheet" href="/assets/css/materialize.css" />
  <link rel="stylesheet" href="/assets/css/index.css" />
</head>

<body>
  <header>
    <nav>
      <div class="nav-wrapper">
        <a href="#" class="brand-logo"><i class="material-icons left">local_offer</i>号码记录系统</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
					<li class="nav-login-box">

						<?php if(isset($_SESSION['username'])): ?>
						<a href="javascript:;" class="waves-effect waves-light btn" id="login"><i class="material-icons left">check</i>
						已登录用户:<?php echo $_SESSION['username'] ?></a>

						<?php else: ?>
						<a href="javascript:;" class="waves-effect waves-light btn pulse" id="login"><i class="material-icons left">dvr</i>
						请登录</a>
						<?php endif; ?>
          </li>
        </ul>
      </div>
    </nav>
  </header>
