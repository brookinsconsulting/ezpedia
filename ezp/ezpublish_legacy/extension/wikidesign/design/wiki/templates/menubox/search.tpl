<div class="menubox">
    <div class="menubox-title">{'Search'|i18n('design/wiki/pagelayout')}</div>
    <div class="menubox-content">
        <form action={'/content/search'|ezurl} method="get">
            <div>
            <input class="searchinput" type="text" size="15" name="SearchText" value="" />
            <br />
            {*
            <input class="default-button" type="submit" value="{'Go'|i18n('design/wiki/pagelayout')}" />
            *}
            <input class="button" type="submit" value="{'Search'|i18n('design/wiki/pagelayout')}" />
            </div>
        </form>
    </div>
</div>