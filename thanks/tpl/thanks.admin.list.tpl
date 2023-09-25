<!-- BEGIN: MAIN -->
<div class="{PHP.R.admin-table-responsive-container-class}">
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
					{PAGE_ROW_THANKS_MORE}
				</td>
			</tr>
			<!-- END: PAGE_ROW -->
		</tbody>
	</table>
	<!-- IF {PAGE_TOP_PAGINATION} -->
	<nav class="mt-3" aria-label="Thanks Pagination">
		<ul class="pagination pagination-sm justify-content-center mb-0">
			{PAGE_TOP_PAGEPREV}{PAGE_TOP_PAGINATION}{PAGE_TOP_PAGENEXT}
		</ul>
	</nav>
	<!-- ENDIF -->
	<a href="{PHP|cot_url('admin', 'm=other&p=thanks')}" class="btn btn-primary btn-sm mt-3">
		{PHP.R.icon-hand-point-right}<span>{PHP.L.thanks_title_short}</span>
	</a>
</div>
<!-- END: MAIN -->
