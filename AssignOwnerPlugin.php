<?php
/**
 * Assign Owner
 *
 * @copyright Copyright 2013 The Digital Ark, Corp.
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPLv3 or any later version
 * @package AssignOwner
 */

define('ASSIGN_OWNER_PLUGIN_DIR', PLUGIN_DIR . '/Assign');

class AssignOwnerPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_hooks = array(
        'install',
        'uninstall',
        'upgrade',
        'define_acl'
    );

    protected $_filters = array(
        'admin_navigation_main'
    );

    /*
     * Define the default options for install
     */
    protected $_options = array(
        'assign_owner_current_owner'=> ''
    );

    public function hookInstall()
    {
        $this->_installOptions();
    }

    public function hookUninstall()
    {
        $this->_uninstallOptions();
    }

    public function hookUpgrade($args)
    {
    }

    /**
     * Add the Assign Owner link to the admin main navigation.
     *
     * @param array Navigation array.
     * @return array Filtered navigation array.
     */
    public function filterAdminNavigationMain($nav)
    {
        $nav[] = array(
            'label' => __('Assign Owner'),
            'uri' => url('assign-owner'),
            'resource' => 'Assign_Owner_Index',
            'privilege' => 'browse'
        );

        return $nav;
    }

    /**
     * Defines the ACL for the reports controllers.
     *
     * @param Array $args
     */

    public function hookDefineAcl($args)
    {
        $acl = $args['acl'];

        $indexResource = new Zend_Acl_Resource('Assign_Owner_Index');
        $acl->add($indexResource);
        $acl->allow(array('super'), array('Assign_Owner_Index'));
    }
}