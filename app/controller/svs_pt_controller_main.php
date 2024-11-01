<?php
class SVS_PT_Controller_Main {

    public function __construct(){
        global $wpdb;
        $this->db = &$wpdb;
        $this->svs_pt_model_main = new SVS_PT_Model_Main();
    }

    /**
     * Entry point. Check if any action defined otherwise display the default view (pricing tables list)
     */
    public function index(){
        $action = array_key_exists('Action', $_GET) ? $_GET['Action'] : 'pricingTableList';
        if (method_exists($this, $action)){
            $this->$action();
        } else {
            $this->pricingTableList();
        };
    }

    /**
     * List pricing tables
     */
    public function pricingTableList(){
        $_data = $this->svs_pt_model_main->getPricingTablesList();
        $this->loadView('pt_list', $_data);
    }

    /**
     * Add new pricing table
     */
    private function pricingTableNew(){
        $svs_pt_root_dir = str_replace('controller','', __DIR__);
        $_data['templates'] = $this->svs_pt_model_main->getTemplates();
        $_data['pricingTable'] = $this->svs_pt_model_main->getPricingTable();
        wp_enqueue_script('js_svs_admin', plugins_url('js/svs_pt_js_admin.min.js', $svs_pt_root_dir), array(), '1.0.2', true);
        wp_localize_script('js_svs_admin', 'SVSPricingTables', array( 'plugin_url' => plugins_url('/', $svs_pt_root_dir) ));
        $this->loadView('pt_edit', $_data);
    }

    /**
     * Edit a pricing table
     */
    private function pricingTableEdit(){
        $svs_pt_root_dir = str_replace('controller','', __DIR__);
        $_data['templates'] = $this->svs_pt_model_main->getTemplates();
        $_data['pricingTable'] = $this->svs_pt_model_main->getPricingTable(@$_GET['ID']);
        wp_enqueue_script('js_svs_admin', plugins_url('js/svs_pt_js_admin.min.js', $svs_pt_root_dir), array(), '1.0.2', true);
        wp_localize_script('js_svs_admin', 'SVSPricingTables', array( 'plugin_url' => plugins_url('/', $svs_pt_root_dir), 'name' => @$_data['pricingTable']['name'], 'ID' => @$_data['pricingTable']['id'] ));
        $this->loadView('pt_edit', $_data);
    }

    /**
     * Save a newly created or edited price plan
     */
    private function pricingTableSave(){
        $this->svs_pt_model_main->savePricingTable();
    }

    /**
     * Save a newly created or edited price plan
     */
    private function pricingTableDelete(){
        $this->svs_pt_model_main->deletePricingTable(@$_GET['ID']);
        $this->pricingTableList();
    }

    /**
     * Create database structure on plugin activation
     */
    public function createDatabase(){
        $this->svs_pt_model_main->createDatabase();
    }

    /**
     * Load a view
     * @param $view
     * @param array $_data
     */
    private function loadView($view, $_data = array())
    {
        require_once(plugin_dir_path(__DIR__) . "view/_header.php");
        if (file_exists(plugin_dir_path(__DIR__) . "view/svs_$view.php")){
            require_once(plugin_dir_path(__DIR__) . "view/svs_$view.php");
        } else {
            require_once(plugin_dir_path(__DIR__) . "view/svs_main.php");
        }
        require_once(plugin_dir_path(__DIR__) . "view/_footer.php");
    }

    /**
     * Enqueue CSS and JS in the admin
     * @param $hook
     */
    public static function adminEnqueueScripts($hook)
    {
        if (self::endsWith($hook, "svs_pricing_tables")){
            $svs_pt_root_dir = str_replace('controller','', __DIR__);
            wp_enqueue_style('css_svs_admin_min', plugins_url('css/svs_pt_admin.min.css', $svs_pt_root_dir), false, '1.0.2');
            wp_enqueue_style('css_svs_pt_general', plugins_url('css/svs_pt_general.css', $svs_pt_root_dir), false, '1.0.2');
        }
    }

    /**
     * Shortcode functionality
     * @param $args
     */
    public function pricingTablesShortcode($args){
        $_data = $this->svs_pt_model_main->getPricingTable(intval(@$args['id']));
        return base64_decode($_data['css']) . base64_decode($_data['html']);
    }

    /**
     * Check if string $heystack ends with $needle
     * @param $haystack
     * @param $needle
     * @return bool
     */

    private static function endsWith($haystack, $needle) {
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }
}