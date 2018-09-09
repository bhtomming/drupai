<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\9\7 0007
 * Time: 16:07
 */

namespace App\Services;


class PinYin
{
    public $spellArray = array();

    static public function getArray() {
        return unserialize(file_get_contents(__DIR__.'/pytable_without_tune.txt'));
    }

    /**
     * @desc 将字符串转换成拼音字符串
     */
    public function getChineseChar($string,$isOne=false,$upper=false,$suf='.html') {
        $spellArray = self::getArray();
        $string = strtolower($string);
        $str_arr = $this->utf8_str_split($string); //将字符串拆分成数组

        $result = array();
        foreach($str_arr as $index => $char)
        {
            if(preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$char))
            {
                $chinese = $spellArray[$char];
            } else{
                $chinese = $char;
            }
            $chinese = $isOne ? substr($chinese,0,1) : $chinese;
            $result[] = $upper ? strtoupper($chinese) : $chinese;
        }

        return implode('-', $result).$suf;
    }
    /**
     * @desc 将字符串转换成数组
     * @param $str
     */
    public function utf8_str_split($str) {
        $str = preg_replace('/[^a-zA-Z0-9\p{Han}]/u ','',$str);//去掉特殊字符如:标点符号
        if(preg_match("/^[\x{4e00}-\x{9fa5}]+$/ui",$str)){
            return $this->getChineseStr($str,1);
        }else {
            $zh_ar = preg_split("/([a-zA-Z0-9]+)/ui", $str, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
            for ($index = 0; $index < sizeof($zh_ar); $index++) {
                if (preg_match("/^[\x{4e00}-\x{9fa5}]+$/ui", $zh_ar[$index])) {
                    $chStr = $this->getChineseStr($zh_ar[$index], 1);
                    array_splice($zh_ar, $index, 1, $chStr);
                    //$index += mb_strlen($zh_ar[$index], 'UTF-8');
                }
            }
            return $zh_ar;
        }

    }
    public function getChineseStr($str,$split_len=1){
        if(!preg_match('/^[0-9]+$/', $split_len) || $split_len < 1) {
            return FALSE;
        }

        $len = mb_strlen($str, 'UTF-8');

        if ($len <= $split_len) {
            return array($str);
        }
        preg_match_all('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us', $str, $ar);
        return $ar[0];
    }

}