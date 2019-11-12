<?php
class Model_nav extends CI_Model {

    private static $defaultOrder = 'id';

    public function __construct()
    {
        $this->load->database();
    }

    public function getNavBar($order, $admin=false)
    {
        $orderBy = $order ?? self::$defaultOrder;
        $query = $this->db->query("SELECT * FROM nav ORDER BY $orderBy");
        foreach ($query->result_array() as $row) {
            $data[$row['id']]= $row;
        }

        function view_cat($dataset, $admin) {
            $arr = '';

            foreach ($dataset as $menu) {
                if (!empty($menu["href"]))
                    if ($admin)
                        $arr .= '<li><a href="'.$menu["href"].'">'.$menu["title"]."</a>".'<a href="/navBar/editItem?parent_id='.$menu["id"].'&action=add">➕</a> <a href="/navBar/editItem?id='.$menu["id"].'&action=delete">➖</a> <a href="/navBar/editItem?id='.$menu["id"].'&action=edit">✎</a>';
                    else
                        $arr .= '<li><a href="'.$menu["href"].'">'.$menu["title"]."</a>";
                else
                    if ($admin)
                        $arr .= '<li>'.$menu["title"].'<a href="/navBar/editItem?parent_id='.$menu["id"].'&action=add">➕</a> <a href="/navBar/editItem?id='.$menu["id"].'&action=delete">➖</a> <a href="/navBar/editItem?id='.$menu["id"].'&action=edit">✎</a>';
                    else
                        $arr .= '<li>'.$menu["title"];

                if(!empty($menu['childs'])) {
                    $arr .= '<ul>';
                    $arr .= view_cat($menu['childs'], $admin);
                    $arr .= '</ul>';
                }

                $arr .= '</li>';
            }

            return $arr;
        }

        function mapTree($dataset) {
            $tree = array();

            foreach ($dataset as $id=>&$node) {

                if (!$node['parent']) {
                    $tree[$id] = &$node;
                }
                else {
                    $dataset[$node['parent']]['childs'][$id] = &$node;
                }
            }
            return $tree;
        }

        $navBarDone = mapTree($data);

        if ($admin)
            $navBarReturn = '<ul class="tree">'.view_cat($navBarDone, $admin).'<li><a href="/navBar/editItem?parent_id=0&action=add">➕</a></li></ul>';
        else
            $navBarReturn = '<ul class="tree">'.view_cat($navBarDone, $admin).'</ul>';
        
        return $navBarReturn;
    }

    public function getOneItem($id)
    {
        $query = $this->db->query("SELECT * FROM nav WHERE id='$id'");
        foreach ($query->result_array() as $row) {
            $data = $row;
        }

        return $data;
    }

    public function search($request)
    {
        $s = htmlspecialchars($request);

        $query = $this->db->query("SELECT * FROM nav WHERE title LIKE '%$s%'");
        $i = 0;
        foreach ($query->result_array() as $row) {
            $nav[$i]['id']     = $row['id'];
            $nav[$i]['href']   = $row['href'];
            $nav[$i]['title']  = $row['title'];
            $nav[$i]['parent'] = $row['parent'];
            $i++;
        }

        return $nav;
    }
    
    public function add($parent_id, $title, $href)
    {
        $this->db->query("INSERT INTO nav (parent, title, href) VALUES ('$parent_id', '$title', '$href')");
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM nav WHERE id = '$id'");
    }

    public function edit($id, $title, $href)
    {
        $this->db->query("UPDATE nav SET title='$title', href='$href' WHERE id = '$id'");
    }

}
?>