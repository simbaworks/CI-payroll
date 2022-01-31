<?php 
$general_user_type = array("dashboard", "employees", "property_returns");

foreach($modules as $module){
    if($module['controller'] == $controller){ $active_parent = $module['parent_id']; }
    if($module['parent_id'] == 0){
        $modules_arr[$module['id']]['controller_name'] = $module['controller'];
        $modules_arr[$module['id']]['icon_name'] = $module['icon_name'];
        $modules_arr[$module['id']]['name'] = $module['name'];
        $modules_arr[$module['id']]['method_name'] = $module['method_name'];
        $modules_arr[$module['id']]['parent_id'] = $module['parent_id'];
        foreach($modules as $submodule){
            if($module['id'] == $submodule['parent_id']){
                $submodules_arr[$submodule['id']]['controller_name'] = $submodule['controller'];
                $submodules_arr[$submodule['id']]['icon_name'] = $submodule['icon_name'];
                $submodules_arr[$submodule['id']]['name'] = $submodule['name'];
                $submodules_arr[$submodule['id']]['method_name'] = $submodule['method_name'];
                $submodules_arr[$submodule['id']]['parent_id'] = $submodule['parent_id'];
            }
        }
        if(isset($submodules_arr)){
            $modules_arr[$module['id']]['submodules'] = $submodules_arr;
            unset($submodules_arr);
        }
    }
}
// echo "<pre>";
// print_r($modules_arr);
// echo "</pre>";
// exit();
?>
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <?php foreach($modules_arr as $module_id => $module){ ?>
            <?php 
                if ($this->session->userdata($this->data['sess_code'] . 'user_type') !== '0') {
                    if (!in_array($module['controller_name'], $general_user_type)) {
                        continue;
                    }
                }
            ?>
            <?php if(!isset($module['submodules'])){ ?>
                <li class="nav-item">
                    <a href="<?php echo site_url($module['controller_name']); ?>" class="nav-link <?php if ($module['controller_name'] == $controller) { ?>active<?php } ?>">
                        <i class="<?php echo $module['icon_name']; ?> nav-icon mr-2"></i>
                        <p><?php echo $module['name']; ?></p>
                    </a>
                </li>
            <?php }else{?>
                <li class="nav-item <?php if ($module_id == $active_parent) { ?>menu-open<?php } ?>">
                    <a href="#" class="nav-link <?php if ($module_id == $active_parent) { ?>active<?php } ?>">
                      <i class="<?php echo $module['icon_name']; ?> nav-icon mr-2"></i>
                        <p>
                            <?php echo $module['name']; ?>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php foreach($module['submodules'] as $submodule_id => $submodule){ ?>
                            <?php if($module['controller_name'] == $controller){?>
                                <li class="nav-item">
                                    <a href="<?php echo site_url($submodule['controller_name']. '/' .$submodule['method_name']); ?>" class="nav-link <?php if($method == $submodule['method_name']){ echo 'active'; } ?>">
                                        <i class="<?php echo $submodule['icon_name']; ?> nav-icon mr-2"></i>
                                        <p><?php echo $submodule['name']; ?></p>
                                    </a>
                                </li>
                            <?php }else{?>
                                <li class="nav-item">
                                    <a href="<?php echo site_url($submodule['controller_name'] . '/' . $submodule['method_name']); ?>" class="nav-link <?php if($submodule['controller_name'] == $controller){ echo 'active'; } ?>">
                                        <i class="<?php echo $submodule['icon_name']; ?> nav-icon mr-2"></i>
                                        <p><?php echo $submodule['name']; ?></p>
                                    </a>
                                </li>
                            <?php }?>
                        <?php }?>
                    </ul>
                </li>
            <?php }?>
        <?php } ?>
    </ul>
</nav>