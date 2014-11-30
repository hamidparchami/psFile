<?php
/********************************
* Common Functions
* Written by Hamid Parchami
* Email: hamidparchami@gmail.com
* 29/09/2014
********************************/


/**
*Analyze and Crop Long Text
*@param	string text
*@param integer max allowed length
*@param	string text trail ex: ...
**/
function cropSentence($strText, $intLength, $strTrail="..."){
    $wsCount = 0;
    $intTempSize = 0;
    $intTotalLen = 0;
    $intLength = $intLength - strlen($strTrail);
    $strTemp = "";

    if (strlen($strText) > $intLength) {
        $arrTemp = explode(" ", $strText);
        foreach ($arrTemp as $x) {
            if (strlen($strTemp) <= $intLength) $strTemp .= " " . $x;
        }
        $cropSentence = $strTemp . $strTrail;
    } else {
        $cropSentence = $strText;
    }
    return $cropSentence;
}
/**
*Check and Crop Long Words
*@param	string word
*@param integer max allowed length
**/
function cropLongWord($word, $maxLength, $trail="..."){
    if(strlen($word) > $maxLength){
        $word = substr($word, 0, $maxLength) . $trail;
    }
    return $word;
}
/**
 *Set Current Page Address to SESSION For Redirect
 *@param string create session permission
 **/
function setRedirectURL($Run=true){
 if(@!session_start()){
   session_start();
 }
  if($Run){
	$_SESSION['RedirectURL'] = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
  }
}
/**
 *Check Regular Expression
 *@param string regular expression
 *@param string subject haystack
 **/
function regularExp($regexp, $subject){
	if (preg_match($regexp, $subject)) {
    	return true;
	}else{
		return false;
	}

}
/**
*Return Replaced Punctuation Characters in subject
*@param string subject haystack
*@param string replacement letter
**/
function replacePunctuation($subject, $replace="-"){
	$search = array(" ", "!", '"', "#", "$", "%", "&", "'", "(", ")", "*", "+", ",", "-",
 					".", "/", ":", ";", "<", "=", ">", "?", "@", "[", "]", "^", "_", "`",
					"{", "|", "}", "~");
	return str_replace($search, $replace, $subject);
}
?>