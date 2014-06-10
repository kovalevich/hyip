<?php
/**
 *
 * @author kovalevich
 * @version
 */
require_once 'Zend/View/Interface.php';

/**
 * Nicetime helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Partnerstable
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function partnerstable ($entries)
    {
        $html = '
        <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Имя</th>
                  <th>Баланс</th>
                </tr>
              </thead>
              <tbody>';

        if (count($entries)) {
            foreach ($entries as $entry) {
                $html .= '
                        <tr class="warning">
                            <td>' . $entry->id . '</td>
                            <td>' . $entry->name . '</td>
                            <td>' . $this->view->number($entry->balance, '', '$') . '</td>
                        </tr>
                        ';

                if($entry->partners){
                    foreach ($entry->partners as $entry1) {
                        $html .= '
                        <tr>
                            <td>' . $entry1->id . '</td>
                            <td>' . $entry1->name . '</td>
                            <td>' . $this->view->number($entry1->balance, '', '$') . '</td>
                        </tr>
                        ';
                    }
                }
            }
        }
        else {
            $html .= '
                        <tr>
                            <td colspan="3">Нет партнеров</td>
                        </tr>
                    ';
        }

        $html .='
              </tbody>
            </table>
          </div>
        ';

        return $html;
    }

    /**
     * Sets the view field
     *
     * @param $view Zend_View_Interface
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }

}