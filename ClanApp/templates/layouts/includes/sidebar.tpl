<div class="sidebar">
	<ul>
		{foreach from=$sidebar item=item}
			<li>
				{if $item.type eq 'heading'}
					<h3>{$item.text}</h3>
				{elseif $item.type eq 'link'}
					<a href="{$item.href}">{$item.text}</a>
				{/if}
			</li>
		{/foreach}
	</ul>
</div>
