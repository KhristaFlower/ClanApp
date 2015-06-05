<div class="sidebar">
	<ul>
		{foreach from=$sidebar key=key item=value}
			<li>
				{if $key|@is_string}
					{* Sub list *}
					{$key}
					<ul>
						{foreach from=$value item=link}
							<li>
								<a href="{$link.href}">{$link.text}</a>
							</li>
						{/foreach}
					</ul>
				{else}
					{* Plain link *}
					<a href="{$value.href}">{$value.text}</a>
				{/if}
			</li>
		{/foreach}
	</ul>
</div>
