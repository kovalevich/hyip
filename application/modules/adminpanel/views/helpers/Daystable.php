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
class Zend_View_Helper_Daystable
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function daystable ($entries)
    {
        $html = '
        <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Дата</th>
                  <th>Процент</th>
                  <th>Сумма по процентам</th>
                  <th>Сумма по партнерским</th>
                  <th>Баланс</th>
                </tr>
              </thead>
              <tbody>';

        if (count($entries)) {
            foreach ($entries as $entry) {
                $html .= '
                        <tr>
                            <td>' . date('d.m.Y', strtotime($entry->date)) . '</td>
                            <td>' . $entry->percent . '%</td>
                            <td>' . $entry->additional_sum . '</td>
                            <td>' . $entry->additional_ref_sum . '</td>
                            <td>' . $entry->balance . '</td>
                        </tr>
                        ';
            }
        }
        else {
            $html .= '
                        <tr>
                            <td colspan="4">Нет зачислений</td>
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