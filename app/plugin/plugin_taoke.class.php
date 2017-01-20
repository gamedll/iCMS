<?php
/**
 * @package iCMS
 * @copyright 2007-2016, iDreamSoft
 * @license http://www.idreamsoft.com iDreamSoft
 * @author coolmoo <idreamsoft@qq.com>
 */
class plugin_taoke{
    /**
     * [插件:转换淘宝客链接]
     * @param [type] $content  [参数]
     * @param [type] $resource [返回替换过的内容]
     */
    public static function HOOK($content,&$resource=null) {
        preg_match_all('/<[^>]+>((http|https):\/\/(item|detail)\.(taobao|tmall)\.com\/.+)<\/[^>]+>/isU', $content, $taoke_array);
        if ($taoke_array[1]) {
            $tk_array = array_unique($taoke_array[1]);
            foreach ($tk_array as $tkid => $tk_url) {
                $tk_url = htmlspecialchars_decode($tk_url);
                $tk_parse = parse_url($tk_url);
                parse_str($tk_parse['query'], $tk_item_array);
                $itemid = $tk_item_array['id'];
                $tk_data[$tkid] = self::taoke_tpl($itemid, $tk_url);
            }
            $content = str_replace($tk_array, $tk_data, $content);
            is_array($resource) && $resource['taoke'] = true;
        }
        return $content;
    }
    public static function taoke_tpl($itemid, $url, $title = null) {
        iView::assign('taoke', array(
            'itemid' => $itemid,
            'title' => $title,
            'url' => $url,
        ));
        return iView::fetch('iCMS://taoke.tpl.htm');
    }
}
