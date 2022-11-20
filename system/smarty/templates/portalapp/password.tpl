<div class="pre-wrap">
    <div class="row-fluid pre-inner">
        <div class="logo"><div class="background"></div></div>
        <div class="box">
            <div class="content-wrap">
                <h6>Forgot Your Password?</h6>
                <p>Let's fix that. Please provide us with the email address you used when you registered.</p>
                <form id="password-form" accept-charset="UTF-8" data-src="{$URL}user/sendResetPasswordEmail" method="post">                    
                    <div class="field-wrap">
                        <div class="label-wrap">
                            <span>Email</span>
                        </div>
                        <div class="input-wrap">
                            <input id="emailAddress" type="email" placeholder="myname@mydomain.com" name="emailAddress" maxlength="32">
                        </div>
                    </div>
                    <div class="button-wrap">
                        <input class="button" type="submit" id="js__submit" value="Reset Password">
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