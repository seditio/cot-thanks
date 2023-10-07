<!-- BEGIN: MAIN -->
<div class="table-responsive">
	<table class="table table-striped table-hover">
		<thead>
			<tr class="text-center">
				<th>{PHP.L.Date}</th>
				<th>{PHP.L.Sender}</th>
				<th>{PHP.L.Recipient}</th>
				<th>{PHP.L.Item}</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: PAGE_ROW -->
			<tr class="text-center">
				<td>
					{PAGE_ROW_DATE_STAMP|cot_date('j M', $this)}
				</td>
				<td>
					<a href="{PAGE_ROW_FROM_URL}">{PAGE_ROW_FROM_NAME}</a>
				</td>
				<td>
					<a href="{PAGE_ROW_TO_URL}">{PAGE_ROW_TO_NAME}</a>
				</td>
				<td>
					<a href="{PAGE_ROW_URL}">{PAGE_ROW_TITLE}</a>
				</td>
			</tr>
			<!-- END: PAGE_ROW -->
			<!-- BEGIN: NONE -->
			<tr class="text-center">
				<td colspan="4">
					{PHP.L.thanks_none}
				</td>
			</tr>
			<!-- END: NONE -->
		</tbody>
	</table>
	<!-- IF {PAGE_TOP_PAGINATION} -->
	<nav aria-label="Thanks Pagination">
		<ul class="pagination pagination-sm justify-content-center mb-0">
			{PAGE_TOP_PAGEPREV}{PAGE_TOP_PAGINATION}{PAGE_TOP_PAGENEXT}
		</ul>
	</nav>
	<!-- ENDIF -->
	<a href="{PHP|cot_url('admin', 'm=other&p=thanks')}" class="btn btn-primary btn-sm mt-3">
		{PHP.R.icon-hand-point-right}{PHP.L.thanks_title_short}
	</a>
</div>
<!-- END: MAIN -->
