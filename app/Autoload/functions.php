<?php 
use App\Models\Option;
use App\Models\Menu;
use App\Models\User;
use App\Models\Device;
use App\Models\App;
use App\Models\Template;
use App\Models\Smstransaction;
use App\Models\Contact;
use Carbon\Carbon;

if (!function_exists('transactionCharge')) {
    /**
     *  returnn transaction charge for sms
     * @param string $type
     * @return double
     */
    function transactionCharge($type)
    {
    	if ($type == 'custom_message') {
    		return 1;
    	}
    	elseif ($type == 'bulk_message') {
    		return 1;
    	}
    	elseif ($type == 'scheduled_message') {
    		return 1;
    	}

    }

}

if (!function_exists('badge')) {
    /**
     *  print badge
     * @param string $status
     * @return array
     */
    function badge($status)
    {
    	return $classes = [
    		0 => ['class' => 'badge-danger', 'text' => 'Rejected'],
    		1 => ['class' => 'badge-success', 'text' => 'Accepted'],
    		2 => ['class' => 'badge-danger', 'text' => 'Pending'],
    		'pending' => ['class' => 'badge-warning'],
    		'delivered' => ['class' => 'badge-success'],
    		'rejected' => ['class' => 'badge-danger'],
    	][$status];
    }

}

if (!function_exists('amount_format')) {
    /**
     *  format amount
     * @param string $amount
     * @param string $icon_type
     * @return string
     */
    function amount_format($amount=0, $icon_type = 'name')
    {
    	$currency = get_option('base_currency',true);
    	if ($icon_type == 'name') {
    		$currency = $currency->position == 'right' ? $currency->name.' '.number_format($amount,2)  :  number_format($amount,2).' '.$currency->name;
    	}
    	elseif ($icon_type == 'both') {
    		$currency = $currency->icon.number_format($amount,2).' '.$currency->name;
    	}
    	else{
    		$currency = $currency->position == 'right' ? number_format($amount,2).$currency->icon : $currency->icon.number_format($amount,2);
    	}

    	return $currency;
    }

}

if (!function_exists('planData')) {
    /**
     *  plan data
     * @param string $title
     * @param string or bool value
     * @return array
     */

    function planData($title, $value)
    {
    	if ($title == 'chatbot') {
    		$data['is_bool'] = true;
    		$data['title'] = $title;
    		$data['value'] = filter_var($value,FILTER_VALIDATE_BOOLEAN);

    		return $data;
    	}
    	elseif ($title == 'bulk_message') {
    		$data['is_bool'] = true;
    		$data['title'] = $title;
    		$data['value'] = filter_var($value,FILTER_VALIDATE_BOOLEAN);
    		return $data;
    	}
    	elseif ($title == 'schedule_message') {
    		$data['is_bool'] = true;
    		$data['title'] = $title;
    		$data['value'] = filter_var($value,FILTER_VALIDATE_BOOLEAN);
    		return $data;
    	}
    	elseif ($title == 'template_message') {
    		$data['is_bool'] = true;
    		$data['title'] = $title;
    		$data['value'] = filter_var($value,FILTER_VALIDATE_BOOLEAN);
    		return $data;
    	}
    	elseif ($title == 'access_chat_list') {
    		$data['is_bool'] = true;
    		$data['title'] = $title;
    		$data['value'] = filter_var($value,FILTER_VALIDATE_BOOLEAN);
    		return $data;
    	}
    	elseif ($title == 'access_group_list') {
    		$data['is_bool'] = true;
    		$data['title'] = $title;
    		$data['value'] = filter_var($value,FILTER_VALIDATE_BOOLEAN);
    		return $data;
    	}
    	else{
    		if ($value == -1) {
    			$value = 'unlimited';
    		}
    		$data['value'] = null;
    		$data['is_bool'] = false;
    		$data['title'] = $title. ' ('.$value.')';
    		return $data;
    	}

    }

}


