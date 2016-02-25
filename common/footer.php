      </div>
    </main>
    <footer class="footer" role="contentinfo">
        <nav class="navbar navbar-inverse navbar-static-bottom">
							<div class="container">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sub-navbar" aria-expanded="false" aria-controls="navbar">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
									<a class="navbar-brand" href="http://www.fitnyc.edu/">
										<?php echo '<img src="' . img('fit_logo.png') . '" alt="Brand">'; ?>
									</a>
									<p class="navbar-text">©2016 Fashion Institute of Technology</p>
								</div>
								<div id="sub-navbar" class="navbar-collapse collapse">
									<ul class="nav navbar-nav navbar-right">
										<li><a href="http://www.fitnyc.edu/library/sparc/index.php">Special Collections</a></li>
										<li><a href="http://blog.fitnyc.edu/materialmode/">Material Mode</a></li>
										<li><a href="http://www.fitnyc.edu/library/">FIT Library</a></li>
									</ul>
								</div><!--/.nav-collapse -->
							</div>
						</nav>
        <?php fire_plugin_hook('public_footer', array('view' => $this)); ?>
    </footer>
</body>
</html>
