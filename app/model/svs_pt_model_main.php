<?php

class SVS_PT_Model_Main
{

    public function __construct()
    {
        global $wpdb;
        $this->db = & $wpdb;
        $this->pricingTables = $this->db->prefix . 'svs_pricing_tables';

    }

    /**
     * Create database structure on plugin activation
     */
    public function createDatabase()
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $pricingTablesSql = "CREATE TABLE IF NOT EXISTS {$this->pricingTables} (
            `ID` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `template` varchar(255) NOT NULL,
            `backend` text NOT NULL,
            `html` text NOT NULL,
            `css` text NOT NULL,
            PRIMARY KEY ID (ID)
            );";
        dbDelta($pricingTablesSql);

    }

    /**
     * Get the existing pricing tables
     * @return array
     */
    public function getPricingTablesList()
    {
        return $this->db->get_results("
            SELECT
                `ID`,
                `name`,
                CONCAT('[svs_pricing_tables id=\"', `ID`, '\"]') as `Shortcode`
            FROM
              {$this->pricingTables}
        ");
    }

    /**
     * Get the list of existing templates. Scans the templates folder to retrieve data.
     * @return array
     */
    public function getTemplates()
    {
        return array_diff(scandir(plugin_dir_path(__DIR__) . '../templates/'), array('..', '.'));
    }

    /**
     * Save a pricing table (new or edit)
     */
    public function savePricingTable()
    {
        $id = htmlspecialchars(@$_POST['ID'], ENT_QUOTES);
        $name = htmlspecialchars(@$_POST['name'], ENT_QUOTES);
        $template = htmlspecialchars(@$_POST['template'], ENT_QUOTES);
        $backend = htmlspecialchars(@$_POST['htmlAdmin'], ENT_QUOTES);
        $html = htmlspecialchars(@$_POST['html'], ENT_QUOTES);
        $css = base64_encode('<style type="text/css">' . file_get_contents(plugin_dir_path(__DIR__) . "../css/svs_pt_general.css") . file_get_contents(plugin_dir_path(__DIR__) . "../templates/$template/svs_$template.css") . "</style>");
        $this->db->query("
            INSERT INTO
              {$this->pricingTables}
            SET
                `ID` = '$id',
                `name` = '$name',
                `template` = '$template',
                `backend` = '$backend',
                `html` = '$html',
                `css` = '$css'
            ON DUPLICATE KEY UPDATE
                `name` = '$name',
                `template` = '$template',
                `backend` = '$backend',
                `html` = '$html',
                `css` = '$css'
        ");
    }

    /**
     * Save a pricing table (new or edit)
     */
    public function deletePricingTable($id)
    {
        $id = intval($id);
        $this->db->query("
            DELETE FROM
              {$this->pricingTables}
            WHERE
                `ID` = '$id'
        ");
    }

    /**
     * Retrieve data related to a pricing table
     * @param $id
     * @return string
     */
    public function getPricingTable($id = 0)
    {
        $id = intval($id);
        $default = array('backend' => 'PHNlY3Rpb24gaWQ9InN2c19wcmljZV9wbGFucyIgY2xhc3M9InN2c19wdF9jbGVhcmZpeCI+DQogICA8b2wgY2xhc3M9InN2c19wcmljZV9wbGFuIj4NCiAgICAgIDxzcGFuIGNsYXNzPSJzdnNfaWNvbiBpY29uLXNldHRpbmdzIG9pIiBkYXRhLWdseXBoPSJjb2ciPjwvc3Bhbj4NCiAgICAgIDxzcGFuIGNsYXNzPSJzdnNfaWNvbiBpY29uLWZlYXR1cmVkIG9pIiBkYXRhLWdseXBoPSJzdGFyIj48L3NwYW4+DQogICAgICA8c3BhbiBjbGFzcz0ic3ZzX2ljb24gaWNvbi10cmFzaC1wbGFuIG9pIiBkYXRhLWdseXBoPSJ0cmFzaCI+PC9zcGFuPg0KICAgPC9vbD4NCiAgIDxvbCBjbGFzcz0ic3ZzX25ld19wbGFuIj4NCiAgICAgIDxzcGFuIGNsYXNzPSJpY29uLWFkZCBvaSIgZGF0YS1nbHlwaD0icGx1cyI+PC9zcGFuPg0KICAgPC9vbD4NCjwvc2VjdGlvbj4=');
        $pricingTable = $this->db->get_row("
            SELECT
              `id`,
              `name`,
              `template`,
              `backend`,
              `css`,
              `html`
            FROM
              {$this->pricingTables}
            WHERE
              `ID` = '$id'
            LIMIT 1
        ", ARRAY_A);
        return (is_null($pricingTable) ? $default : $pricingTable);
    }

}