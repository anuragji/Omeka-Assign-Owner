<?php
$pageTitle = __('Assign Owner');
echo head(array('title'=>$pageTitle, 'bodyclass'=>'assign-owner'));
echo flash();
?>
<h2>Please note</h2>
<p class="Explanation">Use this form to assign ownership of <b>ALL</b> items to one user. Once you click on the <i>Assign</i> link, the ownership of all items will be set to that user, regardless of what they are currently set to. This process is <strong>NOT</strong> reversible.</b></p>
<table id="users">
    <thead>
    <tr>
        <?php $sortLinks = array(
            __('Username') => 'username',
            __('Real Name') => 'name',
            __('Role') => 'role'
        );
        ?>
        <?php echo browse_sort_links($sortLinks,  array('link_tag' => 'th scope="col"', 'list_tag' => '')); ?>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach( $users as $user ): ?>
            <tr class="<?php if ($user['id'] == $currentOwnerId) echo 'current-owner '; ?>">
                <td><?php echo $user['username']?></td>
                <td><?php echo $user['name']?></td>
                <td><?php echo $user['role']?></td>
                <td>
                    <div class="assignContainer <?php echo $user['id']; ?>">
                        <a href="#" id="<?php echo $user['id']; ?>" class="assignLink">Assign Ownership</a>
                    </div>
                </td>
            </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<script type="text/javascript" >
    (function($) {
        $(document).ready(function() {
            $('.assignLink').click(function(event) {
                // The link Id is the record Id, so we pass that on
                var user_id = event.target.id;
                jQuery.ajax({
                    url: '/admin/assign-owner/index/assign',
                    type: 'POST',
                    data: {user_id: user_id},
                    dataType: "json",
                    success: function(result){
                        var flashMsg = result.flashMsg;
                        if(result.flashMsg) {
                            $('.assignContainer.' + user_id).append('<span class="alert alert-success" id="feedback' + user_id + '">' + flashMsg + '</span>');
                            $('#feedback' + user_id).fadeOut(5000);
                        }
                    }
                });
            });
        });
    }) (jQuery);
</script>
<?php echo foot(); ?>
