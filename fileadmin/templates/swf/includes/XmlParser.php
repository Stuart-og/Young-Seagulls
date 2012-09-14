<?php
function philsXMLClean($strin) {
$strout = null;
for ($i = 0; $i < strlen($strin); $i++) {
	$ord = ord($strin[$i]);
	if (($ord > 0 && $ord < 32) || ($ord >= 127)) {
		$strout .= "&amp;#{$ord};";
	}
	else {
		switch ($strin[$i]) {
			case '<':
				$strout .= '&lt;';
				break;
			case '>':
				$strout .= '&gt;';
				break;
			case '&':
				$strout .= '&amp;';
				break;
			case '"':
				$strout .= '&quot;';
				break;
			default:
				$strout .= $strin[$i];
		}
	}
}
return $strout;
}
class XmlParser {
    var $xml;
    var $indent;
    var $stack = array();
    function XmlWriter($indent='  ') {
        $this->indent = $indent;
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>'."\n";
    }
    function _indent() {
        for ($i = 0, $j = count($this->stack); $i < $j; $i++) {
            $this->xml .= $this->indent;
        }
    }
    function push($element, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="'.philsXMLClean(htmlentities($value)).'"';
        }
        $this->xml .= ">\n";
        $this->stack[] = $element;
    }
    function element($element, $content, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="'.philsXMLClean(htmlentities($value)).'"';
        }
        $this->xml .= '>'.htmlentities($content).'</'.$element.'>'."\n";
    }
    function emptyelement($element, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="'.htmlentities($value).'"';
        }
        $this->xml .= " />\n";
    }
    function pop() {
        $element = array_pop($this->stack);
        $this->_indent();
        $this->xml .= "</$element>\n";
    }
    function getXml() {
        return $this->xml;
    }
}
?>  