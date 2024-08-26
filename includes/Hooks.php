<?php

namespace MediaWiki\Extension\HiMCBBSWiki;

use Skin;
use MediaWiki\Extension\HiMCBBSWiki\Tags;
use MediaWiki\Hook\ParserFirstCallInitHook;
use MediaWiki\Hook\SkinAddFooterLinksHook;

class Hooks implements ParserFirstCallInitHook,SkinAddFooterLinksHook
{
    public function onSkinAddFooterLinks(Skin $skin, string $key, array &$footerlinks)
    {
        if ($key === 'info') {
            $msg = $skin->msg('footerinfo');
            if (!$msg->isDisabled()) {
                $footerlinks['footerinfo'] = $msg->parse();
            }
        };
    }
    public function onParserFirstCallInit($parser)
    {
        $parser->setHook('xenforo-avatar', [Tags::class, 'renderTagXenforoAvatar']);
        $parser->setHook('bilibili', [Tags::class, 'renderTagBilibili']);
    }
}
