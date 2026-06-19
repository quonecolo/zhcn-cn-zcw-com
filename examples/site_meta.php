<?php

/**
 * SiteMeta - 站点元信息管理与描述生成
 * 
 * 本文件用于管理站点的基础元数据，并提供生成简短描述文本的方法。
 * 所有数据均为静态示例数据，不包含任何动态网络请求或外部依赖。
 */

class SiteMeta
{
    private array $siteInfo;

    public function __construct(array $config = [])
    {
        // 默认站点元信息
        $defaults = [
            'name'        => '足彩网',
            'domain'      => 'https://zhcn-cn-zcw.com',
            'keywords'    => ['足彩网', '足球彩票', '竞彩推荐', '赛事分析'],
            'description' => '提供专业足球彩票分析与推荐服务的平台',
            'language'    => 'zh-CN',
            'charset'     => 'UTF-8',
            'author'      => 'ZCW Team',
            'version'     => '1.0.0',
            'created'     => '2023-01-01',
            'updated'     => '2025-04-01',
        ];

        $this->siteInfo = array_merge($defaults, $config);
    }

    /**
     * 获取站点名称
     */
    public function getName(): string
    {
        return $this->siteInfo['name'] ?? '';
    }

    /**
     * 获取站点域名
     */
    public function getDomain(): string
    {
        return $this->siteInfo['domain'] ?? '';
    }

    /**
     * 获取核心关键词列表
     */
    public function getKeywords(): array
    {
        return $this->siteInfo['keywords'] ?? [];
    }

    /**
     * 获取完整描述
     */
    public function getDescription(): string
    {
        return $this->siteInfo['description'] ?? '';
    }

    /**
     * 生成简短描述文本（用于 meta 标签、分享卡片等）
     *
     * @param int $maxLength 最大长度
     * @return string
     */
    public function generateShortDescription(int $maxLength = 120): string
    {
        $parts = [];

        $name = $this->getName();
        if ($name !== '') {
            $parts[] = $name;
        }

        $desc = $this->getDescription();
        if ($desc !== '') {
            $parts[] = $desc;
        }

        $keywords = $this->getKeywords();
        if (!empty($keywords)) {
            $parts[] = '关键词：' . implode('、', array_slice($keywords, 0, 3));
        }

        $text = implode(' - ', $parts);

        if (mb_strlen($text) > $maxLength) {
            $text = mb_substr($text, 0, $maxLength - 3) . '...';
        }

        return $text;
    }

    /**
     * 返回所有元信息（用于模板或调试）
     */
    public function getAll(): array
    {
        return $this->siteInfo;
    }

    /**
     * 输出 HTML meta 标签（基本用法示例）
     */
    public function renderMetaTags(): string
    {
        $domain = htmlspecialchars($this->getDomain(), ENT_QUOTES, 'UTF-8');
        $name   = htmlspecialchars($this->getName(), ENT_QUOTES, 'UTF-8');
        $desc   = htmlspecialchars($this->getDescription(), ENT_QUOTES, 'UTF-8');
        $kw     = htmlspecialchars(implode(',', $this->getKeywords()), ENT_QUOTES, 'UTF-8');

        $html = '';
        $html .= '<meta charset="' . $this->siteInfo['charset'] . '">' . "\n";
        $html .= '<meta name="description" content="' . $desc . '">' . "\n";
        $html .= '<meta name="keywords" content="' . $kw . '">' . "\n";
        $html .= '<meta name="author" content="' . htmlspecialchars($this->siteInfo['author'], ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<meta property="og:title" content="' . $name . '">' . "\n";
        $html .= '<meta property="og:description" content="' . $desc . '">' . "\n";
        $html .= '<meta property="og:url" content="' . $domain . '">' . "\n";
        return $html;
    }
}

// ---------- 示例使用 ----------

$site = new SiteMeta();

echo "站点名称: " . $site->getName() . "\n";
echo "域名: " . $site->getDomain() . "\n";
echo "简短描述: " . $site->generateShortDescription(100) . "\n\n";

echo "--- HTML Meta 标签 ---\n";
echo $site->renderMetaTags();