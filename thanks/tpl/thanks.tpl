<!-- BEGIN: MAIN -->
<main id="thanks_list">
	<div class="container">

		<div class="row my-5">
			<div class="col {THANKS_CLASS}">
				<div class="title px-2 px-sm-0">
					<h1 class="lh-1 mb-1">{THANKS_TITLE}</h1>
					<p class="mb-0">
						{THANKS_BREADCRUMBS}
					</p>
				</div>
				<div id="thanks_ajax" class="mb-3">
					{THANKS_LIST}
				</div>
				{FILE "{PHP.cfg.themes_dir}/{PHP.theme}/warnings.tpl"}
				<!-- IF {THANKS_BACK} -->
				<a href="{THANKS_BACK}" class="btn btn-primary mx-auto w-25 d-block">{PHP.L.Back}</a>
				<!-- ENDIF -->
			</div>
		</div>

	</div>
</main>
<!-- END: MAIN -->
