<?php

namespace OCA\Overleaf\Util;

class CurrentUser {
	static public function get() {
		if (($session = \OC::$server->getUserSession()) != null) {
			return $session->getUser();
		}
		return null;
	}

	static public function isAdmin() : bool {
		if (($user = self::get()) != null) {
			return \OC::$server->getGroupManager()->isAdmin($user->getUID());
		}
		return false;
	}
}
