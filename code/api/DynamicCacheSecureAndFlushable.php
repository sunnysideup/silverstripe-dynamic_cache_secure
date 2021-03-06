<?php

class DynamicCacheSecureAndFlushable extends Extension implements Flushable
{
    public function updateEnabled(&$enabled)
    {
        // Disable caching for this request if a user is logged in
        if (Member::currentUserID()) {
            $enabled = false;
        }

        // Disable caching for this request if in dev mode
        elseif (Director::isDev()) {
            $enabled = false;
        }

        // Disable caching if the request is in dev mode
        else {
            $session = Session::get_all();
            if ($session && count($session)) {
                $enabled = false;
            }
        }
    }

    public function updateCacheKeyFragments(array &$fragments)
    {
        $fragments[] = Member::currentUserID();
    }

    public static function flush()
    {
        DynamicCache::inst()->clear();
    }
}
