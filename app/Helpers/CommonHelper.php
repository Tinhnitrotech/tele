<?php

use App\Models\Place;
use App\Models\SystemSetting;
use App\Repositories\Staff\Person\PersonRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

if (!function_exists('getPlaceID')) {
    function getPlaceID()
    {
        $placeID = Session::get('placeID');
        return $placeID;
    }
}

if (!function_exists('checkPlaceIdError500')) {
    /**
     * @return bool
     */
    function checkPlaceIdError500()
    {
        $placeDetail = Place::where(['id' => getPlaceID(), 'active_flg' => config('constant.active')])->whereNull('deleted_at')->first();
        if(!$placeDetail) {
            return true;
        }

        return false;
    }
}

if (!function_exists('getTotalPlaceByID')) {
    function getTotalPlaceByID()
    {
        $placeId = getPlaceID();
        $totalPlace = Place::select('total_place')->where('id', $placeId)->first();
        if (!empty($totalPlace)) {
            return $totalPlace->total_place;
        }

        return 0;
    }
}

if (!function_exists('getUserLogin')) {
    function getUserLogin()
    {
        if(Auth::guard('admin')->check())
             return Auth::guard('admin')->user()->name;
        else {
            return Auth::guard('staff')->user()->name;
        }
    }
}


if (!function_exists('getAdminLogin')) {
    function getAdminLogin()
    {
        if(Auth::guard('admin')->check())
            return Auth::guard('admin')->user();
        else {
            false;
        }
    }
}


if (!function_exists('get_prefecture')) {
    function get_prefecture()
    {
        return config('constant.prefectures');
    }
}

if (!function_exists('get_prefecture_en')) {
    function get_prefecture_en()
    {
        return config('constant.prefectures_en');
    }
}

if (!function_exists('get_prefecture_person_register')) {
    function get_prefecture_person_register()
    {
        return App::getLocale() == config('constant.language_ja') ? config('constant.prefectures') : config('constant.prefectures_en');
    }
}

if(!function_exists('formatDateTime')) {
    function formatDateTime($date) {
        $tDate = strtotime($date);

            if(Session::get('language') == config('constant.language_en')) {
                return date('Y',$tDate). '-'.date('m',$tDate).'-'.date('d',$tDate).' '.date('H',$tDate).':'.date('i',$tDate);
            } elseif(Session::get('language') == config('constant.language_ja')) {
                return date('Y',$tDate). '年'.date('m',$tDate).'月'.date('d',$tDate).'日 '.date('H',$tDate).':'.date('i',$tDate);
            } else {
                return date('Y',$tDate). '年'.date('m',$tDate).'月'.date('d',$tDate).'日 '.date('H',$tDate).':'.date('i',$tDate);
            }

    }
}

if(!function_exists('formatDate')) {
    function formatDate($date) {
        $tDate = strtotime($date);

        if(Session::get('language') == config('constant.language_en')) {
            return date('Y',$tDate). '-'.date('m',$tDate).'-'.date('d',$tDate);
        } elseif(Session::get('language') == config('constant.language_ja')) {
            return date('Y',$tDate). '年'.date('m',$tDate).'月'.date('d',$tDate).'日 ';
        } else {
            return date('Y',$tDate). '年'.date('m',$tDate).'月'.date('d',$tDate).'日 ';
        }

    }
}

if(!function_exists('formatDateTimeAdmin')) {
    function formatDateTimeAdmin($date) {
        $tDate = strtotime($date);
        return date('Y',$tDate). '年'.date('m',$tDate).'月'.date('d',$tDate).'日 '.date('H',$tDate).':'.date('i',$tDate);
    }
}

if(!function_exists('formatTimeAdmin'))
{
    function formatTimeAdmin($dateTime)
    {
        return date('Y-m-d H:i', strtotime($dateTime));
    }
}

if(!function_exists('getGenderName'))
{
    function getGenderName($gender = 1)
    {
        $name = '';
        if ($gender == config('constant.male')) {
            $name = trans('common.male');
        } else {
            $name = trans('common.female');
        }

        return $name;
    }
}

if(!function_exists('getOrderPerson'))
{
    /**
     * @param int $familyId
     * @param array $familyExist
     * @param array $page
     *
     * @return int
     */
    function getOrderPerson($familyId, $familyExist, $page)
    {
        $personRepositoryy = new PersonRepository();
        $order = $personRepositoryy->countPersonByPage($familyId, $page);
        if (!in_array($familyId, $familyExist)) {
            $familyExist[] = $familyId;
            $order = (1 + $order);
        } else {
            $order++;
        }

        return $order;
    }
}

