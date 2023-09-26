<!-- BEGIN: MAIN -->
<div class="table-responsive">
<!-- IF {PHP.is_backend} -->
	<div class="btn-group mb-3">
		<a href="{PHP|cot_url('admin', 'm=other&p=thanks')}" class="btn btn-sm btn-primary">
			{PHP.R.icon-arrow-left}<span>{PHP.L.Back}</span>
		</a>
	</div>
<!-- ENDIF -->
	<table class="table table-striped table-hover">
		<thead>
			<tr class="text-center">
				<th>{PHP.L.Date}</th>
				<th>{PHP.L.Sender}</th>
				<th>{PHP.L.Category}</th>
				<th>{PHP.L.Item}</th>
<!-- IF {PHP.is_backend} -->
				<th>{PHP.L.Action}</th>
<!-- ENDIF -->
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: PAGE_ROW -->
			<tr class="text-center">
				<td>
					{PAGE_ROW_DATE}
				</td>
				<td>
					<a href="{PAGE_ROW_FROM_URL}">{PAGE_ROW_FROM_NAME}</a>
				</td>
				<td>
					<a href="{PAGE_ROW_CAT_URL}">{PAGE_ROW_CAT_TITLE}</a>
				</td>
				<td>
					<a href="{PAGE_ROW_URL}">{PAGE_ROW_TITLE}</a>
				</td>
<!-- IF {PHP.is_backend} -->
				<td>
					{PAGE_ROW_DELETE}
				</td>
<!-- ENDIF -->
			</tr>
			<!-- END: PAGE_ROW -->
			<!-- BEGIN: NONE -->
			<tr class="text-center">
				<td colspan="5">
					{PHP.L.thanks_none}
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
