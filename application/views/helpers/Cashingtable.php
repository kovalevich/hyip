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
class Zend_View_Helper_Cashingtable
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function cashingtable ($entries)
    {
        $html = '
        <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Дата подачи заявки</th>
                  <th>Тип</th>
                  <th>Сумма</th>
                  <th>Примечание</th>
                  <th>Статус</th>
                </tr>
              </thead>
              <tbody>';

        if (count($entries)) {
            foreach ($entries as $entry) {
                $html .= '
                        <tr>
                            <td>' . $entry->id . '</td>
                            <td>' . date('d.m.Y', strtotime($entry->created)) . '</td>
                            <td>' . ($entry->type == 2 ? 'пополнение баланса' : 'вывод средств') . '</td>
                            <td>' . $this->view->number($entry->sum, '', '$') . '</td>
                            <td>' . $entry->description . '</td>
                            <td>' . ($entry->status == 0 ? 'ожидает' : 'выполнено') . '</td>
                        </tr>
                        ';
            }
        }
        else {
            $html .= '
                        <tr>
                            <td colspan="5">Нет заявок</td>
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