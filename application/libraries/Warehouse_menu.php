<?php 
class Warehouse_menu {
    private $ci;
    function __construct()
    {
        $this->ci =& get_instance();    // get a reference to CodeIgniter.
    }
    
    function build_menu(){
        $menu = '<li class="treeview" id="warehouseMainNav">';
        $menu .= '<a href="#">';
        $menu .= '<i class="fa fa-building"></i> ';
        $menu .= '<span>Warehouses</span>';
        $menu .= '<span class="pull-right-container">';
        $menu .= '<i class="fa fa-angle-right pull-right"></i>';
        $menu .= '</span>';
        $menu .= '</a>';
        $menu .= '<ul class="treeview-menu">';
        $menu .= ' <li id="viewWarehouseSubMenu"><a href="/warehouses"><i class="fa fa-angle-right"></i> Manage Warehouses</a></li>';
        
        $query = $this->ci->db->query("select * from stores WHERE active =1");
        foreach ($query->result() as $row) {
            $id = $row->id;
            $name = $row->name;
            $name_link = str_replace(" ", "-",$name);
            $name_link = strtolower($name_link);
            $menu .= ' <li id="viewWarehouseSubMenu"><a href="/lists-of-products/'.$name_link.'/'.$id.'"><i class="fa fa-angle-right"></i> '.$name.'</a></li>';
        }
        $menu .= '</ul>';
        $menu .= '</li>';
        return $menu;        
    }
}
