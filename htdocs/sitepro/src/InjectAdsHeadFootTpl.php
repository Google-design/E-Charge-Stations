<?php function wbspadtopFunc($data) {
	global $lang, $base_lang;
	if (!isset($data)) return;
	$custId = sprintf('%08x', crc32('??'.microtime()));
	$ln = isset($lang) ? $lang : (isset($base_lang) ? $base_lang : 'en');
	if (class_exists('SiteModule')) {
		if (isset(SiteModule::$baseLang) && SiteModule::$baseLang) {
			$ln = SiteModule::$baseLang;
		}
		if (isset(SiteModule::$lang) && SiteModule::$lang) {
			$ln = SiteModule::$lang;
		}
	}
	$lln = ($ln != 'en') ? "{$ln}/" : '';

	$logo = isset($data->logo) ? $data->logo : 'https://site.pro/assets/img/sitepro-logo-black.svg';
	$logoUrl = isset($data->logoUrl->{$ln}) ? $data->logoUrl->{$ln} : (isset($data->logoUrl->en) ? $data->logoUrl->en
		: htmlspecialchars(str_replace('{ln}', $lln, 'https://site.pro/{ln}'))
	);
	$logoTitle = isset($data->logoTitle->{$ln}) ? $data->logoTitle->{$ln} : (isset($data->logoTitle->en) ? $data->logoTitle->en
		: 'Professional Website Builder'
	);
	$closeUrl = isset($data->closeUrl->{$ln}) ? $data->closeUrl->{$ln} : (isset($data->closeUrl->en) ? $data->closeUrl->en
		: htmlspecialchars(str_replace('{ln}', $lln, 'https://site.pro/{ln}'))
	);
	$closeTitle = isset($data->closeTitle->{$ln}) ? $data->closeTitle->{$ln} : (isset($data->closeTitle->en) ? $data->closeTitle->en
		: 'Remove Ads'
	);
	$topText = isset($data->topText->{$ln}) ? $data->topText->{$ln} : (isset($data->topText->en) ? $data->topText->en
		: 'Free Website Builder. Unlimited Storage. Unlimited Websites'
	);
	$topBtn = isset($data->topBtn->{$ln}) ? $data->topBtn->{$ln} : (isset($data->topBtn->en) ? $data->topBtn->en
		: str_replace('{ln}', $lln, '<a class="btn btn-success" href="https://site.pro/{ln}" target="_blank" title="Create website">Create website</a>')
	);
	$bottomTextA = isset($data->bottomTextA->{$ln}) ? $data->bottomTextA->{$ln} : (isset($data->bottomTextA->en) ? $data->bottomTextA->en
		: str_replace('{ln}', $lln, (
			'<a href="https://site.pro/{ln}" target="_blank" title="Professional Website Builder">Professional Website Builder</a>.'
			.' <a href="https://site.pro/{ln}" target="_blank" title="White Label Website Builder">White Label Website Builder</a>.'
			.' <a href="https://site.pro/{ln}" target="_blank" title="Website Import">Website Import</a>.'))
	);
	$bottomTextB = isset($data->bottomTextB->{$ln}) ? $data->bottomTextB->{$ln} : (isset($data->bottomTextB->en) ? $data->bottomTextB->en
		: str_replace('{ln}', $lln, 'Powered by <a href="https://site.pro/{ln}" target="_blank" title="Professional Website Builder">Site.pro</a>')
	);
	$bottomFgColor = isset($data->bottomFgColor) ? $data->bottomFgColor : '#fff';
	$bottomBgColor = isset($data->bottomBgColor) ? $data->bottomBgColor : '#4faf54';

	ob_start();
?>
<style type="text/css">
.d-cust-id-close {
	position: absolute;
	display: block;
	right: 30px;
	font-size: 25px;
	cursor: pointer;
}
.d-cust-id-close::before {
	content: '×';
}
.d-cust-id-top {
	z-index: 99999;
	position: relative;
	width: 100%;
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	justify-content: center;
	align-items: center;
	background-color: #fff;
	padding: 15px;
	border: 2px solid #000;
	font-size: 14px;
	color: #333;
}
.d-cust-id-top .d-cust-id-close {
	color: #333;
}
.d-cust-id-top-logo {
	text-decoration: none;
	font-weight: normal;
}
.d-cust-id-top-logo img {
	height: 24px;
	margin-top: -4px;
}
.d-cust-id-top-text {
	margin: 5px 35px;
	text-align: center;
}
.d-cust-id-bottom {
	z-index: 99999;
	position: relative;
	width: 100%;
	display: flex;
	flex-direction: column;
	flex-wrap: wrap;
	justify-content: center;
	align-items: stretch;
	text-align: center;
	padding: 12px 15px;
	font-size: 14px;
	color: <?php echo $bottomFgColor; ?>;
	background-color: <?php echo $bottomBgColor; ?>;
}
.d-cust-id-bottom .d-cust-id-close {
	top: 14px;
	color: <?php echo $bottomFgColor; ?>;
}
.d-cust-id-bottom hr {
	display: block;
	font-size: 1px;
	line-height: 1px;
	overflow: hidden;
	padding: 0;
	margin: 16px 16px 12px;
	border-top: 1px solid <?php echo $bottomFgColor; ?>;
	border-bottom: none;
	border-right: none;
	border-left: none;
	border-radius: 0;
}
.d-cust-id-bottom-text-a,
.d-cust-id-bottom-text-b {
	padding: 3px 0;
	text-align: center;
}
.d-cust-id-bottom-text-a {
	padding-left: 36px;
	padding-right: 36px;
}
.d-cust-id-bottom-text-a hr {
	margin-left: -20px;
	margin-right: -20px;
}

.d-cust-id-bottom-text-a a,
.d-cust-id-bottom-text-a a:hover,
.d-cust-id-bottom-text-a a:active,
.d-cust-id-bottom-text-a a:visited,
.d-cust-id-bottom-text-b a,
.d-cust-id-bottom-text-b a:hover,
.d-cust-id-bottom-text-b a:active,
.d-cust-id-bottom-text-b a:visited {
	text-decoration: underline;
	color: <?php echo $bottomFgColor; ?>;
}
</style>
<script type="text/javascript">
	window.addEventListener("DOMContentLoaded", function() {
		var elem = $(".d-cust-id-bottom");
		if (elem.length > 0) {
			var topElem = $(".d-cust-id-top").parent();
			if (topElem.length) {
				topElem.append(elem);
				elem[0].style.display = '';
			}
			else if (document.body) {
				document.body.appendChild(elem[0]);
				elem[0].style.display = '';
			}
		}
	});
</script>
<div class="d-cust-id-top">
	<a class="d-cust-id-top-logo" href="<?php echo $logoUrl; ?>" target="_blank"
		title="<?php echo htmlspecialchars($logoTitle); ?>">
		<img src="<?php echo htmlspecialchars($logo); ?>" alt="Site.pro"/>
	</a>
	<div class="d-cust-id-top-text"><?php echo $topText; ?></div>
	<?php echo $topBtn; ?>
	<a class="d-cust-id-close" href="<?php echo $closeUrl; ?>" target="_blank"
		title="<?php echo htmlspecialchars($closeTitle); ?>"></a>
</div>
<div class="d-cust-id-bottom" style="display: none;">
	<div class="d-cust-id-bottom-text-a"><?php echo $bottomTextA; ?></div>
	<div class="d-cust-id-bottom-text-b"><?php echo $bottomTextB; ?></div>
	<a class="d-cust-id-close" href="<?php echo $closeUrl; ?>" target="_blank"
		title="<?php echo htmlspecialchars($closeTitle); ?>"></a>
</div>
<?php
	echo str_replace('-cust-id-', "{$custId}-", ob_get_clean());
} ?>