if (!function_exists('get_prefecture_name')) {
    function get_prefecture_name($prefecture_id)
    {
        return config('constant.prefectures.'.$prefecture_id);
    }
}

if (!function_exists('get_prefecture_name_en')) {
    function get_prefecture_name_en($prefecture_id)
    {
        return config('constant.prefectures_en.'.$prefecture_id);
    }
}

if (!function_exists('get_prefecture_id_by_name')) {
    function get_prefecture_id_by_name($prefecture_name)
    {
        foreach (config('constant.prefectures') as $key => $value) {
            if($value == trim($prefecture_name)) {
                return $key;
            }
        }
    }
}

if (!function_exists('get_prefecture_id_by_name_en')) {
    function get_prefecture_id_by_name_en($prefecture_name)
    {
        foreach (config('constant.prefectures_en') as $key => $value) {
            if($value == trim($prefecture_name)) {
                return $key;
            }
        }
    }
}

if (!function_exists('getFamilyCode')) {
    /**
     * @param int $placeId
     * @param int $familyId
     *
     * @return string $familyCode
     */
    function getFamilyCode($placeId, $familyId)
    {
        $placeCodeId = getIdCode($placeId);
        $familyCodeId = getIdCode($familyId);

        $familyCode = $placeCodeId.'-'.$familyCodeId;

        return $familyCode;
    }
}

if (!function_exists('getIdCode')) {
    /**
     * @param int $id
     *
     * @return string $code
     */
    function getIdCode($id)
    {
        $code = rand(0,999);
        if (!empty($id)) {
            if ($id < 10) {
                $code = '00'.$id;
            } else if ($id >= 10 && $id < 100) {
                $code = '0'.$id;
            } else {
                $code = $id;
            }
        }

        return $code;
    }
}

if (!function_exists('changeFormatDateTime')) {
    /**
     * @param $data
     */
    function changeFormatDateTime($data, $language, $format = 'LL')
    {
        return Carbon::parse($data)->locale($language)->isoFormat($format);
    }
}

if (!function_exists('oldDataCustom')) {
    function oldDataCustom($key, $aData)
    {
        if(isset($aData) && isset($aData[$key])) {
            return $aData[$key];
        }
        return old($key);
    }
}

if (!function_exists('routeByPlaceId')) {
    /**
     * @param string $routeName
     * @param array $param
     *
     * @return string route
     */
    function routeByPlaceId($routeName, $param = [])
    {
        $param = setPramUrl($param);

        return route($routeName, $param);
    }
}

if (!function_exists('redirectRouteByPlaceId')) {
    /**
     * @param string $routeName
     * @param array $param
     *
     * @return string route
     */
    function redirectRouteByPlaceId($routeName, $param = [], $message = null)
    {
        $param = setPramUrl($param);

        if (!empty($message)) {
            return redirect()->route($routeName, $param)->with('message', $message);
        }

        return redirect()->route($routeName, $param);
    }
}

if (!function_exists('setPramUrl')) {
    /**
     * @param array $param
     * @return array $param
     */
    function setPramUrl($param = [])
    {
        $placeId = getPlaceID();
        if (!empty($placeId)) {
            if (!empty($param) && sizeof($param) > 0) {
                $param['hinan'] = $placeId;
            } else {
                $param = ['hinan' => $placeId];
            }
        }

        return $param;
    }
}

if (!function_exists('getPlaceName')) {
    function getPlaceName()
    {
        $placeId = getPlaceID();
        $place = Place::find($placeId);
        $placeName = $place ? getTextChangeLanguage($place->name, $place->name_en) : '';
        return $placeName;
    }
}

if (!function_exists('getCurrentDateTime')) {
    function getCurrentDateTime()
    {
        $now = date('Y/m/d H:i:s');
        $datetime = formatDateTime($now);
        return $datetime;
    }
}

if (!function_exists('getCurrentDateTimeAdmin')) {
    function getCurrentDateTimeAdmin()
    {
        $now = date('Y/m/d H:i:s');
        $datetime = formatDateTimeAdmin($now);
        return $datetime;
    }
}

