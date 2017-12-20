<div class="section table-section" data-aos="fade-up" data-aos-once="true" data-aos-duration="800" data-aos-delay="300" data-aos-offset="0">
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
					<th></th>
					<th colspan="3">Fans</th>
					<th colspan="2">Posts</th>
					<th colspan="4">Interactions</th>
					<th colspan="2">Av Engagement</th>
				</tr>
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
					<th data-sortable="true">Pages</th>
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
					<td class="table-digit">{{ $account->fans->value }}</td>
					<td class="table-digit {{ ($account->absolute_fans->value > 0) ? 'up' : 'down' }}">{{ is_null($account->absolute_fans->value) ? 0 : $account->absolute_fans->value }}</td>
					<td class="table-digit">{{ is_null($account->fans_local->value) ? 0 : $account->fans_local->value }}</td>
					<td class="table-digit">{{ is_null($account->posts->value) ? 0 : $account->posts->value }}</td>
					<td class="table-digit">{{ $account->{$nbr_pub}->value }}</td>
					<td class="table-digit">{{ ($account->likes->value + $account->comments->value + $account->shares->value) }}</td>
					<td class="table-digit">{{ $account->likes->value }}</td>
					<td class="table-digit">{{ $account->comments->value }}</td>
					<td class="table-digit">{{ $account->shares->value }}</td>
					<td class="table-digit">{{ number_format($account->page_engagement->value, 3, '.', ',')  }}%</td>
					<td class="table-digit"> {{number_format($account->average_page_engagement->value, 3, '.', ',') }} %</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
