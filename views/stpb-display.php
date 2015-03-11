<?php
$data .= 
'<div class="widget_profile dark">
	<div class="inner gradient">
		<div class="widget_profile_top clearfix">
					
			<div class="avatar">
				<img alt="Twitter Profile picture of '.$name.'" src="'.$this->stpb_image_url($img_url). '">
			</div>
			
			<h5>'.$name.'</h5>
			<span class="subtitle">@'.$scr_name.'</span>
				<div class="follow">
					<a href="https://twitter.com/intent/follow?original_referer='. urlencode($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]).'&region=follow_link&screen_name='.urlencode($scr_name).'&tw_p=followbutton&variant=2.0" class="btn btn-dark" target="_blank">
						<span>Follow</span>
					</a>
				</div>
		</div>
		<ul class="counters clearfix">
			<li>
				<a href="https://twitter.com/'.$scr_name.'" target="_blank">
					<p>'.$this->stpb_format_number($tweets).'</p>
					<span>Tweets</span>
				</a>
			</li>
			<li>
				<a href="https://twitter.com/'.$scr_name.'/following" target="_blank">
					<p>'.$this->stpb_format_number($following).'</p>
					<span>Following</span>
				</a>
			</li>
			<li>
				<a href="https://twitter.com/'.$scr_name.'/followers" class="last" target="_blank">
					<p>'. $this->stpb_format_number($followers).'</p>
					<span>Followers</span>
				</a>
			</li>
		</ul>
	</div>
</div>';