if (!function_exists('getUserPlanData')) {
    /**
     * get user plan data
     * @param string $key
     * @param int $user_id nullable
     * @return boolean
     */

    function getUserPlanData($key,$user_id = null)
    {
    	$user = $user_id != null ? User::where('id',$user_id)->where('status',1)->first() : Auth::user();
    	if ($user->will_expire < now()) {

    		return false;
    	}

    	$plan = json_decode($user->plan);

    	$filterKey =  $plan->$key ?? false;
    	$filterKey = filterPlatData($key,$filterKey);
    	if ($filterKey['is_bool'] == false) {
    		if ($filterKey['value'] == 'unlimited') {
    			return true;
    		}
    		else{
    			if ($key == 'device_limit') {
    				$rows = Device::where('user_id',$user->id)->count();
    			}
    			elseif ($key == 'apps_limit') {
    				$rows = App::where('user_id',$user->id)->count();
    			}
    			elseif ($key == 'template_limit') {
    				$rows = Template::where('user_id',$user->id)->count();
    			}
    			elseif ($key == 'messages_limit') {
    				$rows = Smstransaction::where('user_id',$user->id)
    				->whereYear('created_at', Carbon::now()->year)
    				->whereMonth('created_at', Carbon::now()->month)
    				->count();
    			}
    			elseif ($key == 'contact_limit') {
    				$rows = Contact::where('user_id',$user->id)->count();
    			}


    			if ($rows >= (int)$filterKey['value']) {
    				return false;
    			}
    			else{
    				return true;
    			}
    		}


    	}
    	return $filterKey['value'];

    }


}

if (!function_exists('filterPlatData')) {
    /**
     * get filtered plan data
     * @param string $title
     * @param string $value
     * @return array
     */
    function filterPlatData($title, $value)
    {
    	if ($title == 'chatbot') {
    		$data['is_bool'] = true;
    		$data['value'] = filter_var($value,FILTER_VALIDATE_BOOLEAN);

    		return $data;
    	}
    	elseif ($title == 'bulk_message') {
    		$data['is_bool'] = true;
    		$data['value'] = filter_var($value,FILTER_VALIDATE_BOOLEAN);
    		return $data;
    	}
    	elseif ($title == 'schedule_message') {
    		$data['is_bool'] = true;
    		$data['value'] = filter_var($value,FILTER_VALIDATE_BOOLEAN);
    		return $data;
    	}
    	elseif ($title == 'template_message') {
    		$data['is_bool'] = true;
    		$data['value'] = filter_var($value,FILTER_VALIDATE_BOOLEAN);
    		return $data;
    	}
    	elseif ($title == 'access_chat_list') {
    		$data['is_bool'] = true;
    		$data['value'] = filter_var($value,FILTER_VALIDATE_BOOLEAN);
    		return $data;
    	}
    	elseif ($title == 'access_group_list') {
    		$data['is_bool'] = true;
    		$data['value'] = filter_var($value,FILTER_VALIDATE_BOOLEAN);
    		return $data;
    	}
    	else{
    		if ($value == -1) {
    			$data['value'] = 'unlimited';
    		}
    		else{
    			$data['value'] = (int)$value;
    		}
    		$data['is_bool'] = false;
    		return $data;
    	}

    }

}



if (!function_exists('get_option')) {
    /**
     * Get Settings From Database
     * @param $key
     * @param bool $decode
     * @param $locale
     * @return mixed
     */
    function get_option($key, bool $decode = false, $locale = false, $associative = false): mixed
    {
        if ($locale == true) {
           $cacheKey = $key.$locale;
        }
        else{
            $cacheKey = $key;
        }

        $cacheKey = 
    	$option = cache_remember($cacheKey, function () use ($key, $locale) {
    		$row= Option::query();
    		if ($locale != false) {
    			$row= $row->where('lang',current_locale());
    		}	
    		return  $row = $row->where('key',$key)->first();

    	});

    	return $decode ? json_decode($option->value ?? '') : $option->value ?? null;
    }
}

if (!function_exists('cache_remember')) {
    /**
     * This function will remember the cache
     * @param string $key
     * @param callable $callback
     * @param integer $ttl
     * @return mixed
     */
    function cache_remember(string $key, callable $callback, int $ttl = 1800): mixed
    {
    	return cache()->remember($key, env('CACHE_LIFETIME', $ttl), $callback);
    }
}

if (!function_exists('current_locale')) {
    /**
     * Get Current Locale
     * Return current locale|lang
     * @return string|null
     */
    function current_locale()
    {
    	return app()->getLocale();
    }
}

if (!function_exists('PrintMenu')) {
    /**
     * Get Dynamic Menu From Database
     * @param $position
     * @param string $path
     * @return Factory|\Illuminate\Contracts\View\View|Application
     */
    function PrintMenu($position, string $path = 'frontend.menu')
    {
    	$locale = current_locale();

    	$data = cache_remember($position . $locale, function () use ($position, $locale) {
    		$menus = Menu::where('position', $position)->where('lang', $locale)->first();
    		$data['data'] = json_decode($menus->data ?? '');
    		$data['name'] = $menus->name ?? '';
    		return $data;
    	});


    	return view($path . '.main-menu', compact('data'));
    }
}

if (!function_exists('filterXss')) {
    /**
     * filter script code
     * @param $string
     */
function filterXss($string=''){

    $string = str_replace('</script>', "", $string);
    $string = str_replace('<script>', "", $string);

    return $string;
}

}

?>