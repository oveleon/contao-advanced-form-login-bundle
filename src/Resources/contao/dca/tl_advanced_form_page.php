<?php

/*
 * This file is part of Oveleon AdvancedFormLoginBundle.
 *
 * (c) https://www.oveleon.de/
 */
// Add selector to tl_advanced_form_page
$GLOBALS['TL_DCA']['tl_advanced_form_page']['palettes']['__selector__'][]        = 'createMember';
$GLOBALS['TL_DCA']['tl_advanced_form_page']['palettes']['__selector__'][]        = 'assignDir';
$GLOBALS['TL_DCA']['tl_advanced_form_page']['palettes']['__selector__'][]        = 'sendActivationMail';

// Add subpalettes to tl_advanced_form_page
$GLOBALS['TL_DCA']['tl_advanced_form_page']['subpalettes']['createMember']       = 'groups,allowLogin,assignDir,sendActivationMail';
$GLOBALS['TL_DCA']['tl_advanced_form_page']['subpalettes']['assignDir']          = 'homeDir';
$GLOBALS['TL_DCA']['tl_advanced_form_page']['subpalettes']['sendActivationMail'] = 'registrationPage,activationText';

// Add fields to tl_advanced_form_page
$GLOBALS['TL_DCA']['tl_advanced_form_page']['fields']['createMember'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_advanced_form_page']['createMember'],
    'exclude'                 => true,
    'filter'                  => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange'=>true),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_advanced_form_page']['fields']['groups'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_advanced_form_page']['groups'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'foreignKey'              => 'tl_member_group.name',
    'eval'                    => array('multiple'=>true),
    'sql'                     => "blob NULL",
    'relation'                => array('type'=>'hasMany', 'load'=>'lazy')
);

$GLOBALS['TL_DCA']['tl_advanced_form_page']['fields']['allowLogin'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_advanced_form_page']['allowLogin'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_advanced_form_page']['fields']['assignDir'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_advanced_form_page']['assignDir'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange'=>true),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_advanced_form_page']['fields']['homeDir'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_advanced_form_page']['homeDir'],
    'exclude'                 => true,
    'inputType'               => 'fileTree',
    'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr'),
    'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_advanced_form_page']['fields']['sendActivationMail'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_advanced_form_page']['sendActivationMail'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange'=>true),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_advanced_form_page']['fields']['registrationPage'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_advanced_form_page']['registrationPage'],
    'exclude'                 => true,
    'inputType'               => 'pageTree',
    'foreignKey'              => 'tl_page.title',
    'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
    'sql'                     => "int(10) unsigned NOT NULL default '0'",
    'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
);

$GLOBALS['TL_DCA']['tl_advanced_form_page']['fields']['activationText'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_advanced_form_page']['activationText'],
    'exclude'                 => true,
    'inputType'               => 'textarea',
    'eval'                    => array('style'=>'height:120px', 'decodeEntities'=>true, 'alwaysSave'=>true),
    'load_callback' => array
    (
        array('tl_advanced_form_page_login', 'getActivationDefault')
    ),
    'sql'                     => "text NULL"
);

// Extend default palette
Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('member_legend', 'store_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_AFTER)
    ->addField(array('createMember'), 'member_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_advanced_form_page')
;


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <fabian@oveleon.de>
 */
class tl_advanced_form_page_login extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * Load the default activation text
     *
     * @param mixed $varValue
     *
     * @return mixed
     */
    public function getActivationDefault($varValue)
    {
        \System::loadLanguageFile('tl_module');

        if (!trim($varValue))
        {
            $varValue = (\is_array($GLOBALS['TL_LANG']['tl_module']['emailText']) ? $GLOBALS['TL_LANG']['tl_module']['emailText'][1] : $GLOBALS['TL_LANG']['tl_module']['emailText']);
        }

        return $varValue;
    }
}