<?php

namespace App\Render;

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private array $keywords;

    public function __construct(string $url, string $title, string $description = '', array $keywords = [])
    {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }

    public static function fromDefaults(): self
    {
        return new self(
            'https://officialcn-i-game.com.cn',
            '爱游戏',
            '官方游戏平台，提供丰富的游戏体验与娱乐内容。',
            ['爱游戏', '游戏平台', '娱乐']
        );
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setKeywords(array $keywords): void
    {
        $this->keywords = $keywords;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getKeywords(): array
    {
        return $this->keywords;
    }

    public function render(): string
    {
        $safeUrl = htmlspecialchars($this->url, ENT_QUOTES, 'UTF-8');
        $safeTitle = htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
        $safeDesc = htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8');

        $tagHtml = '';
        if (!empty($this->keywords)) {
            $tags = array_map(function (string $keyword): string {
                $safeKeyword = htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');
                return '<span class="link-card-tag">' . $safeKeyword . '</span>';
            }, $this->keywords);

            $tagHtml = '<div class="link-card-tags">' . implode('', $tags) . '</div>';
        }

        return <<<HTML
<div class="link-card">
    <a href="{$safeUrl}" class="link-card-link" target="_blank" rel="noopener noreferrer">
        <div class="link-card-content">
            <h3 class="link-card-title">{$safeTitle}</h3>
            <p class="link-card-description">{$safeDesc}</p>
            {$tagHtml}
        </div>
        <div class="link-card-url">
            <span>{$safeUrl}</span>
        </div>
    </a>
</div>
HTML;
    }

    public static function renderDefault(): string
    {
        $card = self::fromDefaults();
        return $card->render();
    }

    public static function renderFromArray(array $data): string
    {
        $url = isset($data['url']) ? (string) $data['url'] : 'https://officialcn-i-game.com.cn';
        $title = isset($data['title']) ? (string) $data['title'] : '爱游戏';
        $description = isset($data['description']) ? (string) $data['description'] : '';
        $keywords = isset($data['keywords']) && is_array($data['keywords']) ? $data['keywords'] : [];

        $card = new self($url, $title, $description, $keywords);
        return $card->render();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}