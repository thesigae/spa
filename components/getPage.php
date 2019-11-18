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
        return [
            'getSlugName' => [
                'title' => 'Get Slug Name',
            ]
        ];
    }
    
    public function getSlugName() {
        return 'something';//$this->property('getSlugName');
    }
    
    public function getPages() {
        return Pages::all();
    }
    
}// End of PHP class