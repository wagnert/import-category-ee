<?php

/**
 * TechDivision\Import\Category\Ee\Observers\EeCategoryObserver
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-ee
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Ee\Observers;

use TechDivision\Import\Category\Utils\MemberNames;
use TechDivision\Import\Category\Observers\CategoryObserver;

/**
 * Observer that create's the category itself for the Magento 2 EE edition.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-ee
 * @link      http://www.techdivision.com
 */
class EeCategoryObserver extends CategoryObserver
{

    /**
     * Process the observer's business logic.
     *
     * @return array The processed row
     */
    protected function process()
    {

        // prepare the static entity values
        $category = $this->initializeProduct($this->prepareAttributes());

        // persist the entity and set the entity ID
        $this->setLastRowId($this->persistCategory($category));
        $this->setLastEntityId($category[MemberNames::ENTITY_ID]);
    }

    /**
     * Initialize the category with the passed attributes and returns an instance.
     *
     * @param array $attr The category attributes
     *
     * @return array The initialized category
     */
    protected function initializeCategory(array $attr)
    {

        // initialize the addtional Magento 2 EE product values
        $additionalAttr = array(
            MemberNames::ENTITY_ID  => $this->nextIdentifier(),
            MemberNames::CREATED_IN => 1,
            MemberNames::UPDATED_IN => strtotime('+20 years')
        );

        // merge and return the attributes
        return array_merge($attr, $additionalAttr);
    }

    /**
     * Set's the row ID of the category that has been created recently.
     *
     * @param string $rowId The row ID
     *
     * @return void
     */
    protected function setLastRowId($rowId)
    {
        $this->getSubject()->setLastRowId($rowId);
    }

    /**
     * Return's the next available category entity ID.
     *
     * @return integer The next available category entity ID
     */
    protected function nextIdentifier()
    {
        return $this->getSubject()->nextIdentifier();
    }
}
