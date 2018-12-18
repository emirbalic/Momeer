<?php   
    class Artist 
    {
        private $con;
        private $id;

        public function __construct($con, $id){
            $this->con = $con;
            $this->id = $id;
        }  

        public function getId() {
			return $this->id;
		}
        
        public function getName () {
            $artistQuery = mysqli_query($this->con, 
            "SELECT name 
            FROM artists
            WHERE id ='$this->id'");
         
            $artist = mysqli_fetch_array($artistQuery);
            return $artist['name'];
        }

        public function getSongIds() {
            $songQuery = mysqli_query($this->con,
            "SELECT id
            FROM songs
            WHERE artist = $this->id
            ORDER BY plays DESC");

            $idArray = array();

            while ($row = mysqli_fetch_array ($songQuery)) {
                array_push($idArray, $row['id']);
            }

            return $idArray;
        }
    }
   
?>