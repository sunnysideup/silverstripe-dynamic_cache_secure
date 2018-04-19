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

        // Disable caching for this request if we have a message to display
        // or the request shouldn't be cached for other reasons
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
