<?php
/**
 * Assign Owner
 *
 * @copyright Copyright 2013 The Digital Ark, Corp.
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPLv3 or any later version
 * @package AssignOwner
 */
class AssignOwner_IndexController extends Omeka_Controller_AbstractActionController
{
    /**
     *
     */
    public function init()
    {
        $this->_helper->db->setDefaultModelName('User');
    }

    public function browseAction() {
        // get users
        $db = get_db();
        $userTable = $db->Users;

        $sql = "SELECT * FROM $userTable WHERE role='super' OR role='admin' OR role='contributor'";

        $result = $db->fetchAll($sql);

        $this->view->users = $result;

        // current owner
        $this->view->currentOwnerId = get_option('assign_owner_current_owner');

    }

    public function assignAction() {
        // Allow only AJAX requests.
        if (!$this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->redirector->gotoUrl('/');
        }

        // prohibit full page render for AJAX response
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $user_id = $this->_getParam('user_id');

        $db = get_db();
        $itemsTable = $db->Items;

        // validation needed?
        if (isset($user_id)) {
            $sql = "UPDATE $itemsTable SET `owner_id`=$user_id WHERE `owner_id`!=$user_id";

            if($db->query($sql)) {
                $results = array( 'flashMsg' => 'Assigned' );
            } else {

                $results = array('flashMsg' => 'Did not work');
            }
            $this->_response->setBody(json_encode($results));

        }
    }
}
?>