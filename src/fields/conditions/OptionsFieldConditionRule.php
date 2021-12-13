<?php

namespace craft\fields\conditions;

use craft\base\conditions\BaseMultiSelectConditionRule;
use craft\fields\BaseOptionsField;
use craft\fields\data\MultiOptionsFieldData;
use craft\fields\data\OptionData;
use craft\fields\data\SingleOptionFieldData;

/**
 * Options field condition rule.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 4.0.0
 */
class OptionsFieldConditionRule extends BaseMultiSelectConditionRule implements FieldConditionRuleInterface
{
    use FieldConditionRuleTrait;

    protected function options(): array
    {
        /** @var BaseOptionsField $field */
        $field = $this->_field;
        return collect($field->options)
            ->filter(fn(array $option) => !empty($option['value']) && !empty($option['label']))
            ->map(fn(array $option) => [
                'value' => $option['value'],
                'label' => $option['label'],
            ])
            ->all();
    }

    /**
     * @inheritdoc
     */
    protected function elementQueryParam(): array
    {
        return $this->paramValue();
    }

    /**
     * @inheritdoc
     */
    protected function matchFieldValue($value): bool
    {
        if ($value instanceof MultiOptionsFieldData) {
            $value = array_map(fn(OptionData $option) => $option->value, (array)$value);
        } else if ($value instanceof SingleOptionFieldData) {
            $value = $value->value;
        }

        return $this->matchValue($value);
    }
}
