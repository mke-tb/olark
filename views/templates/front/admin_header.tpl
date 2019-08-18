<link href="{$module_dir|escape:'htmlall'}css/olark.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	/* Fancybox */
	{literal}
	$('a.olark-video-btn').live('click', function(){
	    $.fancybox({
	        'type' : 'iframe',
	        'href' : 'https://fast.wistia.com/embed/iframe/79c2daad08?',
	        'swf': {'allowfullscreen':'true', 'wmode':'transparent'},
	        'overlayShow' : true,
	        'centerOnScroll' : true,
	        'speedIn' : 100,
	        'speedOut' : 50,
	        'width' : 768,
	        'height' : 480
	    });
	    return false;
	});
	{/literal}
</script>
<img src="{$tracking|escape:'htmlall':'UTF-8'}" alt="tracking" style="display: none" />
<div class="panel">
	<div class="olark-wrap">
		<p class="olark-intro"><a href="https://mbsy.co/special/23704142" class="olark-logo" target="_blank"><img src="{$module_dir|escape:'htmlall'}img/olark_logo.png" alt="Olark" border="0" /></a><span>{l s='Chat with your Customers' mod='olark'}</span><br />
		{l s='Create trust, loyalty & happiness' mod='olark'}<br />
		<a href="https://mbsy.co/special/23704142" class="olark-link" target="_blank">{l s='Get Started Now' mod='olark'}</a></p>
		<div class="olark-content">
			<h3>{l s='Get to know your shoppers, create relationships with customers and increase sales.' mod='olark'}</h3>
			<div class="olark-video">
				<a href="https://fast.wistia.com/embed/iframe/79c2daad08?" class="olark-video-btn"><img src="{$module_dir|escape:'htmlall'}img/olark-video-screen.png" alt="Olark Video" /><img src="{$module_dir|escape:'htmlall'}img/btn-video.png" alt="" class="video-icon" /></a>
			</div>
			<ul>
				<li><img src="{$module_dir|escape:'htmlall'}img/olark-chat.png" alt="" /> {l s='Chat using your IM client' mod='olark'}</li>
				<li class="alt"><img src="{$module_dir|escape:'htmlall'}img/olark-heart.png" alt="" /> {l s='Satisfying User Experience' mod='olark'}</li>
				<li><img src="{$module_dir|escape:'htmlall'}img/olark-team.png" alt="" /> {l s='Work together as a team' mod='olark'}</li>
				<li class="alt"><img src="{$module_dir|escape:'htmlall'}img/olark-stats.png" alt="" /> {l s='Detailed Reporting &amp; Stats' mod='olark'}</li>
				<li><img src="{$module_dir|escape:'htmlall'}img/olark-crm.png" alt="" /> {l s='CRM &amp; Helpdesk Integration' mod='olark'}</li>
				<li class="alt"><img src="{$module_dir|escape:'htmlall'}img/olark-code.png" alt="" /> {l s='Powerful API' mod='olark'}</li>
			</ul>
			<p>{l s='Talk to your customers today!' mod='olark'} <a href="https://mbsy.co/special/23704142" class="olark-link" target="_blank">{l s='Create an Account' mod='olark'}</a></p>
		</div>
		<div class="clear"></div>
	</div>
</div>