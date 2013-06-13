<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mdekrijger
 * Date: 10/20/12
 * Time: 4:35 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Netvlies\Bundle\OmsBundle\Document;

interface LinkInterface
{

    const LINK_TARGET_SELF = '_self';
    const LINK_TARGET_BLANK = '_blank';

    const LINK_TYPE_INTERNAL = 'internal';
    const LINK_TYPE_EXTERNAL = 'external';
    const LINK_TYPE_NONE = 'none';

    /**
     * If type is internal link than this method is used to set the connected document to link to.
     * Document has a default route which is used to render the link
     *
     * @param string $document
     */
    public function setLinkDocument($document);

    /**
     * This will get the connected document for current link
     *
     * @return string
     */
    public function getLinkDocument();

    /**
     * The constants LINK_TARGET_* are set into this method. It can be used to generate the right "target" attribute within
     * the "a" element
     *
     * @param string $target
     */
    public function setLinkTarget($target);

    /**
     * Getter for target attribute for the "a" element
     *
     * @return string
     */
    public function getLinkTarget();

    /**
     * Link type is used for the linkform to determine if internal link or external link is chosen. We make a difference
     * between internal link and external to preven broken internal links. If an internal route is changed, the connected
     * document remains intact. So it can always be retrieved. The constants in this interface LINK_TYPE_* are used for this
     *
     * @param string $type
     */
    public function setLinkType($type);

    /**
     * Get the link type, the constants in this interface LINK_TYPE_* are used for this purpose. It is used to prevent
     * broken links. Internal links are connected to a document instead of a static route. So this changes dynamically
     * when route changes.
     *
     * @return string
     */
    public function getLinkType();

    /**
     * Used for external link. Its a static string (probably pointing to another domain, other site). otherwise it is better
     * to use internal link
     *
     * @param string $url
     */
    public function setLinkUrl($url);

    /**
     * Get the external url.
     *
     * @return string
     */
    public function getLinkUrl();

}
