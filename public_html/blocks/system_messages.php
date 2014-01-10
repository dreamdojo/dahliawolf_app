<?php
if (!empty($_SESSION['errors'])): ?>
    <script>
        _gaq.push(['_trackEvent','Errors' , '<?= $_SESSION['errors'][0] ?>']);
    </script>
    <div class="user-message user-error ui-state-error ui-corner-all">
        <div class='user-message-close'>X</div>
        <?php if (count($_SESSION['errors']) == 1 && trim($_SESSION['errors'][0]) != '' ): ?>
            <?php if (!empty($_SESSION['errors'][0])): ?>
                <p><?= $_SESSION['errors'][0] ?></p>
                <script>_gaq.push(['_trackEvent','Errors' , '<?= $_SESSION['errors'][0] ?>']);</script>
            <?php endif ?>
        <?php else: ?>
            <ul>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <script>_gaq.push(['_trackEvent','Errors' , '<?= $error ?>']);</script>
                    <li><?= $error ?></li>
                <?php endforeach ?>
            </ul>
        <?php endif ?>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif ?>

<?php if( !empty($_SESSION['success']) ): ?>
    <script>
        _gaq.push(['_trackEvent','Success' , '<?= $_SESSION['success'] ?>']);
    </script>
    <div class="user-message user-success ui-state-highlight ui-corner-all">
        <div class='user-message-close'>X</div>
        <p><?= $_SESSION['success'] ?></p>
    </div>
    <?php unset($_SESSION['success']) ?>
<?php endif ?>