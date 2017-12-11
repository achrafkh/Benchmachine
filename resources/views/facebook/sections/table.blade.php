<div class="section table-section" data-aos="fade-up" data-aos-once="true" data-aos-duration="800" data-aos-delay="200" data-aos-offset="240">
	<div class="container" >
		<div class="section-header">
			<h2 class="section-title">
			Data
			</h2>
			<span class="section-cap">
				Benchmark overview
			</span>
		</div>
		<table id="table" class="data-table">
			<thead>
				<tr>
					<th data-sortable="true">Facebook pages</th>
					<th data-sortable="true">Total</th>
					<th data-sortable="true">New</th>
					<th data-sortable="true">Local</th>
					<th data-sortable="true">Admin</th>
					<th data-sortable="true">Fans</th>
					<th data-sortable="true">Total</th>
					<th data-sortable="true">Likes</th>
					<th data-sortable="true">Comments</th>
					<th data-sortable="true">Share</th>
					<th data-sortable="true">Page</th>
					<th data-sortable="true">Posts</th>
				</tr>
			</thead>
			<tbody>
<?php $nbr_pub = 'Nombre de publication des fans';
$nbr_rep = 'Taux de réponse';
// dd($accounts);
?>
			@foreach($accounts as $account)
				<tr data-index="0">
					<td>
						<div data-field="page" class="media table-fbpage">
							<div class="media-left media-middle">
								<span class="table-fbpage-img" style="background-image:url(http://graph.facebook.com/{{$account->social_account_name->real_id}}/picture)"></span>
							</div>
							<div class="media-body media-middle">
								<a target="_blank" href="https://www.facebook.com/{{ $account->social_account_name->label }}"><span class="table-fbpage-name">{{ $account->social_account_name->title }}</span></a>
								<span class="table-fbpage-id">{{ $account->social_account_name->label }}</span>
							</div>
						</div>
					</td>
					<td><span class="table-digit">{{ $account->fans->value }}</span></td>
					<td><span class="table-digit up">{{ is_null($account->absolute_fans->value) ? 0 : $account->absolute_fans->value }}</span></td>
					<td><span class="table-digit">{{ is_null($account->fans_local->value) ? 0 : $account->fans_local->value }}</span></td>
					<td><span class="table-digit">{{ is_null($account->posts->value) ? 0 : $account->posts->value }}</span></td>
					<td><span class="table-digit">{{ $account->{$nbr_pub}->value }}</span></td>
					<td><span class="table-digit">{{ ($account->likes->value + $account->comments->value + $account->shares->value) }}</span></td>
					<td><span class="table-digit">{{ $account->likes->value }}</span></td>
					<td><span class="table-digit">{{ $account->comments->value }}</span></td>
					<td><span class="table-digit">{{ $account->shares->value }}</span></td>
					<td><span class="table-digit">{{ number_format($account->page_engagement->value, 3, '.', ',')  }}%</span></td>
					<td><span class="table-digit"> {{number_format($account->average_page_engagement->value, 3, '.', ',') }} %</span></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
