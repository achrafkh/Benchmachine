<div class="col-lg-3 col-md-4 col-sm-6 col-ms-6">
	<a class="post" target="_blank" href="https://www.facebook.com/{{ $post->social_post_real_id }}">
	@if($post->social_post_type != 'status')
	<?php $style = true;?>
		<div class="post-img" style="background-image:url({{ postImage($post->social_post_real_id)  }})"></div>
	@endif
		<div class="post-content" >
			<div class="media post-brand">
				<div class="media-left media-middle">
					<span class="brand-img" style="background-image:url({{ $post->account_picture  }})"></span>
				</div>
				<div class="media-body media-middle">
					<span class="brand-name">{{ $post->account_name }}</span>
					<span class="post-date">{{ $post->social_post_date }}</span>
				</div>
			</div>
			@if(isset($post->social_post_message) && trim($post->social_post_message) != '')
					@if(is_arabic($post->social_post_message))
					<p class="post-txt" style="text-align: right;{{ isset($style) ? '' : 'height:255px;'  }}">
						{{  mb_convert_encoding($post->social_post_message, 'UTF-8') }}
					</p>
					@else
					<p class="post-txt" style="text-align: left;{{ isset($style) ? '' : 'height:255px;'  }}">
						{{ $post->social_post_message  }}
					</p>
					@endif
				@else
				<p class="post-txt" style="{{ isset($style) ? '' : 'height:218px;'  }}">
				</p>
				@endif
		</div>
		<ul class="post-stats">
			<li data-toggle="tooltip" data-placement="bottom" data-html="true" title="{{ $post->likes }} <br> Likes">
				<span class="post-stats-digit">{{ number_shorten($post->likes, 1) }}</span>
				<span class="post-stats-cap">Likes</span>
			</li>
			<li data-toggle="tooltip" data-placement="bottom" data-html="true" title="{{ $post->shares }} <br> Comments">
				<span class="post-stats-digit">{{ $post->comments }}</span>
				<span class="post-stats-cap">Cmnt</span>
			</li>
			<li data-toggle="tooltip" data-placement="bottom" data-html="true" title="{{ $post->shares }} <br> Share">
				<span class="post-stats-digit">{{ $post->shares }}</span>
				<span class="post-stats-cap">Share</span>
			</li>
			<li data-toggle="tooltip" data-placement="bottom" data-html="true" title="{{$post->total_interactions}} <br> Interactions">
				<span class="post-stats-digit">{{ number_shorten($post->total_interactions, 1) }}</span>
				<span class="post-stats-cap">Intrct</span>
			</li>
			<li data-toggle="tooltip" data-placement="bottom" data-html="true" title="{{ number_format($post->engagement_rate, 3,',', '.' ) }} <br> Engagements">
				<span class="post-stats-digit">{{ number_format($post->engagement_rate, 3,',', '.' ) }}</span>
				<span class="post-stats-cap">Egmnt</span>
			</li>
		</ul>
	</a>
</div>
