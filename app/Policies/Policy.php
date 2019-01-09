<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;


/**
* three value will be mentioned
* 1. true -> pass
* 2. flase -> refuse
* 3. decide by other policy
**/
class Policy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function before($user, $ability)
	{
	    // if ($user->isSuperAdmin()) {
	    // 		return true;
	    // }
        if($user->can('manage_contents')){
            return true;
        }
	}
}