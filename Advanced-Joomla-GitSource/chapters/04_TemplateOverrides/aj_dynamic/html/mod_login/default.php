<?php
// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
?>
<script type="text/javascript">
function showLogin() {
    var btnLogin = document.getElementById("show_loginlogout");
    var frmLogin = document.getElementById("loginlogout");
    btnLogin.style.display = "none";
    frmLogin.style.display = "";
}
</script>
<div id="show_loginlogout">
<br/>
<a hef="#" onclick="showLogin();" 
    style="padding:6px;background-color:lightblue;
        border:1px solid blue;">
    Show Login</a>
</div>
<div id="loginlogout" style="display:none;">
<?php if ($type == 'logout') : ?>
<form action="index.php" method="post" name="form-login"
    id="login-form">
<?php if ($params->get('greeting')) : ?>
    <div class="login-greeting">
    <?php if($params->get('name') == 0) : {
        echo JText::sprintf('MOD_LOGIN_HINAME', $user->get('name'));
    } else : {
        echo JText::sprintf('MOD_LOGIN_HINAME', 
            $user->get('username'));
    } endif; ?>
    </div>
<?php endif; ?>
    <div class="logout-button">
        <input type="submit" name="Submit" class="button"
            value="<?php echo JText::_('JLOGOUT'); ?>" />
    </div>

    <input type="hidden" name="option" value="com_users" />
    <input type="hidden" name="task" value="user.logout" />
    <input type="hidden" name="return" value="<?php echo $return; ?>" />
</form>
<?php else : ?>
<form action="<?php echo JRoute::_('index.php', true, 
    $params->get('usesecure')); ?>" method="post" name="form-login" 
    id="login-form" >
    <div class="pretext">
    <?php echo $params->get('pretext'); ?>
    </div>
    <fieldset class="userdata">
    <p id="form-login-username">
        <label for="modlgn-username"><?php 
            echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?></label>
        <input id="modlgn-username" type="text" name="username" 
        class="inputbox"  size="18" />
    </p>
    <p id="form-login-password">
        <label for="modlgn-passwd"><?php 
            echo JText::_('JGLOBAL_PASSWORD') ?></label>
        <input id="modlgn-passwd" type="password" name="password" 
        class="inputbox" size="18"  />
    </p>
    <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
    <p id="form-login-remember">
        <label for="modlgn-remember"><?php 
        echo JText::_('MOD_LOGIN_REMEMBER_ME') ?></label>
        <input id="modlgn-remember" type="checkbox" name="remember" 
        class="inputbox" value="yes"/>
    </p>
    <?php endif; ?>
    <input type="submit" name="Submit" class="button" value="<?php 
        echo JText::_('JLOGIN') ?>" />
    <input type="hidden" name="option" value="com_users" />
    <input type="hidden" name="task" value="user.login" />
    <input type="hidden" name="return" 
        value="<?php echo $return; ?>" />
    <?php echo JHtml::_('form.token'); ?>
    </fieldset>
    <ul>
        <li>
            <a href="<?php echo 
              JRoute::('index.php?option=com_users&view=reset'); ?>">
            <?php 
              echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
        </li>
        <li>
            <a href="<?php echo 
             JRoute::('index.php?option=com_users&view=remind'); ?>">
            <?php echo 
             JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
        </li>
        <?php
        $usersConfig = JComponentHelper::getParams('com_users');
        if ($usersConfig->get('allowUserRegistration')) : ?>
        <li>
            <a href="<?php echo JRoute::_
               ('index.php?option=com_users&view=registration'); ?>"> 
                <?php echo JText::_('MOD_LOGIN_REGISTER'); ?></a>
        </li>
        <?php endif; ?>
    </ul>
    <div class="posttext">
    <?php echo $params->get('posttext'); ?>
    </div>
</form>
<?php endif; ?>
</div> 

