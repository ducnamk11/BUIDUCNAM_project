<?php 
$linkCategory = URL::createLink('admin','category','index');
$linkBook = URL::createLink('admin','book','index');
 ?>

<div id="submenu-box">
					<div class="m">
						<ul id="submenu">
							<li><a class="active"  href="#">category</a></li>
							<li><a href="<?php echo $linkBook; ?>">book</a></li>
 						</ul>
						<div class="clr"></div>
					</div>
				</div>