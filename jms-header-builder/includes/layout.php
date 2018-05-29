<?php
/*
* Plugin Name: JMS Header Builder
* Plugin URI: http://joommasters.com
* Description: Create Header.
* Version: 1.0.0
* Author: Joommasters
* Author URI: http://joommasters.com
* License:     GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: jmsheaderbuilder
*/
global $pagenow;
global $post;
$wr_link_admin = admin_url();
$header_data = ( array )$post;
$header_id = $header_data['ID'];
if ($header_data['post_content']) {
    if (is_serialized($header_data['post_content'])) {
        $hb_post_content = unserialize($header_data['post_content']);
    } else {
        $hb_post_content = json_decode($header_data['post_content'], true);
    }
}

?>
<div id="hb-app" data-id="<?php echo intval($wr_nitro_header_id); ?>" class="hb-wrapper" style="">
    <div class="hb-header">
        <a href="javascript:void(0);" id="jms_add_row_btn" title="add row">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
        </a>
        <div class="action-save">
            <div id="btn-save-header" class="button button-primary button-large">
                <?php
                if ($pagenow == 'post-new.php') {
                    esc_html_e('Publish', 'jmsheaderbuilder');
                } else {
                    esc_html_e('Update', 'jmsheaderbuilder');
                }
                ?>
            </div>
        </div>
    </div>

    <div class="hb-wrapper-action">
        <div class="hb-list-element">
            <div class="header-item element-item" data-item="search">
                <i class="fa fa-search"></i>
                <span><?php esc_html_e('Search', 'jmsheaderbuilder'); ?></span>
                <div class="addon-tools">
                    <a class="addon-action duplicate-addon"><i class="fa fa-clone"></i></a>
                    <a class="addon-action remove-addon"><i class="fa fa-trash"></i></a>
                </div>
            </div>
            <div class="header-item element-item" data-item="menu">
                <i class="fa fa-location-arrow"></i>
                <span><?php esc_html_e('Menu', 'jmsheaderbuilder'); ?></span>
                <div class="addon-tools">
                    <a class="addon-action duplicate-addon"><i class="fa fa-clone"></i></a>
                    <a class="addon-action remove-addon"><i class="fa fa-trash"></i></a>
                </div>
            </div>
            <div class="header-item element-item" data-item="sidebar">
                <i class="fa fa-tasks"></i>
                <span><?php esc_html_e('Sidebar', 'jmsheaderbuilder'); ?></span>
                <div class="addon-tools">
                    <a class="addon-action edit-addon-sidebar"><i class="fa fa-pencil-square-o"></i></a>
                    <a class="addon-action duplicate-addon"><i class="fa fa-clone"></i></a>
                    <a class="addon-action remove-addon"><i class="fa fa-trash"></i></a>
                </div>
                <div class="hb-input-group">
                    <input type="hidden" name="sidebar-list" value="" class="addon-input" data-bind="sidebar-list">
                    <input type="hidden" name="sidebar-pos" value="" class="addon-input" data-bind="sidebar-pos">
                    <input type="hidden" name="sidebar-icon-class" value="" class="addon-input"
                           data-bind="sidebar-icon-class">
                </div>
            </div>
            <div class="header-item element-item" data-item="text">
                <i class="fa fa-font"></i>
                <span><?php esc_html_e('Text', 'jmsheaderbuilder'); ?></span>
                <div class="addon-tools">
                    <a class="addon-action edit-addon-text"><i class="fa fa-pencil-square-o"></i></a>
                    <a class="addon-action duplicate-addon"><i class="fa fa-clone"></i></a>
                    <a class="addon-action remove-addon"><i class="fa fa-trash"></i></a>
                </div>
                <div class="hb-input-group">
                    <input type="hidden" name="className" value="" class="addon-input" data-bind="className">
                    <input type="hidden" name="ID" value="" class="addon-input" data-bind="ID">
                    <input type="hidden" name="hb-text-content" value="" class="addon-input" data-bind="hb-text-content">
                </div>
            </div>
            <div class="header-item element-item" data-item="logo">
                <i class="fa fa-dot-circle-o"></i>
                <span><?php esc_html_e('Logo', 'jmsheaderbuilder'); ?></span>
                <div class="addon-tools">
                    <a class="addon-action edit-addon-logo"><i class="fa fa-pencil-square-o"></i></a>
                    <a class="addon-action duplicate-addon"><i class="fa fa-clone"></i></a>
                    <a class="addon-action remove-addon"><i class="fa fa-trash"></i></a>
                </div>
                <div class="hb-input-group">
                    <input type="hidden" name="logo-type" value="" class="addon-input" data-bind="logo-type"/>
                    <input type="hidden" name="logo-image-url" value="" class="addon-input" data-bind="logo-image-url"/>
                    <input type="hidden" name="logo-width" value="" class="addon-input" data-bind="logo-width"/>

                    <input type="hidden" name="logo-text" value="" class="addon-input" data-bind="logo-text"/>
                    <input type="hidden" name="logo-color" value="" class="addon-input" data-bind="logo-color"/>
                    <input type="hidden" name="logo-font-size" value="" class="addon-input" data-bind="logo-font-size"/>
                    <input type="hidden" name="logo-line-height" value="" class="addon-input"
                           data-bind="logo-line-height"/>
                    <input type="hidden" name="logo-letter-spacing" value="" class="addon-input"
                           data-bind="logo-letter-spacing"/>

                    <input type="hidden" name="className" value="" class="addon-input" data-bind="className"/>
                    <input type="hidden" name="ID" value="" class="addon-input" data-bind="ID"/>
                </div>
            </div>
            <div class="header-item element-item" data-item="socials">
                <i class="fa fa-share-alt"></i>
                <span><?php esc_html_e('Socials', 'jmsheaderbuilder'); ?></span>
                <div class="addon-tools">
                    <a class="addon-action edit-addon-socials"><i class="fa fa-pencil-square-o"></i></a>
                    <a class="addon-action duplicate-addon"><i class="fa fa-clone"></i></a>
                    <a class="addon-action remove-addon"><i class="fa fa-trash"></i></a>
                </div>
                <div class="hb-input-group">
                    <input type="hidden" name="facebook-link" value="#" class="addon-input" data-bind="facebook-link"/>
                    <input type="hidden" name="googleplus-link" value="#" class="addon-input"
                           data-bind="googleplus-link"/>
                    <input type="hidden" name="instagram-link" value="#" class="addon-input"
                           data-bind="instagram-link"/>
                    <input type="hidden" name="printerest-link" value="#" class="addon-input"
                           data-bind="printerest-link"/>
                    <input type="hidden" name="twitter-link" value="#" class="addon-input" data-bind="twitter-link"/>
                    <input type="hidden" name="youtube-link" value="#" class="addon-input" data-bind="youtube-link"/>
                </div>
            </div>

            <?php if ($wr_is_woocommerce_activated) { ?>
                <div class="header-item element-item" data-item="shopping-cart">
                    <i class="fa fa-shopping-cart"></i>
                    <span>
                        <?php esc_html_e('Cart', 'jmsheaderbuilder'); ?>
                    </span>
                    <div class="addon-tools">
                        <a class="addon-action duplicate-addon"><i class="fa fa-clone"></i></a>
                        <a class="addon-action remove-addon"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="jms-header-wrapper">
            <div id="rowlist">
                <div class="hb-content">
                    <?php
                    if (isset($hb_post_content) && count($hb_post_content) > 0) {
                        foreach ($hb_post_content as $row) {
                            ?>
                            <div class="row row-active" data-name="<?php echo $row["name"]; ?>" data-fluid="0"
                                 data-layout="<?php echo $row["layout"]; ?>" data-active="1">
                                <div class="row-input-group">
                                    <input type="hidden" name="name" value="" class="row-input" data-bind="name"/>
                                    <input type="hidden" name="row-class" value="" class="row-input" data-bind="row-class"/>
                                </div>
                                <div class="row-title">
                                    <div class="pull-left">
                                        <span><i class="fa fa-arrows"></i></span>
                                        <strong class="row-name"><?php echo $row["name"]; ?></strong>
                                    </div>
                                    <div class="pull-right">
                                        <ul aria-labelledby="dLabel" role="menu" class="button-group">
                                            <li class="layout-action">
                                                <a class="btn btn-default label-tooltip"
                                                   data-original-title="Row Layout"><i class="fa fa-th"></i></a>
                                                <ul class="column-list">
                                                    <li class="layout-active"><a href="#"
                                                                                 class="column-layout label-tooltip column-layout-12 "
                                                                                 data-layout="12"
                                                                                 data-original-title="12"></a></li>
                                                    <li><a href="#"
                                                           class="column-layout label-tooltip column-layout-66 "
                                                           data-layout="6,6" data-original-title="6,6"></a></li>
                                                    <li><a href="#"
                                                           class="column-layout label-tooltip column-layout-444 "
                                                           data-layout="4,4,4" data-original-title="4,4,4"></a></li>
                                                    <li><a href="#"
                                                           class="column-layout label-tooltip column-layout-3333 "
                                                           data-layout="3,3,3,3" data-original-title="3,3,3,3"></a></li>
                                                    <li><a href="#"
                                                           class="column-layout label-tooltip column-layout-48 "
                                                           data-layout="4,8" data-original-title="4,8"></a></li>
                                                    <li><a href="#"
                                                           class="column-layout label-tooltip column-layout-39 active"
                                                           data-layout="3,9" data-original-title="3,9"></a></li>
                                                    <li><a href="#"
                                                           class="column-layout label-tooltip column-layout-363 "
                                                           data-layout="3,6,3" data-original-title="3,6,3"></a></li>
                                                    <li><a href="#"
                                                           class="column-layout label-tooltip column-layout-264 "
                                                           data-layout="2,6,4" data-original-title="2,6,4"></a></li>
                                                    <li><a href="#"
                                                           class="column-layout label-tooltip column-layout-210 "
                                                           data-layout="2,10" data-original-title="2,10"></a></li>
                                                    <li><a href="#"
                                                           class="column-layout label-tooltip column-layout-57 "
                                                           data-layout="5,7" data-original-title="5,7"></a></li>
                                                    <li><a href="#"
                                                           class="column-layout label-tooltip column-layout-237 "
                                                           data-layout="2,3,7" data-original-title="2,3,7"></a></li>
                                                    <li><a href="#"
                                                           class="column-layout label-tooltip column-layout-255 "
                                                           data-layout="2,5,5" data-original-title="2,5,5"></a></li>
                                                    <li><a href="#"
                                                           class="column-layout label-tooltip column-layout-282 "
                                                           data-layout="2,8,2" data-original-title="2,8,2"></a></li>
                                                    <li><a href="#"
                                                           class="column-layout label-tooltip column-layout-2442 "
                                                           data-layout="2,4,4,2" data-original-title="2,4,4,2"></a></li>
                                                    <li><a data-original-title="Custom Layout" data-layout="custom"
                                                           class="column-layout column-layout-custom label-tooltip"
                                                           href="#"></a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a class="btn btn-default row-setting label-tooltip"
                                                   data-original-title="Row Setting"><i class="fa fa-cogs"></i></a>
                                            </li>
                                            <a class="btn btn-default active-row label-tooltip"
                                               data-original-title="UnActive Row"><i class="fa fa-check"></i></a>
                                            <li>
                                                <a class="btn btn-default duplicate-row label-tooltip"
                                                   data-original-title="Duplicate Row"><i class="fa fa-clone"></i></a>
                                            </li>
                                            <li>
                                                <a class="btn btn-default remove-row label-tooltip"
                                                   data-original-title="Delete This Row"><i class="fa fa-trash"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row-columns ui-sortable">
                                    <?php
                                    foreach ($row['cols'] as $col) {
                                        ?>
                                        <div class="<?php echo $col['className']; ?>">
                                            <div class="column ui-sortable">
                                                <?php
                                                foreach ($col['addons'] as $addon) {
                                                    ?>
                                                    <div class="header-item element-item ui-draggable ui-draggable-handle"
                                                         data-item="<?php echo $addon['addon_name']; ?>"
                                                         style="width: 82px; right: auto; height: 32px; bottom: auto; opacity: 1;">
                                                        <i class="<?php echo $addon['icon_class']; ?>"></i>
                                                        <span>
                                                                <?php echo $addon['addon_name']; ?>
                                                            </span>
                                                        <div class="addon-tools">
                                                            <?php if ($addon['addon_name'] == 'text' || $addon['addon_name'] == 'logo' || $addon['addon_name'] == 'socials' || $addon['addon_name'] == 'sidebar') { ?>
                                                                <a class="addon-action edit-addon-<?php echo $addon['addon_name']; ?>">
                                                                    <i class="fa fa-pencil-square-o"></i></a>
                                                            <?php } ?>
                                                            <a class="addon-action duplicate-addon"><i
                                                                        class="fa fa-clone"></i></a>
                                                            <a class="addon-action remove-addon"><i
                                                                        class="fa fa-trash"></i></a>
                                                        </div>
                                                        <?php if ($addon['addon_name'] == 'text') {
                                                            ?>
                                                            <div class="hb-input-group">
                                                                <?php
                                                                if (count($addon['fields']) > 0) {
                                                                    foreach ($addon['fields'] as $field) {
                                                                        ?>
                                                                        <input type="hidden"
                                                                               name="<?php echo $field["name"]; ?>"
                                                                               value="<?php echo $field["value"]; ?>"
                                                                               data-bind="<?php echo $field["name"]; ?>"
                                                                               class="addon-input"/>
                                                                    <?php }
                                                                } else {
                                                                    ?>
                                                                    <input type="hidden" name="className" value=""
                                                                           class="addon-input" data-bind="className"/>
                                                                    <input type="hidden" name="ID" value=""
                                                                           class="addon-input" data-bind="ID"/>
                                                                    <input type="hidden" name="hb-text-content" value=""
                                                                           class="addon-input"
                                                                           data-bind="hb-text-content"/>
                                                                    <?php
                                                                } ?>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($addon['addon_name'] == 'logo') {
                                                            ?>
                                                            <div class="hb-input-group">
                                                                <?php
                                                                if (count($addon['fields']) > 0) {
                                                                    foreach ($addon['fields'] as $field) {
                                                                        ?>
                                                                        <input type="hidden"
                                                                               name="<?php echo $field["name"]; ?>"
                                                                               value="<?php echo $field["value"]; ?>"
                                                                               data-bind="<?php echo $field["name"]; ?>"
                                                                               class="addon-input"/>
                                                                    <?php }
                                                                } else { ?>
                                                                    <input type="hidden" name="logo-type" value=""
                                                                           class="addon-input" data-bind="logo-type"/>
                                                                    <input type="hidden" name="logo-image-url" value=""
                                                                           class="addon-input"
                                                                           data-bind="logo-image-url"/>
                                                                    <input type="hidden" name="logo-width" value=""
                                                                           class="addon-input" data-bind="logo-width"/>
                                                                    <input type="hidden" name="logo-text" value=""
                                                                           class="addon-input" data-bind="logo-text"/>
                                                                    <input type="hidden" name="logo-color" value=""
                                                                           class="addon-input" data-bind="logo-color"/>
                                                                    <input type="hidden" name="logo-font-size" value=""
                                                                           class="addon-input"
                                                                           data-bind="logo-font-size"/>
                                                                    <input type="hidden" name="logo-line-height"
                                                                           value="" class="addon-input"
                                                                           data-bind="logo-line-height"/>
                                                                    <input type="hidden" name="logo-letter-spacing"
                                                                           value="" class="addon-input"
                                                                           data-bind="logo-letter-spacing"/>
                                                                    <input type="hidden" name="className" value=""
                                                                           class="addon-input" data-bind="className"/>
                                                                    <input type="hidden" name="ID" value=""
                                                                           class="addon-input" data-bind="ID"/>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($addon['addon_name'] == 'socials') { ?>
                                                            <div class="hb-input-group">
                                                                <?php if (count($addon['fields']) > 0) {
                                                                    foreach ($addon['fields'] as $field) { ?>
                                                                        <input type="hidden"
                                                                               name="<?php echo $field["name"]; ?>"
                                                                               value="<?php echo $field["value"]; ?>"
                                                                               data-bind="<?php echo $field["name"]; ?>"
                                                                               class="addon-input"/>
                                                                    <?php }
                                                                } else { ?>
                                                                    <input type="hidden" name="facebook-link" value=""
                                                                           class="addon-input"
                                                                           data-bind="facebook-link"/>
                                                                    <input type="hidden" name="googleplus-link" value=""
                                                                           class="addon-input"
                                                                           data-bind="googleplus-link"/>
                                                                    <input type="hidden" name="instagram-link" value=""
                                                                           class="addon-input"
                                                                           data-bind="instagram-link"/>
                                                                    <input type="hidden" name="printerest-link" value=""
                                                                           class="addon-input"
                                                                           data-bind="printerest-link"/>
                                                                    <input type="hidden" name="twitter-link" value=""
                                                                           class="addon-input"
                                                                           data-bind="twitter-link"/>
                                                                    <input type="hidden" name="youtube-link" value=""
                                                                           class="addon-input"
                                                                           data-bind="youtube-link"/>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($addon['addon_name'] == 'sidebar') { ?>
                                                            <div class="hb-input-group">
                                                                <?php if (count($addon['fields']) > 0) {
                                                                    foreach ($addon['fields'] as $field) { ?>
                                                                        <input type="hidden"
                                                                               name="<?php echo $field["name"]; ?>"
                                                                               value="<?php echo $field["value"]; ?>"
                                                                               data-bind="<?php echo $field["name"]; ?>"
                                                                               class="addon-input"/>
                                                                    <?php }
                                                                } else { ?>
                                                                    <input type="hidden" name="sidebar-list" value="" class="addon-input" data-bind="sidebar-list">
                                                                    <input type="hidden" name="sidebar-pos" value="" class="addon-input" data-bind="sidebar-pos">
                                                                    <input type="hidden" name="sidebar-icon-class" value="" class="addon-input"
                                                                           data-bind="sidebar-icon-class">
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                            </div>
                                            <div class="col-tools">
                                                <a href="#" class="column-setting pull-right label-tooltip"
                                                   data-original-title="Column Setting"><i class="fa fa-cog"></i><span>Setting</span></a>
                                                <a href="#" class="add-addon pull-right label-tooltip"
                                                   data-original-title="Add Addons/Modules"><i
                                                            class="fa fa-plus-circle"></i><span>Addons</span></a>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="hidden">
            <div id="jmsheaderbuilder-row">
                <div class="row" data-name="Row" data-fluid="0" data-layout="12" data-active="1">
                    <div class="row-input-group">
                        <input type="hidden" name="name" value="" class="row-input" data-bind="name"/>
                        <input type="hidden" name="row-class" value="" class="row-input" data-bind="row-class"/>
                    </div>
                    <div class="row-title">
                        <div class="pull-left">
                            <span><i class="fa fa-arrows"></i></span>
                            <strong class="row-name">Row</strong>
                        </div>
                        <div class="pull-right">
                            <ul aria-labelledby="dLabel" role="menu" class="button-group">
                                <li class="layout-action">
                                    <a class="btn btn-default label-tooltip" data-original-title="Row Layout"><i
                                                class="fa fa-th"></i></a>
                                    <ul class="column-list">
                                        <li><a href="#" class="column-layout label-tooltip column-layout-12 "
                                               data-layout="12" data-original-title="12"></a></li>
                                        <li><a href="#" class="column-layout label-tooltip column-layout-66 "
                                               data-layout="6,6" data-original-title="6,6"></a></li>
                                        <li><a href="#" class="column-layout label-tooltip column-layout-444 "
                                               data-layout="4,4,4" data-original-title="4,4,4"></a></li>
                                        <li><a href="#" class="column-layout label-tooltip column-layout-3333 "
                                               data-layout="3,3,3,3" data-original-title="3,3,3,3"></a></li>
                                        <li><a href="#" class="column-layout label-tooltip column-layout-48 "
                                               data-layout="4,8" data-original-title="4,8"></a></li>
                                        <li><a href="#" class="column-layout label-tooltip column-layout-39 active"
                                               data-layout="3,9" data-original-title="3,9"></a></li>
                                        <li><a href="#" class="column-layout label-tooltip column-layout-363 "
                                               data-layout="3,6,3" data-original-title="3,6,3"></a></li>
                                        <li><a href="#" class="column-layout label-tooltip column-layout-264 "
                                               data-layout="2,6,4" data-original-title="2,6,4"></a></li>
                                        <li><a href="#" class="column-layout label-tooltip column-layout-210 "
                                               data-layout="2,10" data-original-title="2,10"></a></li>
                                        <li><a href="#" class="column-layout label-tooltip column-layout-57 "
                                               data-layout="5,7" data-original-title="5,7"></a></li>
                                        <li><a href="#" class="column-layout label-tooltip column-layout-237 "
                                               data-layout="2,3,7" data-original-title="2,3,7"></a></li>
                                        <li><a href="#" class="column-layout label-tooltip column-layout-255 "
                                               data-layout="2,5,5" data-original-title="2,5,5"></a></li>
                                        <li><a href="#" class="column-layout label-tooltip column-layout-282 "
                                               data-layout="2,8,2" data-original-title="2,8,2"></a></li>
                                        <li><a href="#" class="column-layout label-tooltip column-layout-2442 "
                                               data-layout="2,4,4,2" data-original-title="2,4,4,2"></a></li>
                                        <li><a data-original-title="Custom Layout" data-layout="custom"
                                               class="column-layout column-layout-custom label-tooltip" href="#"></a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="btn btn-default row-setting label-tooltip"
                                       data-original-title="Row Setting"><i class="fa fa-cogs"></i></a>
                                </li>
                                <a class="btn btn-default active-row label-tooltip"
                                   data-original-title="UnActive Row"><i class="fa fa-check"></i></a>
                                <li>
                                    <a class="btn btn-default duplicate-row label-tooltip"
                                       data-original-title="Duplicate Row"><i class="fa fa-clone"></i></a>
                                </li>
                                <li>
                                    <a class="btn btn-default remove-row label-tooltip"
                                       data-original-title="Delete This Row"><i class="fa fa-trash"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row-columns ui-sortable">

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="hidden">
        <div class="column-settings">
            <div class="form-group">
                <label>Custom CSS Class</label>
                <input type="text" value="" data-attrname="custom_class"
                       class="form-control addon-input addon-custom_class">
                <p class="help-block">use this field to add a class name and then refer to it in your css file.</p>
            </div>
            <div class="form-group md_col">
                <label>Medium Layout</label>
                <select data-attrname="md_col" class="form-control addon-input">
                    <option selected="" value=""></option>
                    <option value="col-md-1">col-md-1</option>
                    <option value="col-md-2">col-md-2</option>
                    <option value="col-md-3">col-md-3</option>
                    <option value="col-md-4">col-md-4</option>
                    <option value="col-md-5">col-md-5</option>
                    <option value="col-md-6">col-md-6</option>
                    <option value="col-md-7">col-md-7</option>
                    <option value="col-md-8">col-md-8</option>
                    <option value="col-md-9">col-md-9</option>
                    <option value="col-md-10">col-md-10</option>
                    <option value="col-md-11">col-md-11</option>
                    <option value="col-md-12">col-md-12</option>
                </select>
                <p class="help-block">Set the class of this column for medium devices.</p>
            </div>
            <div class="form-group sm_col">
                <label>Tablet Layout</label>
                <select data-attrname="sm_col" class="form-control addon-input">
                    <option selected="" value=""></option>
                    <option value="col-sm-1">col-sm-1</option>
                    <option value="col-sm-2">col-sm-2</option>
                    <option value="col-sm-3">col-sm-3</option>
                    <option value="col-sm-4">col-sm-4</option>
                    <option value="col-sm-5">col-sm-5</option>
                    <option value="col-sm-6">col-sm-6</option>
                    <option value="col-sm-7">col-sm-7</option>
                    <option value="col-sm-8">col-sm-8</option>
                    <option value="col-sm-9">col-sm-9</option>
                    <option value="col-sm-10">col-sm-10</option>
                    <option value="col-sm-11">col-sm-11</option>
                    <option value="col-sm-12">col-sm-12</option>
                </select>
                <p class="help-block">Set the class of this column for tablets.</p>
            </div>
            <div class="form-group xs_col">
                <label>Mobile Layout</label>
                <select data-attrname="xs_col" class="form-control addon-input">
                    <option selected="" value=""></option>
                    <option value="col-xs-1">col-xs-1</option>
                    <option value="col-xs-2">col-xs-2</option>
                    <option value="col-xs-3">col-xs-3</option>
                    <option value="col-xs-4">col-xs-4</option>
                    <option value="col-xs-5">col-xs-5</option>
                    <option value="col-xs-6">col-xs-6</option>
                    <option value="col-xs-7">col-xs-7</option>
                    <option value="col-xs-8">col-xs-8</option>
                    <option value="col-xs-9">col-xs-9</option>
                    <option value="col-xs-10">col-xs-10</option>
                    <option value="col-xs-11">col-xs-11</option>
                    <option value="col-xs-12">col-xs-12</option>
                </select>
                <p class="help-block">Set the class of this column for mobile.</p>
            </div>
            <div class="form-group">
                <label>Background Image</label>
                <input type="hidden" data-multilang="0" data-attrname="background_img" data-type="image"
                       class="addon-input jms-image">
                <img height="100px" class="media-preview">
                <a href="index.php?controller=AdminJmspagebuilderMedia" class="show-fancybox btn btn-primary"
                   title="Select">Select</a>
                <a class="btn btn-danger remove-media" href="#"><i class="icon-trash"></i></a>
                <p class="help-block">Set Background Image for Column</p>
            </div>
            <div class="form-group">
                <label>Background Size</label>
                <select data-attrname="background_size" class="form-control addon-input">
                    <option value="cover">Cover</option>
                    <option value="contain">Contain</option>
                    <option value="inherit">Inherit</option>
                </select>
            </div>
            <div class="form-group">
                <label>Background Repeat</label>
                <select data-attrname="background_repeat" class="form-control addon-input">
                    <option value="no-repeat">No Repeat</option>
                    <option value="repeat">Repeat All</option>
                    <option value="repeat-x">Repeat Horizontally</option>
                    <option value="repeat-y">Repeat Vertically</option>
                    <option value="inherit">Inherit</option>
                </select>
            </div>
            <div class="form-group">
                <label>Background Position</label>
                <select data-attrname="background_position" class="form-control addon-input">
                    <option value="0 0">Left Top</option>
                    <option value="0 50%">Left Center</option>
                    <option value="0 100%">Left Bottom</option>
                    <option value="50% 0">Center Top</option>
                    <option value="50% 50%">Center Center</option>
                    <option value="50% 100%">Center Bottom</option>
                    <option value="100% 0">Right Top</option>
                    <option value="100% 50%">Right Center</option>
                    <option value="100% 100%">Right Bottom</option>
                </select>
            </div>
            <div class="form-group">
                <label>Background Attachment</label>
                <select data-attrname="background_attachment" class="form-control addon-input">
                    <option value="fixed">Fixed</option>
                    <option value="scroll">Scroll</option>
                    <option value="inherit">Inherit</option>
                </select>
            </div>
        </div>
    </div>
    <div class="hidden">
        <div class="row-settings">
            <div class="form-group">
                <label>Row Name</label>
                <input type="text" value="" data-attrname="name" class="form-control addon-input addon-name">
            </div>
            <div class="form-group">
                <label>Custom CSS Class</label>
                <input type="text" value="" data-attrname="custom_class"
                       class="form-control addon-input addon-custom_class">
                <p class="help-block">use this field to add a class name and then refer to it in your css file.</p>
            </div>
            <div class="form-group">
                <div class="checkbox"><label><input type="checkbox" data-attrname="fluid"
                                                    class="addon-input input-fluid">Fluid Width</label></div>
                <p class="help-block">Enable this option to make this row fluid. Fluid row will help you to publish full
                    width content.</p>
            </div>
            <div class="form-group">
                <label>Background Image</label>
                <input type="hidden" data-multilang="0" data-attrname="background_img" data-type="image"
                       class="addon-input jms-image"><img height="100px" class="media-preview"><a
                        href="index.php?controller=AdminJmspagebuilderMedia" class="show-fancybox btn btn-primary"
                        title="Select">Select</a><a class="btn btn-danger remove-media" href="#"><i
                            class="icon-trash"></i></a>
                <p class="help-block">Set Background Image for Row</p>
            </div>
            <div class="form-group">
                <label>Background Size</label>
                <select data-attrname="background_size" class="form-control addon-input">
                    <option value="cover">Cover</option>
                    <option value="contain">Contain</option>
                    <option value="inherit">Inherit</option>
                </select>
            </div>
            <div class="form-group">
                <label>Background Repeat</label>
                <select data-attrname="background_repeat" class="form-control addon-input">
                    <option value="no-repeat">No Repeat</option>
                    <option value="repeat">Repeat All</option>
                    <option value="repeat-x">Repeat Horizontally</option>
                    <option value="repeat-y">Repeat Vertically</option>
                    <option value="inherit">Inherit</option>
                </select>
            </div>
            <div class="form-group">
                <label>Background Position</label>
                <select data-attrname="background_position" class="form-control addon-input">
                    <option value="0 0">Left Top</option>
                    <option value="0 50%">Left Center</option>
                    <option value="0 100%">Left Bottom</option>
                    <option value="50% 0">Center Top</option>
                    <option value="50% 50%">Center Center</option>
                    <option value="50% 100%">Center Bottom</option>
                    <option value="100% 0">Right Top</option>
                    <option value="100% 50%">Right Center</option>
                    <option value="100% 100%">Right Bottom</option>
                </select>
            </div>
            <div class="form-group">
                <label>Background Attachment</label>
                <select data-attrname="background_attachment" class="form-control addon-input">
                    <option value="fixed">Fixed</option>
                    <option value="scroll">Scroll</option>
                    <option value="inherit">Inherit</option>
                </select>
            </div>
        </div>
    </div>
    <div class="hb-settings-box addon-row-settings">
        <div class="seting-wrapper">
            <h3 class="title-setting">
                <?php esc_html_e('Row settings', 'wr-nitro'); ?>
            </h3>
            <a class="hb-settings-close">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
            <div class="setting-content">
                <div class="row form-group">
                    <div class="col-lg-6">
                        <h5 class="title-field"><?php esc_html_e('Row name', 'jmsheaderbuilder'); ?></h5>
                        <div class="input-wrapper">
                            <input type="text" name="name" data-bind="name"/>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <h5 class="title-field"><?php esc_html_e('Custom class', 'jmsheaderbuilder'); ?></h5>
                        <div class="input-wrapper">
                            <input type="text" name="row-class" data-bind="row-class"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hb-settings-footer">
                <a href="javascript:void(0)" id="save-settings" class="btn btn-default pull-right">
                    <?php esc_html_e('Save', 'jmsheaderbuilder'); ?>
                </a>
            </div>
        </div>
    </div>
    <div class="hb-settings-box addon-text-settings">
        <div class="seting-wrapper">
            <h3 class="title-setting">
                <?php esc_html_e('Text settings', 'jmsheaderbuilder'); ?>
            </h3>
            <a class="hb-settings-close">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
            <div class="setting-content">
                <div class="row form-group">
                    <div class="col-1">
                        <h5 class="title-field"><?php esc_html_e('Content', 'jmsheaderbuilder'); ?></h5>
                        <div class="content-group">
                            <div class="hb-editor" data-editor="text-content">
                                <?php
                                wp_editor('', 'text-content',
                                    array(
                                        'default_editor' => true,
                                        'editor_class' => 'hb-text-editor'
                                    )
                                );
                                ?>
                                <input type="hidden" name="hb-editor-hidden" data-bind="hb-text-content"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <h5 class="title-field"><?php esc_html_e('Class', 'jmsheaderbuilder'); ?></h5>
                        <div class="content-group"><input type="text" name="className" data-bind="className"/></div>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="title-field"><?php esc_html_e('ID', 'jmsheaderbuilder'); ?></h5>
                        <div class="content-group"><input type="text" name="ID" data-bind="ID"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hb-settings-footer">
                <a href="javascript:void(0)" id="save-settings" class="btn btn-default pull-right">
                    <?php esc_html_e('Save', 'jmsheaderbuilder'); ?>
                </a>
            </div>
        </div>
    </div>

    <div class="hb-settings-box addon-logo-settings">
        <div class="seting-wrapper">
            <h3 class="title-setting"><?php esc_html_e('Logo settings', 'jmsheaderbuilder'); ?><span
                        class="close-setting"></span></h3>
            <a class="hb-settings-close">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
            <div class="setting-content">
                <label class="radio-item">
                    <input type="radio" value="logo" name="logo-type" checked/>
                    <span>
                        <?php esc_html_e('Logo', 'jmsheaderbuilder'); ?>
                    </span>
                </label>
                <label class="radio-item">
                    <input type="radio" value="text" name="logo-type"/>
                    <span>
                        <?php esc_html_e('Text', 'jmsheaderbuilder'); ?>
                    </span>
                </label>
                <div class="image-setting">
                    <div class="row form-group">
                        <div>
                            <img src="" alt="Logo Image" style="height: 200px;" id="logo_img">
                        </div>
                        <div class="col-lg-6">
                            <h5 class="title-field">
                                <?php esc_html_e('Set Logo Image', 'jmsheaderbuilder'); ?>
                            </h5>
                            <div class="input-wrapper file-image">
                                <input type="text" class="input-file" name="logo-image-url"/>
                                <a id="add-image" class="btn btn-default">
                                    ...
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="title-field">
                                <?php esc_html_e('Width', 'wr-nitro'); ?>
                            </h5>
                            <div class="input-wrapper">
                                <input type="number" class="logo-width" name="logo-width"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-setting">
                    <div class="row form-group">
                        <div class="col-lg-12">
                            <h5 class="title-field">
                                <?php esc_html_e('Logo content', 'jmsheaderbuilder'); ?>
                            </h5>
                            <div class="input-wrapper">
                                <input type="text" name="logo-text"/>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-6">
                            <h5 class="title-field">
                                <?php esc_html_e('Color', 'jmsheaderbuilder'); ?>
                            </h5>
                            <div class="input-wrapper">
                                <input type="text" value="#000000" data-default-color="#000000" name="logo-color"
                                       class="color-field"/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="title-field">
                                <?php esc_html_e('Font size', 'jmsheaderbuilder'); ?>
                            </h5>
                            <div class="input-wrapper file-image">
                                <input type="number" value="14" name="logo-font-size"/>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-6">
                            <h5 class="title-field">
                                <?php esc_html_e('Line height', 'jmsheaderbuilder'); ?>
                            </h5>
                            <div class="input-wrapper">
                                <input type="number" value="30" name="logo-line-height"/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="title-field">
                                <?php esc_html_e('Letter spacing', 'jmsheaderbuilder'); ?>
                            </h5>
                            <div class="input-wrapper file-image">
                                <input type="number" value="14" name="logo-letter-spacing"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <h5 class="title-field"><?php esc_html_e('Class', 'jmsheaderbuilder'); ?></h5>
                        <div class="input-wrapper">
                            <input type="text" class="setting-input" name="className"/>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="title-field"><?php esc_html_e('ID', 'jmsheaderbuilder'); ?></h5>
                        <div class="input-wrapper"><input type="text" class="setting-input" name="ID"/></div>
                    </div>
                </div>
            </div>
            <div class="hb-settings-footer">
                <a href="javascript:void(0)" id="save-settings" class="btn btn-default pull-right">
                    <?php esc_html_e('Save', 'wr-nitro'); ?>
                </a>
            </div>
        </div>
    </div>
    <div class="hb-settings-box addon-sidebar-settings">
        <?php
        global $wp_registered_sidebars;
        ?>
        <div class="seting-wrapper">
            <h3 class="title-setting">
                <?php esc_html_e('Sidebars settings', 'jmsheaderbuilder'); ?>
            </h3>
            <a class="hb-settings-close">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
            <div class="setting-content">
                <div class="row form-group">
                    <div class="col-lg-10">
                        <?php
                        if (count($wp_registered_sidebars) > 0) {
                            ?>
                            <h5 class="title-field"><?php esc_html_e('Sidebars list', 'jmsheaderbuilder'); ?></h5>
                            <select name="sidebar-list" id="sidebar-list" class="form-control">
                                <option value="none"><?php esc_html_e('Select sidebar', 'jmsheaderbuilder'); ?></option>
                                <?php
                                foreach ($wp_registered_sidebars as $sdbar) {
                                    ?>
                                    <option value="<?php echo $sdbar["id"]; ?>"><?php echo $sdbar["name"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?php
                        } else {
                            echo "No sidebar.";
                        }
                        ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <h5 class="title-field"><?php esc_html_e('Position', 'jmsheaderbuilder'); ?></h5>
                        <select name="sidebar-pos" id="sidebar-pos" class="form-control">
                            <option value="left"><?php esc_html_e('Left', 'jmsheaderbuilder'); ?></option>
                            <option value="right"><?php esc_html_e('Right', 'jmsheaderbuilder'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <h5 class="title-field">
                            <?php esc_html_e('Icon class', 'jmsheaderbuilder'); ?>
                        </h5>
                        <div class="input-wrapper">
                            <input type="text" value="fa fa-bars" name="sidebar-icon-class"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hb-settings-footer">
                <a href="javascript:void(0)" id="save-settings" class="btn btn-default pull-right">
                    <?php esc_html_e('Save', 'jmsheaderbuilder'); ?>
                </a>
            </div>
        </div>
    </div>

    <div class="hb-settings-box addon-socials-settings">
        <div class="seting-wrapper">
            <h3 class="title-setting"><?php esc_html_e('Social settings', 'jmsheaderbuilder'); ?><span
                        class="close-setting"></span></h3>
            <a class="hb-settings-close">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
            <div class="setting-content">
                <div class="row form-group">
                    <div class="col-lg-12">
                        <h5 class="title-field">
                            <?php esc_html_e('Facebook', 'jmsheaderbuilder'); ?>
                        </h5>
                        <div class="input-wrapper">
                            <input type="text" name="facebook-link" value="#"/>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12">
                        <h5 class="title-field">
                            <?php esc_html_e('Google +', 'jmsheaderbuilder'); ?>
                        </h5>
                        <div class="input-wrapper">
                            <input type="text" name="googleplus-link" value="#"/>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12">
                        <h5 class="title-field">
                            <?php esc_html_e('Instagram', 'jmsheaderbuilder'); ?>
                        </h5>
                        <div class="input-wrapper">
                            <input type="text" name="instagram-link" value="#"/>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12">
                        <h5 class="title-field">
                            <?php esc_html_e('Printerest', 'jmsheaderbuilder'); ?>
                        </h5>
                        <div class="input-wrapper">
                            <input type="text" name="printerest-link" value="#"/>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12">
                        <h5 class="title-field">
                            <?php esc_html_e('Twitter', 'jmsheaderbuilder'); ?>
                        </h5>
                        <div class="input-wrapper">
                            <input type="text" name="twitter-link" value="#"/>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12">
                        <h5 class="title-field">
                            <?php esc_html_e('Youtube', 'jmsheaderbuilder'); ?>
                        </h5>
                        <div class="input-wrapper">
                            <input type="text" name="youtube-link" value="#"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hb-settings-footer">
                <a href="javascript:void(0)" id="save-settings" class="btn btn-default pull-right">
                    <?php esc_html_e('Save', 'jmsheaderbuilder'); ?>
                </a>
            </div>
        </div>
    </div>
    <textarea id="data-header" name="content" class="hidden"></textarea>
    <form name="layoutForm" action="" method="post" id="layoutForm">
        <input type="hidden" name="jmsformjson" id="jmsformjson" value=""/>
        <input type="hidden" name="saveLayout" value="1"/>
    </form>
</div>
