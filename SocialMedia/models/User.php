<?php
class User extends ActiveRecord\Model
 {
    static $validates_uniqueness_of =  array('username') ;
 }
