<?php
/**
 * Created by Arman Sheikh
 * Braintree SDK 3.27.0
 * Date: 1/26/2018
 * Time: 8:14 PM
 */
namespace  App\Libraries;

//defined('BASEPATH') OR exit('No direct script access allowed');

//require_once 'braintree_sdk/lib/Braintree.php';

class Helper
{

    /**
     * Get 1 year month from today
     * @return array of year months
     */
    public static function getYearMonthsFromToday()
    {
        $current_month = date('n');
        $months = [];

        for($i=1;$i<=12;$i++)
        {
            $months[$current_month] = date('M', mktime(0, 0, 0, $current_month+1, 0, 0));
            if($current_month == 12) {
                $current_month = 1;
                $months[$current_month] = date('M', mktime(0, 0, 0, $current_month+1, 0, 0));
                $i++;
            }
            if($current_month == 1){
                $current_month = 12;
                $months[$current_month] = date('M', mktime(0, 0, 0, $current_month+1, 0, 0));
                $i++;
            }

            $current_month--;
        }
        return $months;
    }

    /**
     * Get 1 year month from today
     * @return days array
     */
    public static function getMonthDaysFromToday()
    {
        $month_days = [];
        for($i=0; $i<=30; $i++) {
            $date = date('d', strtotime("-$i days", strtotime(date('Y-m-d'))));
            $month_days[$date] = $date;

        }

        return $month_days;
    }

    /**
     * Get 1 week days from today
     * @return days array
     */
    public static function getWeekDaysFromToday()
    {
        $days   = [];
        $period = new \DatePeriod(
            new \DateTime(), // Start date of the period
            new \DateInterval('P1D'), // Define the intervals as Periods of 1 Day
            6 // Apply the interval 6 times on top of the starting date
        );

        foreach ($period as $day)
        {
            $day_index = $day->format('d');
            $days[$day_index] = $day->format('D');
        }
        return $days;
    }

    /**
     * Get 24 hours from current hour
     * @return hours array
     */
    public static function getHoursFromToday()
    {
        $day_hours = [];
        for ($i = 0; $i <= 24; $i++) {
            $date = date('H', strtotime("-$i hour", strtotime(date('Y-m-d H:i'))));
            $day_hours[$date] = $date;

        }
        return $day_hours;
    }

    public static function getUniqueFilename($mediaObj, $mediaSaveName = 'media', $mediaPath = '/uploads/')
    {
        $mediaPath = public_path() . $mediaPath;
        $extension = $mediaObj->getClientOriginalExtension();
        $uniqueSaveName = "$mediaSaveName-" . time() . '_' . rand() . '.' . $extension;

        while (file_exists($mediaPath . $uniqueSaveName)) {
            $uniqueSaveName = "$mediaSaveName-" . time() . '_' . rand() . '.' . $extension;
        }

        return $uniqueSaveName;
    }

    public static function uploadFile($obj_image, $title = 'media', $image_path = '/uploads/', $thumbnail = FALSE){

        $uniqueName = self::getUniqueFilename($obj_image, $title , $image_path);

        $destinationPath = public_path($image_path);

        if (!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }

        $imagePath = $destinationPath . $uniqueName;
        $obj_image->move($destinationPath, $uniqueName);

        if($thumbnail){
//             thumbnail($upload_path,$filename,$ext,$width,$height)
            self::thumbnail($image_path,$uniqueName,300,300);
        }


        return $uniqueName;
    }

    public static function thumbnail($upload_path,$filename,$width,$height){
        $resizeWidth       = $width;
        $resizeHeight      = $height;
        Image::make(public_path($upload_path . "$filename"))
            ->resize($resizeWidth, $resizeHeight,function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path($upload_path."thumb_$filename") );
    }

    public static function getTwoPartName($name){
        $nameExploded = explode(' ', $name);

        $twoPartName = [];
        if(isset($nameExploded[1])){
            $twoPartName['first_name'] = $nameExploded[0];

            array_splice($nameExploded, 0, 1); /*Removing first index */
            $lastName = implode(' ', $nameExploded);
            $twoPartName['last_name'] = $lastName;
        }else{
            $twoPartName['first_name'] = $name;
            $twoPartName['last_name'] = "";
        }
        return $twoPartName;
    }

    public  static function jsond($array,$title = ""){
        echo "<pre>$title<br><br>";
        echo json_encode($array);
        echo "<br><br>";
        die;
    }

    public  static function pd($array,$title = ""){
        echo "<pre>$title<br><br>";
        print_r($array);
        echo "<br><br>";
        die;
    }

    public  static function p($array,$title = ""){
        echo "<pre>$title<br><br>";
        print_r($array);
        echo "<br><br>";
    }

    public  static function vd($array,$title = ""){
        echo "<pre>$title<br><br>";
        var_dump($array);
        echo "<br><br>";
        die;
    }

    public  static function v($array,$title = ""){
        echo "<pre>$title<br><br>";
        var_dump($array);
        echo "<br><br>";
    }

    public static function indexArrayWithElementValue($arr , $indexCol = 'id'){
        $parsedArr = [];
        foreach ($arr as $key => $item) {       /*Parsing PK based index + Setting $subCatIds*/
            $parsedArr[$item[$indexCol]] = $item;
        }
        return $parsedArr;
    }

    public static function mergeArrayWithElementValue ($baseArr, $baseArrCol, $childArr , $childCol , $mergeName){
        $parsedArr2 = self::indexArrayWithElementValue($childArr,$childCol);

        foreach ($baseArr as $key => $item) {
            $baseArr[$key][$mergeName] = $parsedArr2[$item[$baseArrCol]];
        }
        return $baseArr;
    }

    public static function uriSegment($uri,$key){
        $uri = explode('/',$uri);
        if(in_array($key,$uri )){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}



