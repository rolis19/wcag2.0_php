<?php
class CssParser {
    public $css;
    public $cssColor = array();
    public function __construct($css){
        $this->css_beautify($css);
        $this->css = file_get_contents('temp.css');
        $this->cssColor = $this->split_css('color');
    }
    //Parsing start here, to get only selector which has
    // background and foreground color
    public function css_beautify($css){
        $string = trim(preg_replace('/\s+/', ' ', $css));
        $find = '/(\S.*?) ?{(.*?)}/s';
        preg_match_all($find, $string, $found);
        $my_file = fopen("temp.css", "w") or die("Unable to open file!");
        foreach ($found[0] as $key=>$itm){
            $b_selector = preg_replace('/; ?/', ";\r\n", $found[1][$key]);
            fwrite($my_file, $b_selector."{\r\n");
            if(strpos($found[2][$key], ';') !== false) {
                $a1 = explode(";", $found[2][$key]);
            } else {
                $a1[0] = $found[2][$key];
            }
            $i=0;
            foreach ($a1 as $k=>$item) {
                $item = "\t".$item.";\r\n";
                if(++$i === count($a1)){
                    $item = "}\r\n";
                }
                fwrite($my_file, $item);
            }
        }
        fclose($my_file);
    }
    public function split_css($value){
        $find = '/(\S.*?) ?{(.*?)}/s';
        preg_match_all($find, $this->css, $found);
        if ($value == 'color'){
            $cssValue = $this->find_color($found);
        } else {
            $cssValue = $this->find_bgcolor($found);
        }
        $index = 0;
        $allCssValue=array();
        foreach ($cssValue as $key=>$itm){
            $index++;
            $allCssValue[$index] = array(
                'selector' => $found[1][$key],
                'value' => $itm,
                'selectorType' => $this->setSelectorType($found[1][$key]),
                'legalColorType' => $this->setLegalColorType($itm)
            );
        }
        return $allCssValue;
    }
    public function find_bgcolor($found){
        $with_bg = array();
        foreach ($found[2] as $key=>$item){
            $item_arr = preg_split("/;/", $item);
            foreach ($item_arr as $items){
                if (preg_match('/background(.+?)/s', $items)){
                    $with_bg[$key] = $items;
                }
            }
        }
        return $with_bg;
    }
    public function find_color($found){
        $with_color = array();
        foreach ($found[2] as $key=>$item){
            $item_arr = preg_split("/;/", $item);
            foreach ($item_arr as $items){
                if (preg_match('/[^-]color/s', $items)){
                    $with_color[$key] = $items;
                }
            }
        }
        return $with_color;
    }
	
	//Set selector types
	public function setSelectorType($selector){
		if (!preg_match('/\s/', $selector)) {
			//Basic selector
			$selectorType = 'basic';
		}else {
			$selectorType = 'non basic';
		}
		//Group Selector
		//Decendent Selector
		//Child Combinator
		//Adjacent Sibling Combinator
		//General Sibling Combinator
        return $selectorType;
    }

    //Set legal color value types
    public function setLegalColorType($value){
	    $colorValue = explode(':', $value);
        if (preg_match('/#/', $colorValue[1])){ //Hexadecimal colors
            $legalColorType = 'hexa';
        }else if (preg_match('/rgb[^a]/', $colorValue[1])) { //RGB colors
            $legalColorType = 'rgb';
        } else if(preg_match('/rgba/', $colorValue[1])){ //RGBA colors
            $legalColorType = 'rgba';
        } else if (preg_match('/hsl[^a]/', $colorValue[1])){ //HSL colors
            $legalColorType = 'hsl';
        }else if (preg_match('/hsla/', $colorValue[1])){ //HSLA colors
            $legalColorType = 'hsla';
        }else{                 //Predefined/Cross-browser color names
            $legalColorType = 'predefined';
        }
        return $legalColorType;
    }
    //Every legal color type should be converted into RGB
    //Hexadecimal to RGB
    public function hexatoRgb($hexaColor){
        $hexaColor = $this->tosix($hexaColor);
        list($R, $G, $B) = sscanf($hexaColor, "#%02x%02x%02x");
        return array($R, $G, $B);
    }
    //Any hexa with 3 value into six
    public function tosix($hex){
        return preg_replace('/#(...) /', '#$1$1', $hex.' ');
    }
    //RGBA to RGB
    public function rgbatoRgb(){}
    //HSL to RGAB
    public function hsltoRgb(){}

    public function predefinedtoRgb(){

    }
}