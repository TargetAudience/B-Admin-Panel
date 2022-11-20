<div class="pre-wrap">
    <div class="row-fluid pre-inner">
        <div class="logo"><div class="background"></div></div>
        <div class="box">
            <div class="content-wrap">
                <h6>Reset Password</h6>
                <p>Please enter your new password.</p>
                <form id="password-form" accept-charset="UTF-8" data-src="{$URL}user/passwordReset" method="post">    
                    <input type="hidden" name="token" value="{$token}" />                
                    <div class="field-wrap">
                        <div class="label-wrap">
                            <span>New Password</span>
                        </div>
                        <div class="input-wrap">
                            <input type="password" name="newPassword" maxlength="32" />
                        </div>
                    </div>
                    <div class="field-wrap">
                        <div class="label-wrap">
                            <span>Confirm New Password</span>
                        </div>
                        <div class="input-wrap">
                            <input type="password" name="confirmPassword" maxlength="32" />
                        </div>
                    </div>
                    <div class="button-wrap">
                        <input class="button" type="submit" id="js__submit" value="Reset Password" />
                        <div class="button-spinner" id="js__submit-spinner"></div>
                    </div>
                </form>
            </div>
        </div>
        <div class="bottom-wrap">
             <a href="{$URL}">Return to Sign In</a>
        </div>
    </div>
</div>