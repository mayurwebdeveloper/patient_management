<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\Setting;
use App\Models\Speciality;
use App\Models\WorkPlace;

class Helper {

    public static function docfileType($fileName,$module='slider')
    {
        $videoExtensions = ['mp4', 'avi', 'webm', '3gp', 'mkv', 'wmv'];
        $documentExtensions = ['doc', 'docx', 'pdf'];
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Get the file extension
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Check if it's a video
        if (in_array($fileExtension, $videoExtensions)) {
            return '<a href="' . asset("images/".$module."/documents/" . $fileName) . '" target="_blank" rel="noopener noreferrer">"'. $fileName .'"</a>';
        }


        // Check if it's a document
        if (in_array($fileExtension, $documentExtensions)) {
             return '<a href="' . asset("images/".$module."/documents/" . $fileName) . '" target="_blank" rel="noopener noreferrer">"'. $fileName .'"</a>';
        }


        // Check if it's an image
        if (in_array($fileExtension, $imageExtensions)) {
            return '<a href="' . asset("images/".$module."/documents/" . $fileName) . '" target="_blank" rel="noopener noreferrer"><img src="' . asset("images/".$module."/documents/" . $fileName) . '" width="100px" height="100px" alt="document-img"> </a>';
        }

        // Default case (neither document nor image)
        return '';
    }


    public static function expiryDate($date) {
        // Get the current date
        $currentDate = date('Y-m-d');
    
        // Convert input date and current date to DateTime objects
        $inputDateTime = new \DateTime($date);
        $currentDateTime = new \DateTime($currentDate);
    
        // Compare the two dates
        $dateDifference = $inputDateTime->diff($currentDateTime);
    
        // Check if the input date is equal to the current date
        if ($dateDifference->days == 0) {
            return "expired";
        } else {
            return $dateDifference->days . " Days left";
        }
    }


    public static function formatDate($date, $formatString) {
      
        // Check if $date is a string
        if (is_string($date)) {
            // Convert string to a DateTime object using strtotime() or Carbon
            return date($formatString, strtotime($date));
        } else {
            // $date is already a DateTime object
            return $date->format($formatString);
        }

    }

    public static function userAccessOr(...$permissions) {

        $access = false;
        foreach ($permissions as $permission) {
            if (auth()->user()->can(trim($permission, "'"))) {
                $access = true;
                break;
            }
        }
        return $access;
    }
     

    public static function getNotificationCount() {
        return Notification::where('mark',1)->count();
    }

    public static function getNotifications($limit = 3) {
        return Notification::orderBy('issue_date', 'desc')->take($limit)->get();
    }

    public static function appSetting($key = '') {
        return Setting::where('key',$key)->first()->value ?? "";
    }


    public static function getTypes() {

        $results = WorkPlace::where('status', 1)->get();
        $types = [];

        foreach ($results as $result) {
            $types[] = $result->title; 
        }
        return $types;
    }

    public static function getSectors() {
        return ['government','private'];
    }


    public static function getSpecialities() {

        $results = Speciality::where('status', 1)->get();
        $specialities = [];

        foreach ($results as $result) {
            $specialities[] = $result->title; 
        }

        return $specialities;
    }

}