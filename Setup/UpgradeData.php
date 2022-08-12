<?php

namespace I95dev\Cmspage\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var \Magento\Cms\Model\PageFactory
     */
    protected $_pageFactory;

    private $blockFactory;

    /**
     * Construct
     *
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     */
    public function __construct(
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Cms\Model\BlockFactory $blockFactory
    ) {
        $this->_pageFactory = $pageFactory;
        $this->blockFactory = $blockFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.1') < 0) {
            $page = $this->_pageFactory->create();
            $page->setTitle('I95dev CMS page')
                ->setIdentifier('i95dev-cms-page')
                ->setIsActive(true)
                ->setPageLayout('1column')
                ->setStores(array(0))
//                ->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
                ->save();

            $testBlock = [
                'title' => 'Custom Block',
                'identifier' => 'custom_block',
                'stores' => [0],
                'is_active' => 1,
            ];
            $this->blockFactory->create()->setData($testBlock)->save();
        }

        $setup->endSetup();
    }
}