if (!function_exists('handlePaginate')) {
    function handlePaginate($items, $request)
    {
        $page = isset($request->page) ? $request->page : 1;
        $perPage = config('constant.paginate_admin_top');
        $offset = ($page * $perPage) - $perPage;
        $entries = new LengthAwarePaginator(
            array_slice($items, $offset, $perPage, true),
            count($items),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        return $entries;
    }
}

if (!function_exists('getSystemName')) {
    function getSystemName()
    {
        $systemName = null;
        $setting = SystemSetting::first();
        if($setting) {
            $systemName = Session::get('language') == config('constant.language_en') ?  $setting->system_name_en : $setting->system_name_ja;
        }
        return  $systemName;

    }
}

if (!function_exists('getDisclosureInfo')) {
    function getDisclosureInfo()
    {
        $disclosureInfo = null;
        $setting = SystemSetting::first();
        if($setting) {
            $disclosureInfo = Session::get('language') == config('constant.language_en') ?  $setting->disclosure_info_en : $setting->disclosure_info_ja;
        }
        return  $disclosureInfo;
    }
}

if (!function_exists('getSystemNameAdmin')) {
    function getSystemNameAdmin()
    {
        $systemName = null;
        $setting = SystemSetting::first();
        if($setting) {
            $systemName = $setting->system_name_ja;
        }
        return  $systemName;

    }
}

if (!function_exists('getTypeName')) {
    function getTypeName()
    {
        $TypeName = null;
        $setting = SystemSetting::first();
        if($setting) {
            $TypeName = Session::get('language') == config('constant.language_en') ?  $setting->type_name_en : $setting->type_name_ja;
        }
        return  $TypeName;
    }
}

if (!function_exists('getFooter')) {
    function getFooter()
    {
        $setting = SystemSetting::first();
        if($setting) {
            return $setting->footer;
        }
        return null;

    }
}

if (!function_exists('getScaleMap')) {
    function getScaleMap()
    {
        $setting = SystemSetting::first();
        if($setting) {
            return $setting->map_scale;
        }
        return 17;

    }
}

if (!function_exists('getTextLanguage')) {
    function getTextChangeLanguage($ja, $en)
    {
        return (App::getLocale() == config('constant.language_en') && !is_null($en)) ? $en : $ja;
    }
}

if (!function_exists('getChangeAddressName')) {
    function getChangeAddressName($prefecture_id, $address, $prefecture_en, $address_en)
    {
        return (App::getLocale() == config('constant.language_en') && !is_null($prefecture_en) && !is_null($address_en)) ? config('constant.prefectures_en.'.$prefecture_en) . ' ' . $address_en :   config('constant.prefectures.'.$prefecture_id) . ' ' . $address;
    }
}

if (!function_exists('getTextLanguageAddress')) {
    function getTextLanguageAddress($ja, $en)
    {
        return (App::getLocale() == config('constant.language_ja') ? $ja : ( !is_null($en) ? $en : ''));
    }
}

if (!function_exists('getTextLanguage')) {
    function getTextLanguage($lang)
    {
        if ($lang == config('constant.language_en')) {
            if (App::getLocale() == config('constant.language_ja')) {
                return config('constant.ja_language_english');
            } else {
                return config('constant.en_language_english');
            }
        } else {
            if (App::getLocale() == config('constant.language_ja')) {
                return config('constant.ja_language_japan');
            } else {
                return config('constant.en_language_japan');
            }
        }
    }
}

if (!function_exists('getLatitudeDefault')) {
    function getLatitudeDefault()
    {
        $setting = SystemSetting::first();
        if($setting && $setting->longitude) {
            return $setting->latitude;
        }
        return config('constant.lat_tokyo');
    }
}

if (!function_exists('getLongitudeDefault')) {
    function getLongitudeDefault()
    {
        $setting = SystemSetting::first();
        if($setting && $setting->longitude) {
            return $setting->longitude;
        }
        return config('constant.lng_tokyo');
    }
}

if (!function_exists('getGenderIdByName')) {
    function getGenderIdByName($genderName)
    {
        $id = null;
        if (trim($genderName) == trans('common.male')) {
            $id = config('constant.male');
        } else {
            $id = config('constant.female');
        }
        return $id;
    }
}

if (!function_exists('encryptData')) {
    function encryptData($data)
    {
        $secret_key ='!kQm*fF3p';
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($data, $cipher, $secret_key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $secret_key, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        return $ciphertext;
    }
}

if (!function_exists('decryptData')) {
    function decryptData($data)
    {
        $secret_key ='!kQm*fF3p';
        $c = base64_decode($data);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $secret_key, $options=OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $secret_key, $as_binary=true);
        if (hash_equals($hmac, $calcmac))
        {
            return $original_plaintext;
        }
        return  false;
    }
}

if (!function_exists('handleFileNameQRCode')) {
    function handleFileNameQRCode($name)
    {
        $name = preg_replace('~\s+~u', '_', $name);
        $name = str_replace("\\", "", $name);
        $name = str_replace("/", "", $name);
        $name = str_replace(":", "", $name);
        $name = str_replace("*", "", $name);
        $name = str_replace("?", "", $name);
        $name = str_replace("\"", "", $name);
        $name = str_replace("<", "", $name);
        $name = str_replace(">", "", $name);
        $name = str_replace("|", "", $name);
        return $name;
    }
}

if (!function_exists('handleFileNamePerson')) {
    function handleFileNamePerson($name)
    {
        $name = preg_replace('~\s+~u', ' ', $name);
        $name = str_replace("\\", "", $name);
        $name = str_replace("/", "", $name);
        $name = str_replace(":", "", $name);
        $name = str_replace("*", "", $name);
        $name = str_replace("?", "", $name);
        $name = str_replace("\"", "", $name);
        $name = str_replace("<", "", $name);
        $name = str_replace(">", "", $name);
        $name = str_replace("|", "", $name);
        return $name;
    }
}

if (!function_exists('handleAddressCSV')) {
    function handleAddressCSV(string $address)
    {
        if (preg_match('@^(.{2,3}?[都道府県])(.+?郡.+?[町村]|.+?市.+?区|.+?[市区町村])(.+)@u', $address, $matches) !== 1) {
            return $address;
        }
        $address = $matches[2] . $matches[3];
        return $address;
    }
}

if (!function_exists('handleTelQRCode')) {
    function handleTelQRCode($tel)
    {
        $tel = str_replace('-','', $tel);
        $tel = preg_replace('~\s+~u', '', $tel);
        $tel = str_replace("\\", "", $tel);
        $tel = str_replace("/", "", $tel);
        $tel = str_replace(":", "", $tel);
        $tel = str_replace("*", "", $tel);
        $tel = str_replace("?", "", $tel);
        $tel = str_replace("\"", "", $tel);
        $tel = str_replace("<", "", $tel);
        $tel = str_replace(">", "", $tel);
        $tel = str_replace("|", "", $tel);
        return $tel;
    }
}

if (!function_exists('checkUserAgent')) {
    function checkUserAgent()
    {
        $userAgent = !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
        $is_ios = 1;
        if(stripos($userAgent,'ios') !== false) {
            $is_ios = 1;
        }

        elseif(stripos($userAgent,'android') !== false) {
            $is_ios = 2;
        }

        elseif (stripos($userAgent, 'Chrome') !== false)
        {
            $is_ios = 2;
        }

        elseif (stripos($userAgent, 'Safari') !== false)
        {
            $is_ios = 1;
        }

        elseif (stripos($userAgent, 'iPad') !== false)
        {
            $is_ios = 1;
        }

        elseif(stristr($_SERVER['HTTP_USER_AGENT'], 'Mozilla/5.0(iPad;')) {
            $is_ios = 1;
        }

        elseif(strstr($userAgent, " AppleWebKit/") && strstr($userAgent, " Safari/") && !strstr($userAgent, " CriOS"))
        {
            $is_ios = 1;
        }

        //Detect special conditions devices
        $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
        $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
        $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
        $webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

        //do something with this information
        if( $iPod || $iPhone ){
            $is_ios = 1;
        }else if($iPad){
            $is_ios = 1;
        }else if($Android){
            $is_ios = 2;
        }else if($webOS){
            $is_ios = 1;
        }

        elseif (stripos($userAgent, 'OS') !== false)
        {
            $is_ios = 1;
        }

        elseif (stripos($userAgent, 'Mac') !== false)
        {
            $is_ios = 1;
        }

        elseif (stripos($userAgent, 'CriOS') !== false)
        {
            $is_ios = 1;
        }

        elseif (stripos($userAgent, 'Macintosh') !== false)
        {
            $is_ios = 1;
        }

        return $is_ios;
    }
}




