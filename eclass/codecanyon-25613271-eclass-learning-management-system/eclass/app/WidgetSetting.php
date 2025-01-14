<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WidgetSetting extends Model
{
	protected $table = 'widget_settings';
	
    protected $fillable = ['widget_one', 'widget_two', 'widget_three', 'widget_enable', 'about_enable', 'contact_enable', 'career_enable', 'blog_enable', 'help_enable'];
}
