<div class="wrap">

    <h2>Commits</h2>

    <?php if( !empty( $return_message ) ) { ?>

        <div class="notice notice-success up-to-date">
            <strong>Git Message:</strong><br />
            <pre><?php echo implode("\n", $return_message ) ?></pre>
        </div>

    <?php } ?>

    <?php if( $up_to_date === true || (string)$current_commit_id === (string)$latest_commit_id ) { ?>

        <div class="notice notice-success up-to-date">
            <?php echo __( 'The site is up to date', 'essential-git-actions' ); ?>
        </div>

    <?php } else { ?>

        <div class="notice notice-warning up-to-date">
            <?php echo __( 'The site is not up to date', 'essential-git-actions' ); ?><br /><br />
            <a href="<?php admin_url(); ?>tools.php?page=submenu-page&action=pull" class="button"><?php echo __( 'Pull the latest version', 'essential-git-actions' ) ?></a>
        </div>

    <?php } ?>

    <ul class="experiences">

        <?php foreach( $logs as $log ) { ?>

            <li <?php if( (string)$current_commit_id === (string)$log['id'] ){ ?>class="active"<?php } ?>>
                <div class="commit">
                    <div class="commit-message"><?php echo $log['message']; ?></div>
                    <div class="commit-details">
                        <strong><?php echo $log['author']; ?></strong> on <?php echo $log['date']; ?><br />
                        <?php echo $log['id']; ?><br />
                        <?php if( (string)$current_commit_id !== (string)$log['id'] ){ ?><a href="<?php admin_url(); ?>tools.php?page=submenu-page&action=reset&id=<?php echo $log['id']; ?>">Reset to this commit</a><?php } ?>
                    </div>

                </div>
            </li>

        <?php } ?>

    </ul>

</div>

<style>

    ul.experiences {
        padding: 0 0 0 25px;
    }

    ul.experiences li {
        position:relative;
        margin-bottom: 0;
        padding-bottom: 20px;
    }

    ul.experiences li:after {
        content: '';
        width: 10px;
        height: 10px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        background-color: #ccc;
        position: absolute;
        left: -20px;
        top: 5px;
    }

    ul.experiences li.active:after {
        background-color: #444;
    }

    ul.experiences li.active .commit-message {
        font-weight: bold;
    }

    ul.experiences li:before {
        content: '';
        position: absolute;
        left: -16px;
        border-left: 2px solid #ccc;
        height: 100%;
        width: 1px;
    }

    ul.experiences li:first-child:before {
        top: 6px;
    }

    ul.experiences li:last-child:before {
        height: 6px;
    }

    ul.experiences .commit-details {
        padding-top: 5px;
        font-size: 11px;
        line-height: 14px;
        color: #666;
    }

    ul.experiences .commit-details strong {
        color: #333;
    }

    .up-to-date {
        padding: 10px;
    }
    
</style>