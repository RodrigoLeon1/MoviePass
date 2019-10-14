<?php 
    namespace DAO;
    
    use Models\Api as Api;

    class ApiDAO {

        private $url;

        public function getNowPlaying($pageNumber) {

            $api = new Api();

            $urlTemp = '';
            $urlTemp = $api->getUrl();
            $urlTemp .= $api->getSlashMovie();
            $urlTemp .= '/now_playing?' . $api->getApiToquen();
            $urlTemp .= $api->getLanguage();
            $urlTemp .= $api->getPage();
            $urlTemp .= $pageNumber;
            
            $this->url = $urlTemp;
            return $this->url;
        }

        public function getComingSoon($pageNumber) {
            
            $api = new Api();
            
            $urlTemp = '';
            $urlTemp = $api->getUrl();
            $urlTemp .= $api->getSlashMovie();
            $urlTemp .= '/upcoming?' . $api->getApiToquen();
            $urlTemp .= $api->getLanguage();
            $urlTemp .= $api->getPage();
            $urlTemp .= $pageNumber;
            
            $this->url = $urlTemp;
            return $this->url;            
        }

        public function getKeyMovieTrailer($idMovie) {

            //https://api.themoviedb.org/3/movie/301528/videos?api_key=3e5f4eb4646c2377ec6f8c3ce5f07f6b&language=en-US

            $api = new Api();
            
            $urlTemp = '';
            $urlTemp .= $api->getUrl();               
            $urlTemp .= $api->getSlashMovie();
            $urlTemp .= '/' . $idMovie . '/videos?';                      
            $urlTemp .= $api->getApiToquen();            
            $urlTemp .= $api->getLanguage();                        
            $this->url = $urlTemp;

            //Arreglar            
            $jsonVideos = file_get_contents($urlTemp);
            $arrayToDecode = ($jsonVideos) ? json_decode($jsonVideos, true) : array();
            $x = $arrayToDecode['results'];
            $p = $x[0];
            
            return $p['key'];                
        }
        
    }
 ?>