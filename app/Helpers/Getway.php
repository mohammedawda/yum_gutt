<?php

if (!function_exists('loadGetway')) {
    function loadGetway(string $servicesName)
    {
        $class_name = "\\getways\\$servicesName\\EntryPoint"; // Adjusted namespace concatenation
        try {
            if (class_exists($class_name)) {
                return new $class_name;
            } else {
                throw new \Exception(__('api.getway_not_found'));
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage()); // Proper exception handling
        }
//        switch ($servicesName) {
//            case 'company':
//                return new \getways\company\EntryPoint;
//                break;
//            case 'delegates':
//                return new \getways\delegates\EntryPoint;
//                break;
//            case 'families':
//                return new \getways\families\EntryPoint;
//                break;
//            case 'products':
//                return new \getways\products\EntryPoint;
//                break;
//            case 'stores':
//                return new \getways\stores\EntryPoint;
//                break;
//            case 'users':
//                return new \getways\users\EntryPoint;
//                break;
//            case 'cores':
//                return new \getways\cities\EntryPoint;
//                break;
//            default:
//                throw (new \Exception(__('api.getway_not_found')));
//                break;
//        }
    }
}
