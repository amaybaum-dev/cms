<?php

namespace craft\migrations;

use Craft;
use craft\db\Migration;
use craft\db\Table;

/**
 * m221027_160703_add_image_transform_fill migration.
 */
class m221027_160703_add_image_transform_fill extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        // Place migration code here...
        $this->addColumn(Table::IMAGETRANSFORMS, 'fill', $this->string(11)->null()->after('interlace'));
        $this->alterColumn(
            Table::IMAGETRANSFORMS,
            'mode',
            $this->enum('mode', ['stretch', 'fit', 'crop', 'letterbox'])->notNull()->defaultValue('crop'),
        );
        $allowUpscale = Craft::$app->getConfig()->getGeneral()->upscaleImages;
        $this->addColumn(Table::IMAGETRANSFORMS, 'upscale', $this->boolean()->notNull()->defaultValue($allowUpscale)->after('fill'));

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        $this->dropColumn(Table::IMAGETRANSFORMS, 'fill');
        $this->dropColumn(Table::IMAGETRANSFORMS, 'upscale');
        $this->alterColumn(
            Table::IMAGETRANSFORMS,
            'mode',
            $this->enum('mode', ['stretch', 'fit', 'crop'])->notNull()->defaultValue('crop'),
        );

        return true;
    }
}
