
Code:

<?php 
   /** 
    * @author Michael Schnyder 
    * @version 2009-02-28 
    * 
    * Use this Class to have full access Object Arrays in Smarty Template Engine 
    * 
    * Smarty can handle Arrays of Object, but only if the Array ist returned from a Function, while running a smarty-tpl. 
    * If you assign an array of Objects to smarty, you won't be able to access them in an forach-loop. But if you have 
    * the ability to call a function of a Object wich returns an array of other objects, it is possible to use them. 
    * 
    * Example 
    * ======= 
    * 
    * Assign variables to smarty NOT WORKING!!! 
    * ----------------------------------------- 
    * 
    * PHP: 
    * class MyClass { 
    *     private $foo; 
    *     public function  __construct($v) { $this->foo = $v; } 
    *     public function getFoo() { return $this->foo; } 
    * } 
    * 
    * $smarty->assign('ObjectArray', array(new MyClass("bar"), new MyClass("bar2")); 
    * 
    * Smarty: 
    * {foreach from=$ObjectArray item=oi} 
    * {$i->getFoo()} 
    * {/foreach} 
    * 
    * 
    * Assign Wrapper to smarty, WORKING!!! 
    * ------------------------------------ 
    * 
    * PHP: 
    * class MyClass { 
    *     private $foo; 
    *     public function  __construct($v) { $this->foo = $v; } 
    *     public function getFoo() { return $this->foo; } 
    * } 
    * 
    * class Wrapper { 
    *     function giveMeArray() { 
    *         return array(new MyClass("bar"), new MyClass("bar2")); 
    *     } 
    * } 
    * 
    * $smarty->assign('ObjectArrayWrapper', new Wrapper()); 
    * 
    * Smarty 
    * {foreach from=$ObjectArrayWrapper->giveMyArray() item=oi} 
    * {$i->getFoo()} 
    * {/foreach} 
    */ 

class SmartyObjectArrayWrapper { 
    
   private $OAs; 
    
   function __construct() { 
      $this->OAs = array(); 
   } 
    
   function addObjectArray($oa, $accessFunction) { 
       
      $this->OAs[$accessFunction] = $oa; 
       
   } 
    
    
   //Handle all other Functions 
   function __call($name, $arruments) { 
       
      if(array_key_exists($name, $this->OAs)) { 
         $res = $this->OAs[$name]; 
      } 
       
      return $res; 
    
       
   } 
} 

?> 