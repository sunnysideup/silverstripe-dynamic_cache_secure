<?php

class CacheCustomisation extends DynamicCacheExtension implements flushable {

    public function updateEnabled(&$enabled) {
        
        // Disable caching for this request if a user is logged in
        if (Member::currentUserID()) {
            $enabled = false;
        }

        // Disable caching for this request if in dev mode
        elseif (Director::isDev()) {
            $enabled = false;
        }

        // If there is session data then lets not go there ... 
        else {
            $session = Session::get_al();
            if($session && count($session)) {
                $enabled = false;
            }
        }
    }

    public static function flush() {
        DynamicCache::inst()->clear();
    }
}
