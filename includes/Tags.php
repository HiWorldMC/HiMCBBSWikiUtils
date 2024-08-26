<?php

namespace MediaWiki\Extension\HiMCBBSWiki;

use Parser;
use PPFrame;
use Html;
use MediaWiki\MediaWikiServices;

class Tags
{
    public static function renderTagXenforoAvatar($input, array $args, Parser $parser, PPFrame $frame)
    {
        $parser->getOutput()->addModuleStyles('ext.himcbbswikiutils.avatar');
        $config = MediaWikiServices::getInstance()->getConfigFactory()->makeConfig( 'HiMCBBSWikiUtils' );
        $xenforo = $config->get( 'XenforoURL' );
        if(empty($xenforo)){
            return Html::element('p',['style' => 'color:red;font-size:160%'],wfMessage('xenforoavatar-noavatarurl')->text());
        }
        $uid = isset($args['uid']) ? htmlspecialchars($args['uid']) : '1';

        if (strlen($uid) >= 2 && intval(substr($uid, 0, 1)) >= 9) {
            $uid_prefix = substr($uid, 0, 2);
        } elseif (strlen($uid) >= 3 && intval(substr($uid, 0, 2)) >= 99) {
            $uid_prefix = substr($uid, 0, 3);
        } else {
            $uid_prefix = '1';
        }
        
        $image = Html::element('img', [
            'src' => "$xenforo/data/avatars/o/$uid_prefix/$uid.jpg",
            'class' => "himcbbs-avatar himcbbs-avatar-$uid",
            'data-uid' => $uid
        ], '');
        return $image;
    }

    public static function renderTagBilibili($input, array $args, Parser $parser, PPFrame $frame)
    {
        $attr = [
            'allowfullscreen' => 'true',
            'frameborder' => '0',
            'framespacing' => '0',
            'sandbox' => 'allow-top-navigation allow-same-origin allow-forms allow-scripts',
            'scrolling' => 'no',
            'border' => '0',
            'width' => isset($args['width']) ? htmlspecialchars($args['width']) : '800',
            'height' => isset($args['height']) ? htmlspecialchars($args['height']) : '600'
        ];
        if (isset($args['bv'])) {
            $bvid = htmlspecialchars($args['bv']);
            $src = "https://player.bilibili.com/player.html?bvid=$bvid&high_quality=1";
            $attr['src'] = $src;
            $video = Html::element('iframe', $attr, '');
            return Html::rawElement('div', ['class' => "bilibili-video bilibili-video-$bvid"], $video);
        } else {
            return Html::element('p', ['style' => 'color:red;font-size:160%'], wfMessage('bilibili-nobvid')->text());
        }
    }
}
