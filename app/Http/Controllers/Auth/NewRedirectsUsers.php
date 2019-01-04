<?php
/**
 * Created by PhpStorm.
 * User: mulaffer
 * Date: 11/23/16
 * Time: 1:03 AM
 */

namespace App\Http\Controllers\Auth;


trait NewRedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}