<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerSetting extends Model
{
	protected $table = 'player_settings';
	
    protected $fillable = ['logo_enable', 'logo', 'cpy_text', 'share_enable', 'resumeplay', 'autoplay', 'download', 'subtitle_font_size', 'subtitle_color','embedded_enable','skin','player_google_analytics_id','chrome_cast'];

}
