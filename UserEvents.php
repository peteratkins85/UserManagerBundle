<?php
/**
 * Created by PhpStorm.
 * User: peteratkins
 * Date: 23/04/2016
 * Time: 18:59
 */

namespace Oni\UserManagerBundle;


final class UserEvents {

	const USER_EVENT = 'user.event';

	/**
	 * New User Event
	 */
	const USER_ADD = 'oni.user.add';

	/**
	 * Edit User Event
	 */
	const USER_EDIT = 'oni.user.edit';

	/**
	 * Edit User Event
	 */
	const USER_DELETE = 'oni.user.delete';

}