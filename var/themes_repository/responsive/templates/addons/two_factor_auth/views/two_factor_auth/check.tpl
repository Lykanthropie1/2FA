<form name="check_secret_form" action="{""|fn_url}" method="post">
    <div class="ty-control-group ty-container-center">
        <label for="elm_user_secret" class="ty-login__filed-label ty-control-group__label cm-required cm-trim">{__("Enter the secret code that was sent to your email")}</label>
        <input type="text" id="elm_user_secret" name="user_secret" size="9" class="ty-login__input cm-focus" />
    </div>
        <div class="buttons-container clearfix">
            <div class="ty-float-right">
                {include file="buttons/continue.tpl" but_name="dispatch[two_factor_auth.verify]" but_role="submit"}
            </div>
        </div>
</form>