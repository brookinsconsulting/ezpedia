{let settings=$handler.settings}

<p>
    <input type="checkbox" id="ReceiveDigest_{$handler.id_string}" name="ReceiveDigest_{$handler.id_string}" {$settings.receive_digest|choose("",checked)} />
    <label style="display:inline;" for="ReceiveDigest_{$handler.id_string}">{'Receive all messages combined in one digest'|i18n('design/wiki/notification')}</label><br/>
</p>

<fieldset style="margin-top:2em;">
    <legend>Time interval</legend>
    <div class="block">
        <input type="radio" id="DigestType_{$handler.id_string}_daily" name="DigestType_{$handler.id_string}" value="3" {eq($settings.digest_type,3)|choose('',checked)} />
        <label style="display:inline;" for="DigestType_{$handler.id_string}_daily">{'Daily, at'|i18n('design/wiki/notification')}</label>
        <select name="Time_{$handler.id_string}">
        {section name=Time loop=$handler.available_hours}
            <option value="{$Time:item}" {section show=eq($Time:item,$settings.time)}selected="selected"{/section}>{$Time:item}</option>
        {/section}
        </select>
        <div class="break"></div>

        <input type="radio" name="DigestType_{$handler.id_string}" id="DigestType_{$handler.id_string}_weekly" value="1" {eq($settings.digest_type,1)|choose('',checked)} />
        <label style="display:inline;" for="DigestType_{$handler.id_string}_weekly">{'Weekly, on'|i18n('design/wiki/notification')}:</label>
        <select name="Weekday_{$handler.id_string}">
        {section name=WeekDays loop=$handler.all_week_days}
            <option value="{$WeekDays:item}" {section show=eq($WeekDays:item,$settings.day)}selected="selected"{/section}>{$WeekDays:item}</option>
        {/section}
        </select>
        <div class="break"></div>

        <input type="radio" name="DigestType_{$handler.id_string}" id="DigestType_{$handler.id_string}_monthly" value="2" {eq($settings.digest_type,2)|choose('',checked)} />
        <label style="display:inline;" for="DigestType_{$handler.id_string}_monthly">{'Monthly, on day number'|i18n('design/wiki/notification')}:</label>
        <select name="Monthday_{$handler.id_string}">
        {section name=MonthDays loop=$handler.all_month_days}
            <option value="{$MonthDays:item}" {section show=eq($MonthDays:item,$settings.day)}selected="selected"{/section}>{$MonthDays:item}</option>
        {/section}
        </select>
        <div>{'If the day of month number you have chosen is larger than the number of days in the current month, then the last day of the current month will be used instead.'|i18n('design/wiki/notification')}</div>
    </div>
</fieldset>

{/let}
