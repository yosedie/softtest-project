<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CourseClass;

class RenameVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rename:video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will rename the buggy videos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        ini_set('max_execution_time', 300);

        set_time_limit(0);

        ini_set('memory_limit', '-1');


        $videos = CourseClass::where('video','!=','')->get();

        $this->info('Retevring all courses....');

        $dir3 = public_path().'/video/class';

        
        $files = scandir($dir3);

        foreach($files as $file){

            if(!strstr($file,'.mp4') && !strstr($file,'.php')){

                if(strstr($file,'mp4')){
                
                    $filePath = public_path().'/video/class/'.$file;

                    $vid_name1 = str_replace("mp4",".mp4",$file);

                    rename(public_path().'/video/class/'.$file, public_path().'/video/class/'.$vid_name1);
                
                }
            }

            if(!strstr($file,'.avi') && !strstr($file,'.php')){

                if(strstr($file,'avi')){
                
                    $filePath = public_path().'/video/class/'.$file;

                    $vid_name1 = str_replace("avi",".avi",$file);

                    rename(public_path().'/video/class/'.$file, public_path().'/video/class/'.$vid_name1);
                
                }
            }

            if(!strstr($file,'.wmv') && !strstr($file,'.php')){

                if(strstr($file,'wmv')){
                
                    $filePath = public_path().'/video/class/'.$file;

                    $vid_name1 = str_replace("wmv",".wmv",$file);

                    rename(public_path().'/video/class/'.$file, public_path().'/video/class/'.$vid_name1);
                
                }
            }

            if(!strstr($file,'.mkv') && !strstr($file,'.php')){

                if(strstr($file,'mkv')){
                
                    $filePath = public_path().'/video/class/'.$file;

                    $vid_name1 = str_replace("mkv",".mkv",$file);

                    rename(public_path().'/video/class/'.$file, public_path().'/video/class/'.$vid_name1);
                
                }
            }
        }

        


        foreach ($videos as $key => $video) {

            
            
            if(!strstr($video->video,'.mp4')){

                $vid_name = str_replace("mp4",".mp4",$video->video);
                $video->video = $vid_name;
                $video->save();
            }

            if(!strstr($video->video,'.avi')){
                $vid_name = str_replace("avi",".avi",$video->video);
                $video->video = $vid_name;
                $video->save();
            }

            if(!strstr($video->video,'.wmv')){
                $vid_name = str_replace("wmv",".wmv",$video->video);
                $video->video = $vid_name;
                $video->save();
            }

            if(!strstr($video->video,'.mkv')){
                $vid_name = str_replace("mkv",".mkv",$video->video);
                $video->video = $vid_name;
                $video->save();
            }

        }

        $this->info('Task Completed');
    }
}
