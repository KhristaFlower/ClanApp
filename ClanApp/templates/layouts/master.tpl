{include file="layouts/base.tpl"}
{block name=base}
	<header>
		<div class="container">
			<h1>Fusion Core <small>Clan App</small></h1>
		</div>
	</header>

	<section>

		<div class="container">
			{include file="layouts/includes/sidebar.tpl"}
			<div class="content">
				{block name=body}{/block}
			</div>
		</div>

		<div class="break"></div>

	</section>

	<footer>
		<p>
			The Clan App framework is a tool to manage many aspects of clan administration.
		</p>
	</footer>
{/block}
