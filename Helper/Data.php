<?php

namespace TBNFTBanner\Helper;

/**
 * Class Data
 * @package TBNFTBanner\Helper
 */
class Data
{
    /**
     * Method to clear string
     *
     * @param $string
     * @return string
     */
    public static function clearString($string)
    {
        return trim(strip_tags($string));
    }

    /**
     * Method to get max array key
     *
     * @param $arr
     * @return int
     */
    public static function getMaxArrKey($arr)
    {
        return (int)max((array_keys($arr)));
    }

    /**
     * Method to clear array
     *
     * @param $arr
     * @return array
     */
    public static function clearArray(array $arr)
    {
        if (!empty($arr)) {
            foreach ($arr as &$value) {
                if (is_array($value)) {
                    self::clearArray($value);
                } else {
                    $value = self::clearString($value);
                }
            }
        }
        return $arr;
    }

    public static function modifyTemplatesDataForCreation($templates) :array
    {
        $templatesForCreation = [];
        foreach ($templates as $key=>$template) {
            if ($template['file'] && $template['title']) {
                $templatesForCreation[$template['file']] = $template['title'];
            }
        }
        return $templatesForCreation;
    }

    public static function getPageLinkById($id) :string
    {
        $pageLink = site_url();
        $options = apply_filters('getForumConfigOptions', 'options');
        if (isset($options[$id])) {
            $realLink = get_page_link($options[$id]);
            if ($realLink) {
                $pageLink = $realLink;
            }
        }
        return $pageLink;
    }
}
