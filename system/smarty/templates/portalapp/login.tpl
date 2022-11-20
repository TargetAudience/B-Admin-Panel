<div class="pre-wrap">
    <div class="row-fluid pre-inner">
        <div class="logo"><div class="background"></div></div>
        <div class="box">
            <div class="content-wrap">
                <h6>Sign In To Your Account</h6>
                <form id="login-form" data-src="{$URL}user/userLogin" method="post" accept-charset="UTF-8">                 
                    <div class="field-wrap">
                        <div class="label-wrap">
                            <span>Email</span>
                        </div>
                        <div class="input-wrap">
                            <input type="email" placeholder="myname@mydomain.com" name="emailAddress" maxlength="32">
                        </div>
                    </div>
                    <div class="field-wrap">
                        <div class="label-wrap">
                            <span>Password</span>
                        </div>
                        <div class="input-wrap">
                            <input type="password" placeholder="••••••••••••" name="password" maxlength="32">
                        </div>
                    </div>
                    <div class="button-wrap">
                        <input class="button" type="submit" id="js__submit" value="Sign In">
                        <div class="button-spinner" id="js__submit-spinner"></div>
                    </div>

                    <div class="link-wrap"><a class="link" href="{$URL}user/password">Did you forget your password?</a></div>
                </form>
            </div>
        </div>
    </div>
</div>