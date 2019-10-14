<?php

    namespace DAO;

    use Models\Movie as Movie;

    class MovieDAO
    {

        private $movieList = array();

        public function add(Movie $movie)
        {
            $this->retrieveData();
            array_push($this->movieList, $movie);
            $this->saveData();
        }

        public function getAll()
        {
            $this->retrieveData();
            return $this->movieList;
        }

        private function saveData()
        {
            $arrayToEncode = array();

            foreach ($this->movieList as $movie) {
                $valuesArray["popularity"] = $movie->getPopularity();
                $valuesArray["vote_count"] = $movie->getVoteCount();
                $valuesArray["video"] = $movie->getVideo();
                $valuesArray["poster_path"] = $movie->getPosterPath();
                $valuesArray["id"] = $movie->getId();
                $valuesArray["adult"] = $movie->getAdult();
                $valuesArray["backdrop_path"] = $movie->getBackdropPath();
                $valuesArray["original_language"] = $movie->getOriginalLanguage();
                $valuesArray["original_title"] = $movie->getOriginalTitle();
                $valuesArray["genre_ids"] = $movie->getGenreIds();
                $valuesArray["title"] = $movie->getTitle();
                $valuesArray["vote_average"] = $movie->getVoteAverage();
                $valuesArray["overview"] = $movie->getOverview();
                $valuesArray["release_date"] = $movie->getReleaseDate();
                array_push($arrayToEncode, $valuesArray);
            }
            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->getJsonFilePath(), $jsonContent);
        }

        private function retrieveData()
        {
            $this->movieList = array();
            $jsonPath = $this->getJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach ($arrayToDecode as $valuesArray) {
                $movie = new Movie();
                $movie->setPopularity($valuesArray["popularity"]);
                $movie->setVoteCount($valuesArray["vote_count"]);
                $movie->setVideo($valuesArray["video"]);
                $movie->setPosterPath($valuesArray["poster_path"]);
                $movie->setId($valuesArray["id"]);
                $movie->setAdult($valuesArray["adult"]);
                $movie->setBackdropPath($valuesArray["backdrop_path"]);
                $movie->setOriginalLanguage($valuesArray["original_language"]);
                $movie->setOriginalTitle($valuesArray["original_title"]);
                $movie->setGenreIds($valuesArray["genre_ids"]);
                $movie->setTitle($valuesArray["title"]);
                $movie->setVoteAverage($valuesArray["vote_average"]);
                $movie->setOverview($valuesArray["overview"]);
                $movie->setReleaseDate($valuesArray["release_date"]);
                array_push($this->movieList, $movie);
            }
        }

        function getJsonFilePath(){

            $initialPath = "Data/movies.json";

            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }

            return $jsonFilePath;
        }
    }

 ?>
