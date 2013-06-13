<?php
/*
 * (c) Netvlies Internetdiensten
 *
 * Sjoerd Peters <speters@netvlies.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Netvlies\Bundle\MenuBundle\Document;

use Symfony\Cmf\Bundle\MenuBundle\Document\MenuItem as BaseMenuItem;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;
use Netvlies\Bundle\OmsBundle\Document\LinkInterface;
use Netvlies\Bundle\OmsBundle\Document\OrderingInterface;

/**
 * @PHPCRODM\Document
 * @todo add assertion for linktype, it cant be null
 */
class MenuItem extends BaseMenuItem implements LinkInterface, OrderingInterface
{
    /**
     * @var string
     * @PHPCRODM\String()
     */
    protected $linkType;

    /**
     * @var string
     * @PHPCRODM\String()
     */
    protected $linkTarget;


    /**
     * {@inheritdoc}
     */
    public function setLinkDocument($document)
    {
        $this->setWeak(true);
        $this->setContent($document);
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkDocument()
    {
        return $this->getContent();
    }

    /**
     * {@inheritdoc}
     */
    public function setLinkTarget($linkTarget)
    {
        $this->linkTarget = $linkTarget;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkTarget()
    {
        return $this->linkTarget;
    }

    /**
     * {@inheritdoc}
     */
    public function setLinkType($linkType)
    {
        $this->linkType = $linkType;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkType()
    {
        return $this->linkType;
    }

    /**
     * {@inheritdoc}
     */
    public function setLinkUrl($linkUrl)
    {
        $this->setUri($linkUrl);
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkUrl()
    {
        return $this->getUri();
    }

    /**
     * @return bool
     */
    public function isLinkInternal()
    {
        return ($this->linkType === LinkInterface::LINK_TYPE_INTERNAL);
    }

    /**
     * @return bool
     */
    public function isLinkExternal()
    {
        return ($this->linkType === LinkInterface::LINK_TYPE_EXTERNAL);
    }

    /**
     * @return bool
     */
    public function hasLink()
    {
        return ($this->linkType != LinkInterface::LINK_TYPE_NONE);
    }
}
