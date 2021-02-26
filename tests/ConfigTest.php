<?php

use GatherContent\ConfigValueObject\Config;
use GatherContent\ConfigValueObject\ConfigValueException;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    private $fullConfig;

    public function setUp(): void
    {
        parent::setUp();

        $this->fullConfig = array(
            (object)array(
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => array(
                    (object)array(
                        'type' => 'text',
                        'name' => 'el1',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ),
                    (object)array(
                        'type' => 'text',
                        'name' => 'el2',
                        'required' => false,
                        'label' => 'Label',
                        'value' => 'How goes it?',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'chars',
                        'limit' => 500,
                        'plain_text' => true,
                    ),
                    (object)array(
                        'type' => 'files',
                        'name' => 'el3',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                    ),
                    (object)array(
                        'type' => 'section',
                        'name' => 'el4',
                        'title' => 'Title',
                        'subtitle' => '<p>How goes it?</p>',
                    ),
                ),
            ),
            (object)array(
                'label' => 'Meta',
                'name' => 'tab2',
                'hidden' => true,
                'elements' => array(
                    (object)array(
                        'type' => 'choice_radio',
                        'name' => 'el5',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => false,
                        'options' => array(
                            (object)array(
                                'name' => 'op1',
                                'label' => 'First choice',
                                'selected' => false,
                            ),
                            (object)array(
                                'name' => 'op2',
                                'label' => 'Second choice',
                                'selected' => false,
                            ),
                        ),
                    ),
                    (object)array(
                        'type' => 'choice_radio',
                        'name' => 'el6',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => true,
                        'options' => array(
                            (object)array(
                                'name' => 'op3',
                                'label' => 'First choice',
                                'selected' => false,
                            ),
                            (object)array(
                                'name' => 'op4',
                                'label' => 'Second choice',
                                'selected' => true,
                            ),
                            (object)array(
                                'name' => 'op5',
                                'label' => 'Other',
                                'selected' => false,
                                'value' => '',
                            ),
                        ),
                    ),
                    (object)array(
                        'type' => 'choice_radio',
                        'name' => 'el7',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => true,
                        'options' => array(
                            (object)array(
                                'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => false,
                            ),
                            (object)array(
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => false,
                            ),
                            (object)array(
                                'name' => 'op8',
                                'label' => 'Other',
                                'selected' => true,
                                'value' => 'How goes it?',
                            ),
                        ),
                    ),
                    (object)array(
                        'type' => 'choice_checkbox',
                        'name' => 'el8',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => array(
                            (object)array(
                                'name' => 'op9',
                                'label' => 'First choice',
                                'selected' => false,
                            ),
                            (object)array(
                                'name' => 'op10',
                                'label' => 'Second choice',
                                'selected' => false,
                            ),
                        ),
                    ),
                    (object)array(
                        'type' => 'choice_checkbox',
                        'name' => 'el9',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => array(
                            (object)array(
                                'name' => 'op11',
                                'label' => 'First choice',
                                'selected' => true,
                            ),
                            (object)array(
                                'name' => 'op12',
                                'label' => 'Second choice',
                                'selected' => true,
                            ),
                        ),
                    ),
                ),
            ),
        );
    }

    public function testFullConfig()
    {
        $config = new Config($this->fullConfig);
        $result = $config->toArray();

        $this->assertEquals($this->fullConfig, $result);
    }

    public function testCastingToString()
    {
        $originalConfig = array(
            (object)array(
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => array(),
            ),
        );

        $expected = '[{"label":"Content","name":"tab1","hidden":false,"elements":[]}]';

        $config = new Config($originalConfig);
        $result = (string)$config;

        $this->assertEquals($expected, $result);
    }

    public function testEqual()
    {
        $config1 = new Config($this->fullConfig);
        $config2 = new Config($this->fullConfig);

        $result = $config1->equals($config2);

        $this->assertTrue($result);
    }

    public function testNotEqual()
    {
        $originalConfig1 = array(
            (object)array(
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => array(),
            ),
        );

        $originalConfig2 = array(
            (object)array(
                'label' => 'Meta',
                'name' => 'tab2',
                'hidden' => false,
                'elements' => array(),
            ),
        );

        $config1 = new Config($originalConfig1);
        $config2 = new Config($originalConfig2);

        $result = $config1->equals($config2);

        $this->assertFalse($result);
    }

    public function testEqualsIsCaseSensitive()
    {
        $config1 = new Config(array(
            (object)array(
                'label' => 'Content',
                'name' => 'tab',
                'hidden' => false,
                'elements' => array(),
            )
        ));

        $config2 = new Config(array(
            (object)array(
                'label' => 'content',
                'name' => 'tab',
                'hidden' => false,
                'elements' => array(),
            )
        ));

        $result = $config1->equals($config2);

        $this->assertFalse($result);
    }

    public function testCreatingFromJson()
    {
        $expected = $json = '[{"label":"Content","name":"tab1","hidden":false,"elements":[]}]';

        $config = Config::fromJson($json);
        $result = (string)$config;

        $this->assertEquals($expected, $result);
    }

    public function testEmptyConfig()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Config must not be empty');

        $json = '[]';

        Config::fromJson($json);
    }

    public function testRandomArray()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Tab must be an object');

        $json = '["a","s","d","f"]';

        Config::fromJson($json);
    }

    public function testString()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Config must be array');

        $string = 'asdf';

        new Config($string);
    }

    public function testMissingLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Tab label attribute is required');

        unset($this->fullConfig[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingName()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Tab name attribute is required');

        unset($this->fullConfig[0]->name);

        new Config($this->fullConfig);
    }

    public function testMissingHidden()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Tab hidden attribute is required');

        unset($this->fullConfig[0]->hidden);

        new Config($this->fullConfig);
    }

    public function testMissingElements()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Tab elements attribute is required');

        unset($this->fullConfig[0]->elements);

        new Config($this->fullConfig);
    }

    public function testAdditionalAttribute()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Tab must not have additional attributes');

        $this->fullConfig[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Tab label attribute must be string');

        $this->fullConfig[0]->label = true;

        new Config($this->fullConfig);
    }

    public function testInvalidName()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Tab name attribute must be string');

        $this->fullConfig[0]->name = false;

        new Config($this->fullConfig);
    }

    public function testInvalidHidden()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Tab hidden attribute must be boolean');

        $this->fullConfig[0]->hidden = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidElements()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Tab elements attribute must be array');

        $this->fullConfig[0]->elements = 'none';

        new Config($this->fullConfig);
    }

    public function testEmptyLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Tab label attribute must not be empty');

        $this->fullConfig[0]->label = '';

        new Config($this->fullConfig);
    }

    public function testEmptyName()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Tab name attribute must not be empty');

        $this->fullConfig[0]->name = '';

        new Config($this->fullConfig);
    }

    public function testNonUniqueTabNames()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Tab names must be unique');

        $this->fullConfig[0]->name = 'tab1';
        $this->fullConfig[1]->name = 'tab1';

        new Config($this->fullConfig);
    }

    public function testRandomElements()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element must be an object');

        $this->fullConfig[0]->elements = array('a', 's', 'd', 'f');

        new Config($this->fullConfig);
    }

    public function testMissingElementType()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element type attribute is required');

        unset($this->fullConfig[0]->elements[0]->type);

        new Config($this->fullConfig);
    }

    public function testMissingElementName()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element name attribute is required');

        unset($this->fullConfig[0]->elements[0]->name);

        new Config($this->fullConfig);
    }

    public function testInvalidElementType1()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element type attribute must be string');

        $this->fullConfig[0]->elements[0]->type = true;

        new Config($this->fullConfig);
    }

    public function testInvalidElementType2()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element must be of a supported type');

        $this->fullConfig[0]->elements[0]->type = 'asdf';

        new Config($this->fullConfig);
    }

    public function testInvalidElementName()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element name attribute must be string');

        $this->fullConfig[0]->elements[0]->name = 12345;

        new Config($this->fullConfig);
    }

    public function testEmptyElementName()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element name attribute must not be empty');

        $this->fullConfig[0]->elements[0]->name = '';

        new Config($this->fullConfig);
    }

    public function testMissingTextRequired()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element required attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->required);

        new Config($this->fullConfig);
    }

    public function testMissingTextLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element label attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingTextValue()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element value attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->value);

        new Config($this->fullConfig);
    }

    public function testMissingTextMicrocopy()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element microcopy attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->microcopy);

        new Config($this->fullConfig);
    }

    public function testMissingTextLimitType()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element limit_type attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->limit_type);

        new Config($this->fullConfig);
    }

    public function testMissingTextLimit()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element limit attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->limit);

        new Config($this->fullConfig);
    }

    public function testMissingTextPlainText()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element plain_text attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->plain_text);

        new Config($this->fullConfig);
    }

    public function testAdditionalTextAttribute()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element must not have additional attributes');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidTextRequired()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element required attribute must be boolean');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->required = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidTextLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element label attribute must be string');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidTextValue()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element value attribute must be string');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->value = array('test');

        new Config($this->fullConfig);
    }

    public function testInvalidTextMicrocopy()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element microcopy attribute must be string');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->microcopy = false;

        new Config($this->fullConfig);
    }

    public function testInvalidTextLimitType()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element limit_type attribute value must be either "words" or "chars"');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit_type = 'characters';

        new Config($this->fullConfig);
    }

    public function testInvalidTextLimit1()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element limit attribute must be integer');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit = '0';

        new Config($this->fullConfig);
    }

    public function testInvalidTextLimit2()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element limit attribute must not be negative');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit = -50;

        new Config($this->fullConfig);
    }

    public function testInvalidTextLimit3()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element limit attribute must be integer');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit = false;

        new Config($this->fullConfig);
    }

    public function testInvalidTextLimit4()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element limit attribute must be integer');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit = 'three';

        new Config($this->fullConfig);
    }

    public function testInvalidTextPlainText()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element plain_text attribute must be boolean');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->plain_text = 'false';

        new Config($this->fullConfig);
    }

    public function testEmptyTextLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element label attribute must not be empty');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->label = '';

        new Config($this->fullConfig);
    }

    public function testMissingFilesRequired()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element required attribute is required');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        unset($this->fullConfig[0]->elements[2]->required);

        new Config($this->fullConfig);
    }

    public function testMissingFilesLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element label attribute is required');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        unset($this->fullConfig[0]->elements[2]->label);

        new Config($this->fullConfig);
    }

    public function testMissingFilesMicrocopy()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element microcopy attribute is required');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        unset($this->fullConfig[0]->elements[2]->microcopy);

        new Config($this->fullConfig);
    }

    public function testAdditionalFilesAttribute()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element must not have additional attributes');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidFilesRequired()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element required attribute must be boolean');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->required = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidFilesLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element label attribute must be string');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidFilesMicrocopy()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element microcopy attribute must be string');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->microcopy = false;

        new Config($this->fullConfig);
    }

    public function testEmptyFilesLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element label attribute must not be empty');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->label = '';

        new Config($this->fullConfig);
    }

    public function testMissingSectionTitle()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element title attribute is required');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        unset($this->fullConfig[0]->elements[3]->title);

        new Config($this->fullConfig);
    }

    public function testMissingSectionSubtitle()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element subtitle attribute is required');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        unset($this->fullConfig[0]->elements[3]->subtitle);

        new Config($this->fullConfig);
    }

    public function testAdditionalSectionAttribute()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element must not have additional attributes');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        $this->fullConfig[0]->elements[3]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidSectionTitle()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element title attribute must be string');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        $this->fullConfig[0]->elements[3]->title = null;

        new Config($this->fullConfig);
    }

    public function testInvalidSectionSubtitle()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element subtitle attribute must be string');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        $this->fullConfig[0]->elements[3]->subtitle = null;

        new Config($this->fullConfig);
    }

    public function testEmptySectionTitle()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element title attribute must not be empty');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        $this->fullConfig[0]->elements[3]->title = '';

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioRequired()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element required attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->required);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element label attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioMicrocopy()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element microcopy attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->microcopy);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOtherOption()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element other_option attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->other_option);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptions()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element options attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptionName()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option name attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options[0]->name);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptionLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option label attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptionSelected()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option selected attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options[0]->selected);

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceRadioAttribute()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element must not have additional attributes');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceRadioOptionAttribute()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option must not have additional attributes');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceRadioOtherOptionAttribute()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option must not have additional attributes');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);

        $this->fullConfig[1]->elements[1]->options[2]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioRequired()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element required attribute must be boolean');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->required = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element label attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioMicrocopy()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element microcopy attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->microcopy = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOtherOption()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element other_option attribute must be boolean');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->other_option = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptions()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element options attribute must be array');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options = 'none';

        new Config($this->fullConfig);
    }

    public function testEmptyChoiceRadioLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element label attribute must not be empty');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->label = '';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionName()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option name attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->name = 1;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option label attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionSelected()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option selected attribute must be boolean');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->selected = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionValues()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option value attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);

        $this->fullConfig[1]->elements[1]->options[2]->value = false;

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxRequired()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element required attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->required);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element label attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->label);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxMicrocopy()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element microcopy attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->microcopy);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptions()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element options attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptionName()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option name attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options[0]->name);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptionLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option label attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptionSelected()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option selected attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options[0]->selected);

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceCheckboxAttribute()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element must not have additional attributes');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceCheckboxOptionAttribute()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option must not have additional attributes');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxRequired()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element required attribute must be boolean');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->required = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element label attribute must be string');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxMicrocopy()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element microcopy attribute must be string');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->microcopy = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptions()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element options attribute must be array');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options = 'asdf';

        new Config($this->fullConfig);
    }

    public function testEmptyChoiceCheckboxLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element label attribute must not be empty');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->label = '';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptionName()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option name attribute must be string');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->name = 6;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptionLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option label attribute must be string');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptionSelected()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option selected attribute must be boolean');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->selected = 'false';

        new Config($this->fullConfig);
    }

    public function testEmptyChoiceCheckboxOptionLabel()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option label attribute must not be empty');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->label = '';

        new Config($this->fullConfig);
    }

    public function testNonUniqueElementNames()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element names must be unique');

        $this->fullConfig[0]->elements[0]->name = 'el12345';
        $this->fullConfig[0]->elements[1]->name = 'el12345';

        new Config($this->fullConfig);
    }

    public function testNonUniqueOptionNames()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option names must be unique');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->name = 'op6';
        $this->fullConfig[1]->elements[3]->options[1]->name = 'op6';

        new Config($this->fullConfig);
    }

    public function testOptionNamesAreAllowedToBeReusedAccrossElements()
    {
        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[0]->options[0]->name = 'op12345';
        $this->fullConfig[1]->elements[1]->options[0]->name = 'op12345';

        new Config($this->fullConfig);
    }

    public function testNoOptionsForChoiceRadio()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element must have at least one option');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options = array();

        new Config($this->fullConfig);
    }

    public function testNoOptionsForChoiceCheckbox()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element must have at least one option');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options = array();

        new Config($this->fullConfig);
    }

    public function testNonObjectOptionForChoiceRadio()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option must be an object');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0] = (array)$this->fullConfig[1]->elements[0]->options[0];

        new Config($this->fullConfig);
    }

    public function testNonObjectOptionForChoiceCheckbox()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option must be an object');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0] = (array)$this->fullConfig[1]->elements[3]->options[0];

        new Config($this->fullConfig);
    }

    public function testMultipleOptionsSelectedForChoiceRadio()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Element choice_radio must have at most one option selected');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->selected = true;
        $this->fullConfig[1]->elements[0]->options[1]->selected = true;

        new Config($this->fullConfig);
    }

    public function testMissingOtherOptionValueForChoiceRadio()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option value attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);

        unset($this->fullConfig[1]->elements[1]->options[2]->value);

        new Config($this->fullConfig);
    }

    public function testUnnecessaryOptionValueForChoiceRadio()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option must not have additional attributes');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);
        $this->assertFalse($this->fullConfig[1]->elements[0]->other_option);

        $this->fullConfig[1]->elements[0]->options[1]->value = '';

        new Config($this->fullConfig);
    }

    public function testOtherOptionValueOnOtherThanLastOptionForChoiceRadio()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option must not have additional attributes');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);

        $this->fullConfig[1]->elements[1]->options[0]->value = '';

        new Config($this->fullConfig);
    }

    public function testEmptyOptionLabelForChoiceRadio()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option label attribute must not be empty');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);
        $this->assertFalse($this->fullConfig[1]->elements[0]->other_option);

        $this->fullConfig[1]->elements[0]->options[1]->label = '';

        new Config($this->fullConfig);
    }

    public function testEmptyOtherOptionLabelForChoiceRadio()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Option label attribute must not be empty');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);
        $this->assertObjectHasAttribute('value', $this->fullConfig[1]->elements[1]->options[2]);

        $this->fullConfig[1]->elements[1]->options[2]->label = '';

        new Config($this->fullConfig);
    }

    public function testOtherOptionValueEmptyIfOtherOptionNotSelectedForChoiceRadio()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Other option value must be empty when other option not selected');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertEquals(3, count($this->fullConfig[1]->elements[1]->options));
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);
        $this->assertFalse($this->fullConfig[1]->elements[1]->options[2]->selected);

        $this->fullConfig[1]->elements[1]->options[2]->value = 'this value should be empty';

        new Config($this->fullConfig);
    }

    public function testOtherOptionMustNotBeTheOnlyOptionForChoiceRadio()
    {
        $this->expectException('GatherContent\ConfigValueObject\ConfigValueException');
        $this->expectExceptionMessage('Other option must not be the only option');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);
        $this->assertEquals(3, count($this->fullConfig[1]->elements[1]->options));
        $this->assertObjectHasAttribute('selected', $this->fullConfig[1]->elements[1]->options[2]);

        unset($this->fullConfig[1]->elements[1]->options[1]);
        unset($this->fullConfig[1]->elements[1]->options[0]);

        $this->assertEquals(1, count($this->fullConfig[1]->elements[1]->options));

        new Config($this->fullConfig);
    }

    public function testZeroDigitInVariousPlaces()
    {
        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->label = '0';
        $this->fullConfig[0]->name = '0';
        $this->fullConfig[0]->elements[0]->label = '0';
        $this->fullConfig[0]->elements[0]->name = '0';

        $config = new Config($this->fullConfig);
        $result = $config->toArray();

        $this->assertEquals($this->fullConfig, $result);
    }

}
