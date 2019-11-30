<?php

    namespace Controllers;    
        
    use Controllers\UserController as UserController;  

    class ViewsRouterController {                

		public function goToUserPath() {
			$userController = new UserController();
			return $userController->userPath();
		}

		public function goToAdminPath() {
			$userController = new UserController();
			return $userController->adminPath();
		}

    }
?>		
        
        
        
        