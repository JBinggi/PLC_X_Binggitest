<?php
/**
 * BinggitestController.php - Main Controller
 *
 * Main Controller Binggitest Module
 *
 * @category Controller
 * @package Binggitest
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Binggitest\Controller;

use Application\Controller\CoreController;
use Application\Model\CoreEntityModel;
use OnePlace\Binggitest\Model\Binggitest;
use OnePlace\Binggitest\Model\BinggitestTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class BinggitestController extends CoreController {
    /**
     * Binggitest Table Object
     *
     * @since 1.0.0
     */
    private $oTableGateway;

    /**
     * BinggitestController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param BinggitestTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,BinggitestTable $oTableGateway,$oServiceManager) {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'binggitest-single';
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);

        if($oTableGateway) {
            # Attach TableGateway to Entity Models
            if(!isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    /**
     * Binggitest Index
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function indexAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('binggitest');

        # Add Buttons for breadcrumb
        $this->setViewButtons('binggitest-index');

        # Set Table Rows for Index
        $this->setIndexColumns('binggitest-index');

        # Get Paginator
        $oPaginator = $this->oTableGateway->fetchAll(true);
        $iPage = (int) $this->params()->fromQuery('page', 1);
        $iPage = ($iPage < 1) ? 1 : $iPage;
        $oPaginator->setCurrentPageNumber($iPage);
        $oPaginator->setItemCountPerPage(3);

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('binggitest-index',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        return new ViewModel([
            'sTableName'=>'binggitest-index',
            'aItems'=>$oPaginator,
        ]);
    }

    /**
     * Binggitest Add Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function addAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('binggitest');

        # Get Request to decide wether to save or display form
        $oRequest = $this->getRequest();

        # Display Add Form
        if(!$oRequest->isPost()) {
            # Add Buttons for breadcrumb
            $this->setViewButtons('binggitest-single');

            # Load Tabs for View Form
            $this->setViewTabs($this->sSingleForm);

            # Load Fields for View Form
            $this->setFormFields($this->sSingleForm);

            # Log Performance in DB
            $aMeasureEnd = getrusage();
            $this->logPerfomance('binggitest-add',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

            return new ViewModel([
                'sFormName' => $this->sSingleForm,
            ]);
        }

        # Get and validate Form Data
        $aFormData = $this->parseFormData($_REQUEST);

        # Save Add Form
        $oBinggitest = new Binggitest($this->oDbAdapter);
        $oBinggitest->exchangeArray($aFormData);
        $iBinggitestID = $this->oTableGateway->saveSingle($oBinggitest);
        $oBinggitest = $this->oTableGateway->getSingle($iBinggitestID);

        # Save Multiselect
        $this->updateMultiSelectFields($_REQUEST,$oBinggitest,'binggitest-single');

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('binggitest-save',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        # Display Success Message and View New Binggitest
        $this->flashMessenger()->addSuccessMessage('Binggitest successfully created');
        return $this->redirect()->toRoute('binggitest',['action'=>'view','id'=>$iBinggitestID]);
    }

    /**
     * Binggitest Edit Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function editAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('binggitest');

        # Get Request to decide wether to save or display form
        $oRequest = $this->getRequest();

        # Display Edit Form
        if(!$oRequest->isPost()) {

            # Get Binggitest ID from URL
            $iBinggitestID = $this->params()->fromRoute('id', 0);

            # Try to get Binggitest
            try {
                $oBinggitest = $this->oTableGateway->getSingle($iBinggitestID);
            } catch (\RuntimeException $e) {
                echo 'Binggitest Not found';
                return false;
            }

            # Attach Binggitest Entity to Layout
            $this->setViewEntity($oBinggitest);

            # Add Buttons for breadcrumb
            $this->setViewButtons('binggitest-single');

            # Load Tabs for View Form
            $this->setViewTabs($this->sSingleForm);

            # Load Fields for View Form
            $this->setFormFields($this->sSingleForm);

            # Log Performance in DB
            $aMeasureEnd = getrusage();
            $this->logPerfomance('binggitest-edit',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

            return new ViewModel([
                'sFormName' => $this->sSingleForm,
                'oBinggitest' => $oBinggitest,
            ]);
        }

        $iBinggitestID = $oRequest->getPost('Item_ID');
        $oBinggitest = $this->oTableGateway->getSingle($iBinggitestID);

        # Update Binggitest with Form Data
        $oBinggitest = $this->attachFormData($_REQUEST,$oBinggitest);

        # Save Binggitest
        $iBinggitestID = $this->oTableGateway->saveSingle($oBinggitest);

        $this->layout('layout/json');

        # Save Multiselect
        $this->updateMultiSelectFields($_REQUEST,$oBinggitest,'binggitest-single');

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('binggitest-save',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        # Display Success Message and View New User
        $this->flashMessenger()->addSuccessMessage('Binggitest successfully saved');
        return $this->redirect()->toRoute('binggitest',['action'=>'view','id'=>$iBinggitestID]);
    }

    /**
     * Binggitest View Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function viewAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('binggitest');

        # Get Binggitest ID from URL
        $iBinggitestID = $this->params()->fromRoute('id', 0);

        # Try to get Binggitest
        try {
            $oBinggitest = $this->oTableGateway->getSingle($iBinggitestID);
        } catch (\RuntimeException $e) {
            echo 'Binggitest Not found';
            return false;
        }

        # Attach Binggitest Entity to Layout
        $this->setViewEntity($oBinggitest);

        # Add Buttons for breadcrumb
        $this->setViewButtons('binggitest-view');

        # Load Tabs for View Form
        $this->setViewTabs($this->sSingleForm);

        # Load Fields for View Form
        $this->setFormFields($this->sSingleForm);

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('binggitest-view',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        return new ViewModel([
            'sFormName'=>$this->sSingleForm,
            'oBinggitest'=>$oBinggitest,
        ]);
    }
}
