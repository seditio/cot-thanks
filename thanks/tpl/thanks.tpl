<!-- BEGIN: MAIN -->
<main id="thanks_list">
	<div class="container">

		<div class="row my-5">
			<div class="col-lg-8 mx-lg-auto">
				<div class="title px-2 px-sm-0">
					<h1 class="lh-1 mb-1">{THANKS_TITLE}</h1>
					<p class="mb-0">
						{THANKS_BREADCRUMBS}
					</p>
				</div>
				{FILE "{PHP.cfg.themes_dir}/{PHP.theme}/warnings.tpl"}
				{THANKS_LIST}
			</div>
		</div>

	</div>
</main>
<!-- END: MAIN -->
