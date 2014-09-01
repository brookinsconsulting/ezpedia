{let site_url=ezini("SiteSettings","SiteURL")}
{set-block scope=root variable=subject}{"%siteurl new password"|i18n("design/wiki/user/forgotpassword",,hash('%siteurl',$site_url))}{/set-block}
{"Your account information"|i18n('design/wiki/user/forgotpassword')}
{"E-mail"|i18n('design/wiki/user/forgotpassword')}: {$user.email}

{section show=$link}
{"Click here to get new password"|i18n('design/wiki/user/forgotpassword')}:
{concat("http://",$site_url,"/user/forgotpassword/", $hash_key, '/')}
{section-else}


{section show=$password}
{"New password"|i18n('design/wiki/user/forgotpassword')}: {$password}
{/section}

{/section}

{/let}
