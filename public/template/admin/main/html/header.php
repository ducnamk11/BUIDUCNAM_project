<?php 
$linkControlPanel = URL::createLink('admin','index','index');
$linkMyProfile = URL::createLink('admin','index','profile');
$linkUserManager = URL::createLink('admin','user','index');
$linkAddUser  = URL::createLink('admin','user','form');

$linkGroupManager = URL::createLink('admin','group','index');
$linkAddGroup  = URL::createLink('admin','group','form');

$linkCategoryManager = URL::createLink('admin','category','index');
$linkAddCategory  = URL::createLink('admin','category','form');

$linkBookManager = URL::createLink('admin','book','index');
$linkAddBook  = URL::createLink('admin','book','form');

$linkLogout  = URL::createLink('admin','index','logout');
$linkViewSite  = URL::createLink('default','index','index');


?>



<body>
	<div id="border-top" class="h_blue">
		<span class="title"><a href="index.php">Administration</a></span>
	</div>
	

	
	<!-- HEADER -->
	<div id="header-box">
		<div id="module-status"> 
			<span class="viewsite"><a href="<?php echo $linkViewSite; ?>">View site</a></span> 
			<span class="no-unread-messages"><a href="<?php echo $linkLogout; ?>">Log out</a></span> 
		</div>
		<div id="module-menu">
			<!-- MENU -->
			<ul id="menu" >
				<li class="node"><a href="#">Site</a>
					<ul>
						<li><a class="icon-16-cpanel" href="<?php echo $linkControlPanel; ?>">Control Panel</a></li>
						<li class="separator"><span></span></li>
						<li><a class="icon-16-profile" href="<?php echo $linkMyProfile; ?>">My Profile</a></li>
						<li class="separator"><span></span></li>

					</ul>
				</li>
				
				<li class="node"><a href="#">User</a>
					<ul>
						<li class="node">
							<a href="<?php echo $linkUserManager; ?>" class="icon-16-user"> User Manage</a>
							<ul id="menu-com-users-users" class="menu-component">
								<li>
									<a href="<?php echo $linkAddUser; ?>" class="icon-16-newarticle"> Add new user</a>
								</li>
							</ul>
						</li>




						<!-- category -->
						<li class="node">
							<a href="<?php echo $linkGroupManager; ?>" class="icon-16-user"> Group Manage</a>
							<ul id="menu-com-users-groups" class="menu-component">
								<li>
									<a href="<?php echo $linkAddGroup ; ?>" class="icon-16-newarticle"> Add new Group</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>

				<li class="node"><a href="#">Book Shopping</a>
					<ul> 
						<li class="node">
							<a href="<?php echo $linkCategoryManager; ?>" class="icon-16-category"> Category Manage</a>
							<ul id="menu-com-users-groups" class="menu-component">
								<li>
									<a href="<?php echo $linkAddCategory; ?>" class="icon-16-newarticle"> Add new Category</a>
								</li>
							</ul>
						</li>
						<li class="node">
							<a href="<?php echo $linkBookManager; ?>" class="icon-16-article"> Book Manage</a>
							<ul id="menu-com-users-groups" class="menu-component">
								<li>
									<a href="<?php echo $linkAddBook; ?>" class="icon-16-newarticle"> Add new Book</a>
								</li>
							</ul>
						</li>
					</li>
				</ul>
			</div>

			<div class="clr"></div>
		</div>
		<div id="content-box">


