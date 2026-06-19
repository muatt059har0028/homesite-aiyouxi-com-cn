<?php

namespace App\Utilities;

class LinkCard
{
    private string $siteUrl;
    private string $siteName;
    private string $defaultDescription;

    public function __construct(
        string $siteUrl = 'https://homesite-aiyouxi.com.cn',
        string $siteName = '爱游戏',
        string $defaultDescription = '探索爱游戏最新资讯与玩法'
    ) {
        $this->siteUrl = rtrim($siteUrl, '/');
        $this->siteName = $siteName;
        $this->defaultDescription = $defaultDescription;
    }

    public function render(string $title, string $description = '', string $imageUrl = '', string $extraUrl = ''): string
    {
        $displayTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $displayDescription = htmlspecialchars(
            $description ?: $this->defaultDescription,
            ENT_QUOTES,
            'UTF-8'
        );
        $displayImage = htmlspecialchars($imageUrl ?: $this->siteUrl . '/default-card.png', ENT_QUOTES, 'UTF-8');
        $linkUrl = htmlspecialchars($extraUrl ?: $this->siteUrl, ENT_QUOTES, 'UTF-8');
        $siteLabel = htmlspecialchars($this->siteName, ENT_QUOTES, 'UTF-8');

        return <<<HTML
<div class="link-card">
    <a href="{$linkUrl}" target="_blank" rel="noopener noreferrer">
        <div class="card-image-wrapper">
            <img src="{$displayImage}" alt="{$displayTitle}" loading="lazy" />
        </div>
        <div class="card-body">
            <span class="card-source">{$siteLabel}</span>
            <h3 class="card-title">{$displayTitle}</h3>
            <p class="card-description">{$displayDescription}</p>
        </div>
    </a>
</div>
HTML;
    }

    public function renderWithArray(array $item): string
    {
        $title = $item['title'] ?? '爱游戏热门推荐';
        $description = $item['desc'] ?? $this->defaultDescription;
        $image = $item['image'] ?? '';
        $url = $item['url'] ?? $this->siteUrl;

        return $this->render($title, $description, $image, $url);
    }

    public function renderMultiple(array $items): string
    {
        $cards = [];

        foreach ($items as $entry) {
            $cards[] = $this->renderWithArray($entry);
        }

        return implode("\n", $cards);
    }

    public function getSiteUrl(): string
    {
        return $this->siteUrl;
    }

    public function getSiteName(): string
    {
        return $this->siteName;
    }
}