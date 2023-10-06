<!-- BEGIN: MAIN -->
<div class="table-responsive">
<!-- IF {PHP.is_backend} -->
	<div class="btn-group mb-3">
		<a href="{PAGE_TOP_SYNC_URL}" class="btn btn-sm btn-primary">
			{PHP.R.icon-refresh}<span>{PHP.L.Resync}</span>
		</a>
		<a href="{PAGE_TOP_FULLSYNC_URL}" class="btn btn-sm btn-primary">
			{PHP.R.icon-refresh}<span>{PHP.L.thanks_fullsync}</span>
		</a>
	</div>
<!-- ENDIF -->
	<table class="table table-striped table-hover mb-0">
		<thead>
			<tr class="text-center">
				<th class="w-25">#</th>
				<th class="w-25">{PHP.L.User}</th>
				<th class="w-25">{PHP.L.Count}</th>
				<th class="w-25">{PHP.L.Action}</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: PAGE_ROW -->
			<tr class="text-center">
				<td>
					{PAGE_ROW_NUM}.
				</td>
				<td>
					{PAGE_ROW_USER_NAME}
				</td>
				<td>
					{PAGE_ROW_THANKS_TOTALCOUNT}
				</td>
				<td>
					<div class="btn-group">{PAGE_ROW_THANKS_MORE}{PAGE_ROW_THANKS_DELETE_USER}</div>
				</td>
			</tr>
			<!-- END: PAGE_ROW -->
			<!-- BEGIN: NONE -->
			<tr class="text-center">
				<td colspan="4">
					{PHP.L.thanks_users_none}
				</td>
			</tr>
			<!-- END: NONE -->
		</tbody>
	</table>
	<!-- IF {PAGE_TOP_PAGINATION} -->
	<nav class="mt-3" aria-label="Thanks Pagination">
		<ul class="pagination pagination-sm justify-content-center mb-0">
			{PAGE_TOP_PAGEPREV}{PAGE_TOP_PAGINATION}{PAGE_TOP_PAGENEXT}
		</ul>
	</nav>
	<!-- ENDIF -->
</div>
<!-- END: MAIN -->
