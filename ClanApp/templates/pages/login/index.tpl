{extends file="layouts/base.tpl"}
{block name=base}

	{literal}
		<style type="text/css">
			body {
				padding: 40px 0;
			}
		</style>
	{/literal}

	<div class="container">

		<form action="/login" method="post" class="page-form">
			<h2>Sign in</h2>

			{if isset($error)}
				<div class="alert alert-error">{$error}</div>
			{/if}

			<label for="inputEmail" class="sr-only">Email address</label>
			<input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus/>

			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required/>

			<div class="checkbox">
				<label>
					<input type="checkbox" value="remember-me"/> Remember me
				</label>
			</div>

			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

		</form>

	</div>

{/block}
