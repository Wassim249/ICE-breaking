<?php

    class User {
        public $id ;
        public $firstName ; 
        public $lastName ;
        public $email ;
        public $image ;
        
        function __construct($id,$firstName,$lastName,$email)
        {
            $this->id = $id;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->email = $email;
            $image = 'default-profile-image.png' ;
        }
        public function get_firstName()
        {
            return $this->firstName ;
        }
        public function set_image($imagePath) {
            $this->image = $imagePath ;
        }
    }

?>