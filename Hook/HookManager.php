<?php

namespace PriceObservatoryCR\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/**
 * Class HookManager
 * @package PriceObservatoryCR\Hook
 */
class HookManager extends BaseHook
{
    public function onMainHeadCss(HookRenderEvent $event)
    {
        $content = $this->addCSS('css/style.css');
        $event->add($content);
    }
}
