<?php namespace BranMuffin\Spa\Components;

use Session;
use Cache;
use Input;
use Crypt;
use Redirect;
use Illuminate\Contracts\Encryption\DecryptException;
use October\Rain\Support\Collection;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use Auth;
use Validator;

use BranMuffin\Spa\Models\Pages;
use BranMuffin\Spa\Models\Categories;

class GetPages extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Get Pages',
            'description' => 'This how to recieve the list of pages.'
        ];
    }
    
    public function defineProperties() {
        $categories = $this->getCategories()->toArray();
        $array = [];
        foreach ($categories as &$category) {
            $array[$category['id']] = $category['title'];
        }
        return [
            'getDefaultPage' => [
                'title' => 'Get Default Page'
            ],
            'getSlugName' => [
                'title' => 'Get Slug Name'
            ],
            'getSection' => [
                'title' => 'Get Section'
            ],
            'getCategory' => [
                'title'       => 'Category',
                'type'        => 'dropdown',
                'default'     => 'all',
                'options'     => ['all'=>'All'] + $array
            ]
        ];
    }
    
    public function onRun()
    {
        $default = 'default='.$this->property('getDefaultPage').'&';
        $section = 'section='.$this->property('getSection').'&';
        $this->addJs('/spa/assets/javascript?'.$default.$section);
    }
    
    public function getSession() {
        return Session::all();
    }
    
    public function getSlugName() {
        $slugName = $this->property('getSlugName');
        return $this->param($slugName);
    }
    
    public function getSection() {
        $section = $this->property('getSection');
        return $section;
    }
    
    public function getDefaultPage() {
        $sessionPage = Session::get($this->getSection());
        if ($sessionPage) {
            $page = $sessionPage;    
        } else {
            $page = $this->property('getDefaultPage');
        }
        return $page;
    }
    
    public function getCategories() {
        return Categories::all();
    }
    
    public function onSessionPage() {
        $name = Input::get('name');
        $section = Input::get('section');
        Session::put($section, $name);
    }
    
    public function getPages() {
        if ($this->property('getCategory') != 'all') {
            $category = $this->property('getCategory');
            return Pages::whereHas('category', function ($query) use ($category) {
                $query->where('id', $category);
            })->get();
        } else {
            return Pages::all();
        }
    }
    
    public function getPage($default = null) {
        //dd($sessionPage);
        $pages = $this->getPages();
        if ($default) {
            $slugName = $default;
        } else {
            $slugName = $this->getSlugName();
        }
        $page = $pages->where('slug', $slugName)->first();
        return $page;
    }
    
    public function onImageLink() {
        $img = Input::get('img');
        $this->page['imageModal'] = $img;
        return [
        '#spaImageModal' => $this->renderPartial('@imageModal')
        ];
    }
    
}// End of PHP class