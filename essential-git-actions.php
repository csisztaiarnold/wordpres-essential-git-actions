<?php
/*
 * Plugin Name:       Essential Git Actions
 * Plugin URI:        http://github.com/csisztai.arnold/essential-git-actions
 * Description:       Provides some essential Git actions for
 * Version:           0.1.0
 * Author:            Arnold Csisztai
 * Author URI:        https://idevele.com
 * Text Domain:       essential-git-actions
 * License:           GPL-3.0+
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.en.html
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}


class EssentialGitActions
{

    public $git_message = '';

    function __construct()
    {
        add_action( 'admin_menu', [ $this, 'register_sub_menu' ] );
        add_action( 'admin_init', [ $this, 'actions' ] );
    }

    public function register_sub_menu()
    {
        add_submenu_page( 'tools.php', 'Essential Git Actions', 'Essential Git Actions', 'manage_options',  'submenu-page', [ $this, 'commit_list_view' ] );
    }

    public function actions()
    {
        $output = '';
        if( (string)$_GET['action'] === 'pull' ) {
            exec( "git pull", $output );
        }

        if( (string)$_GET['action'] === 'reset' ) {
            exec( "git reset --hard " . $_GET['id'], $output );
        }

        $this->git_message = $output;

    }

    public function commit_list_view()
    {
        $logs = $this->get_rev_list( $historyLimit = 20 );
        $up_to_date = $this->is_already_up_to_date();
        $current_commit_id = $this->current_commit_id();
        $latest_commit_id = $logs[0]['id'];
        $return_message = $this->git_message;
        include_once( __DIR__ . '/views/commit-list.php' );
    }

    public function is_exec_enabled()
    {
        // Is exec enabled?
        if( function_exists( 'exec' ) ) {

        }

    }

    public function current_commit_id()
    {
        $current_id = '';
        exec( "git rev-parse HEAD", $current_id );
        return $current_id[0];
    }

    public function is_already_up_to_date()
    {
        $up_to_date = '';
        exec( "git status", $up_to_date );
        if ( strpos( (string)$up_to_date[1], 'is up to date' ) === false ) {
            return false;
        }
        return true;
    }

    public function get_rev_list( $historyLimit = 10 )
    {
        $rev_list = '';
        exec( "git rev-list --max-count=" . $historyLimit . " --all", $rev_list );

        $commit_array = [];
        foreach( $rev_list as $rev_list_item ) {

            $commit_body = '';
            exec( "git rev-list --format=%an%n%ad%n%s --max-count=1 " . $rev_list_item, $commit_body );
            $commit_array[] = [
                'id' => $rev_list_item,
                'author' => $commit_body[1],
                'date' => $commit_body[2],
                'message' => $commit_body[3],
            ];

        }

        return $commit_array;
    }

}

new EssentialGitActions();


