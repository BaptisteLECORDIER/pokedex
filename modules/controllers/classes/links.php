<?php
    class Links {

        protected $home                     ;
        protected $error404                 ;
        protected $path_to_controller_pages ;
        protected $path_to_view_pages       ;

        public function createRouter () {

            if (isset ($_GET['page'])) {

                $directory = $this -> path_to_controller_pages;
                $scanned_directory = array_diff (scandir ($directory), array ('..', '.'));
                $include404 = true;

                foreach ($scanned_directory as $link) {
                    if (str_contains ($link, '.php') && ($_GET['page'].".php") == $link) {

                        include_once(($this -> path_to_controller_pages).$link);
                        $include404 = false;
                        break;

                    }
                }
                if ($include404) {

                    include_once(($this -> path_to_controller_pages).($this -> error404).'.php');

                }
            } else {

                include_once(($this -> path_to_controller_pages).($this -> home).'.php');

            }

        }

        public function __construct(string $home, int $error404, string $path_to_controller_pages, string $path_to_view_pages) {

            $this -> home                     = $home                     ;
            $this -> error404                 = $error404                 ;
            $this -> path_to_controller_pages = $path_to_controller_pages ;
            $this -> path_to_view_pages       = $path_to_view_pages       ;
            
        }
    }



    
?>