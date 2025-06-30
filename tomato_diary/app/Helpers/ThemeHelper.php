<?php

namespace App\Helpers;

class ThemeHelper
{
    /**
     * 現在のテーマを取得
     */
    public static function getCurrentTheme()
    {
        return session('app_theme', 'default');
    }

    /**
     * テーマに基づくCSSクラスを取得
     */
    public static function getThemeClass()
    {
        $theme = self::getCurrentTheme();
        return 'theme-' . $theme;
    }

    /**
     * テーマに基づく背景色クラスを取得
     */
    public static function getBackgroundClass()
    {
        $theme = self::getCurrentTheme();

        switch ($theme) {
            case 'dark':
                return 'bg-gray-900';
            case 'light':
                return 'bg-white';
            case 'green':
                return 'bg-green-50';
            case 'blue':
                return 'bg-blue-50';
            default:
                return 'bg-gray-100';
        }
    }

    /**
     * テーマに基づくテキスト色クラスを取得
     */
    public static function getTextClass()
    {
        $theme = self::getCurrentTheme();

        switch ($theme) {
            case 'dark':
                return 'text-white';
            default:
                return 'text-gray-900';
        }
    }

    /**
     * 現在の壁紙のURLを取得
     */
    public static function getCurrentWallpaper()
    {
        $wallpaper = config('app.current_wallpaper', 'default.jpg');

        if ($wallpaper === 'default.jpg') {
            return null; // デフォルト壁紙の場合はnullを返す
        }

        return asset('image/wallpaper/' . $wallpaper);
    }

    /**
     * 壁紙のスタイルを取得
     */
    public static function getWallpaperStyle()
    {
        $wallpaperUrl = self::getCurrentWallpaper();

        if ($wallpaperUrl) {
            return "background-image: url('{$wallpaperUrl}'); background-size: cover; background-position: center; background-attachment: fixed;";
        }

        return '';
    }
}
