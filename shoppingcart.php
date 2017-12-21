<?php
/*
  +--------------------------------------------------------------------------------------------------
  | PAGE DESCRIPTION
  |
  | @date: Dec. 21, 2017
  | @page author: Shanti Prakash Gola
  | @page description:
  | - Implement a point-of-sale scanning API that accepts an arbitrary ordering of products (similar to what would happen at a checkout line) and then returns the correct total price for an entire shopping cart based on the per unit prices or the volume prices as applicable.
  +--------------------------------------------------------------------------------------------------
 */

//Some constant to for the help of the system to change or update the cost price anytime without going into the code this can be replace by the DB.
define("COST_A", 2);
define("CLUB_COST_A", 7);
define("COST_B", 12);
define("COST_C", 1.25);
define("CLUB_COST_C", 6);
define("COST_D", .15);


//Class to calculate the cost price.

class CalculateCart{
    
    //private member of the class.
    private $aCount;
    private $bCount;
    private $cCount;
    private $dCount;
    private $total;
    
    
    
    public function __contruct(){
        //initialization of the class variable as soon as the class get initated.
        $this->aCount=0;
        $this->bCount=0;
        $this->cCount=0;
        $this->dCount=0;
        $this->total=0;
        
    }
    /**
     * Function @scanCode
     * @param type $param : string like barcode to calculate the item in the basket.
     * Use : This is used to count the items in the basket for further calculations at the end.
     * 
     */
    public function scanCode($param) {
        //break the scan code for the order
        $codeArr=str_split($param);
        foreach ($codeArr as $key => $value) {
        switch ($value) {
            case "A":
                $this->aCount++;
                    break;
            case "B":
                $this->bCount++;
                    break;
            case "C":
                $this->cCount++;
                    break;
            case "D":
                $this->dCount++;
                    break;

            default:
                $this->aCount++;
                break;
            }
        }
    }
    
    /**
     * Function @calculateTotal
     * @return type : total ( string )
     * 
     */
    public function calculateTotal() {
        $this->total=$this->bCount*COST_B;
        $this->total=$this->total+$this->dCount*COST_D;
        if($this->aCount>=4){
            $clubCost=floor($this->aCount/4)*CLUB_COST_A;
            $aCost=$this->aCount%4*COST_A;
            $this->total=$this->total+$clubCost+$aCost;
        }
        else{
            $this->total=$this->total+$this->aCount*COST_A;
        }
        if($this->cCount>=6){
            $clubCost=floor($this->cCount/6)*CLUB_COST_C;
            $cCost=$this->cCount%6*COST_C;
            $this->total=$this->total+$clubCost+$cCost;
        }
        else{
            $this->total=$this->total+$this->cCount*COST_C;
        }
        
        return $this->total;
            
        }
    
    
}


//Some test Cases Mentioned. Please test with more scenarios.

$obj=new CalculateCart();
$obj->scanCode("ABCDABAA");
print_r($obj->calculateTotal());
echo "<br>------------------------------";
echo "<br>-------Second Calculation-----";
echo "<br>------------------------------<br>";
$obj=new CalculateCart();
$obj->scanCode("ABCD");
print_r($obj->calculateTotal());
echo "<br>------------------------------";
echo "<br>-------Third Calculation-----";
echo "<br>------------------------------<br>";
$obj=new CalculateCart();
$obj->scanCode("CCCCCCC");
print_r($obj->calculateTotal());



?>