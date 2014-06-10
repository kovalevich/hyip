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
class Zend_View_Helper_Eventstable
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function eventstable ($entries, $count = 0)
    {
        $i = $count ? $count : false;
        $html = '
        <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Дата</th>
                  <th>Операция</th>
                </tr>
              </thead>
              <tbody>';

        if (count($entries)) {
            $date = '';
            foreach ($entries as $entry) {
                if ($count && !$i--) break;
                if(date('d.m.Y', strtotime($entry->date)) != $date)
                {
                    $date = date('d.m.Y', strtotime($entry->date));
                    $html .= '
                        <tr>
                            <td colspan="2"><strong>' . $date . '</strong></td>
                        </tr>
                    ';
                }

                $html .= '
                        <tr>
                            <td></td>
                            <td>' . $entry->text . '</td>
                        </tr>
                        ';
            }
        }
        else {
            $html .= '
                        <tr>
                            <td colspan="2">Нет операций</td>
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
