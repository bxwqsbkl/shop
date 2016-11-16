<?php

/**
 * @link http://blog.kunx.org/.
 * @copyright Copyright (c) 2016-11-15 
 * @license kunx-edu@qq.com.
 */

namespace Admin\Controller;

/**
 * Description of MenuController
 *
 * @author kunx <kunx-edu@qq.com>
 */
class MenuController extends \Think\Controller {

    /**
     * @var \Admin\Model\MenuModel
     */
    private $_model = null;

    protected function _initialize() {
        $this->_model = D('Menu');
    }

    public function index() {
        $rows = $this->_model->getList();
        $this->assign('rows', $rows);
        $this->display();
    }

    public function add() {
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->addMenu() === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('添加成功', U('index'));
        } else {
            $this->_before_view();
            $this->display();
        }
    }

    public function edit($id) {
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->saveMenu($id) === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功', U('index'));
        } else {
            $this->_before_view();
            //获取数据
            $row = $this->_model->getMenuInfo($id);
            $this->assign('row', $row);
            $this->display('add');
        }
    }

    public function remove($id) {
        if ($this->_model->deleteMenu($id) === false) {
            $this->error(get_error($this->_model));
        } else {
            $this->success('删除成功', U('index'));
        }
    }

    private function _before_view() {
        //获取已有菜单列表,以便设置父级
        $rows = $this->_model->getList();
        array_unshift($rows, ['id' => 0, 'name' => '顶级菜单']);
        $this->assign('menus', json_encode($rows));

        //获取所有的权限列表
        $permissions = D('Permission')->getList();
        $this->assign('permissions', json_encode($permissions));
    }

}
