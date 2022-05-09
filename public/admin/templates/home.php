<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Menu</title>
<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="<?php echo _BASE_URL; ?>templates/css/home.css">

<!--[if lte IE 8]>
<script type="text/javascript" src="<?php echo _BASE_URL; ?>templates/js/html5.js"></script>
<![endif]-->

<script src="<?php echo _BASE_URL; ?>templates/js/jquery.1.4.1.min.js"></script>
<script>
$(function() {
	$('.vertical li:has(ul)').addClass('parent');
	$('.horizontal li:has(ul)').addClass('parent');
});
</script>

</head>
<body>
<section>
<header>
	<h1>Menu</h1>
	<h2 id="link"><a href="<?php echo site_url('menu'); ?>">View Menu Setting</a></h2>
    <h2 id="link"><a href="index.php">Home Admin</a></h2>
</header>

<article>



<h4>Output:</h4>
<?php echo $horizontal1; ?>
<div class="clear"></div>

</article>

<footer>

</footer>
</section>
</body>
</html>