<?php
$adminuser = wp_get_current_user();
?>

<script id="IntercomSettingsScriptTag">

  window.intercomSettings = {
    name: "<?php echo $adminuser->display_name?>",
    email: "<?php echo $adminuser->user_email?>",
    wordpress_url: "<?php echo get_bloginfo('wpurl')?>",
    source: "Wordpress",
    app_id: "<?php echo INTERCOM_APP_ID?>",
    user_hash: "<?php echo hash_hmac('sha256', $adminuser->user_email, INTERCOM_APP_KEY)?>"

  };
</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://static.intercomcdn.com/intercom.v1.js';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
