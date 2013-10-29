<?php
class MyLCG {

    function __construct() {

    }

    public function get_lcg($m) {
        $b = ($m/2)+1;
        $a = ($b/2)+1;
        $hasil = array();
        for($i=0;$i<$m;$i++){
            if($i==0) $hasil[$i] = ($a*rand(0, $m) + $b) % $m;
            else $hasil[$i] = ($a*$hasil[$i-1] + $b) % $m;
        }
        return $hasil;
    }

}
$MyLCG = new MyLCG();
?>
