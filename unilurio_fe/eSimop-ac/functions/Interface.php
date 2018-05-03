<?php
        
 abstract class FactoryInterface{
        
    abstract public function newElement();
    abstract public function read($id);
    abstract public function insert($object);
    abstract public function update($object);
    abstract public function delete($id);
    abstract public function selectAll(); 
 }
 
?>