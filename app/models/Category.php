<?php

class Category extends BaseModel
{
    /**
     * The database collection
     *
     * @var string
     */
    protected $collection = 'categories';

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = array(
        'name' => 'required',
    );

    /**
     * Setable with the setAttributes method
     *
     * @var array
     */
    public $massAssignment = array(
        'name','description','image'
    );

    /**
     * Path where category images will be stored
     *
     * @var string
     */
    private $images_path = '../public/assets/img/categories';

    /**
     * Attach an UploadedFile as the category image
     * 
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $image_file
     * @return bool
     */
    public function attachUploadedImage( $image_file )
    {
        $path = app_path().'/'.$this->images_path;
        $filename = $this->id.'.jpg';

        $old = umask(0); 

        if ( ! is_dir($path) )
            mkdir($path, 0777, true);
        
        $image_file->move($path, $filename);
        try{
            chmod($path.'/'.$filename, 0775);    
        }catch( Exception $e){}

        umask($old); 

        $this->image = $filename;
        
        return $this->save();
    }

    /**
     * Return image URL
     *
     * @return string
     */
    public function imageUrl()
    {
        if( $this->image )
        {
            return URL::to('assets/img/categories/'.$this->image);
        }
        else
        {
            return URL::to('assets/img/categories/default.png');
        }
    }

    /**
     * Clear the "category exists" cache values. Since it should
     * exist from now and beyond.
     *
     * @return bool
     */
    public function save()
    {
        if(Cache::get('category_'.$this->name.'_exists'))
            Cache::forget('category_'.$this->name.'_exists');

        return parent::save();
    }

    /**
     * Determines if a category exists or not. This function uses
     * cached values to be faster when checking a mass amount of
     * categories. I.E.: During CSV file importing.
     * 
     * @param string $name
     * @return bool
     */
    public static function exists( $name )
    {
        // Check the cache if this has already been compared within 2 minutes
        $category_exists = Cache::remember('category_'.$name.'_exists', 2, function() use ( $name )
        {
            $category = Category::first( array('name'=>$name) );
            $cache_value = ($category) ? 1 : -1;
            return $cache_value;
        });

        return ($category_exists > 0);
    }

    /**
     * Activate the category, so it will be show's in home
     *
     * @param string $name
     * @return void
     */
    public static function activate( $name )
    {
        // Check the cache if this has already been activated within 2 minutes
        Cache::remember('category_'.$name.'_activated', 2, function() use ( $name )
        {
            $category = Category::first(array('name'=>$name));
            if($category && (! $category->active))
            {
                $category->active = true;
                $category->save();
            }
        });
    }
}