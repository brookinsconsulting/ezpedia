{def $currentTime=maketime()
     $currentTimeInfo=gettime( $currentTime )
     $year=cond( is_set( $year ), $year, true(), $currentTimeInfo.year )
     $month=cond( is_set( $month ), $month, true(), $currentTimeInfo.month )
     $day=cond( is_set( $day ), $day, true(), $currentTimeInfo.day )
     $timestamp=makedate( $month, $day, $year )
     $show_week=false()
}

{def $month=array()|month_overview( 'test', $timestamp, hash( 'current', $timestamp,
                                                              'next', true(),
                                                              'previous', true(),
                                                              'today_class', 'today',
                                                              'current_class', 'current' ) )}

<div class="calendar" style="float:right;">

<table class="calendar">
<tr class="calendar-navigator">
    <th colspan="{sum( $month.weekdays|count, $show_week|choose( 0, 1 ) )}">
    <table class="calendar-navigator">
    <tr>
        {section show=is_array( $month.previous )}<td><div class="calendar-previous"><a href={concat("/ez/",$month.previous.month|downcase)|ezurl} title="{$month.previous.month}"><span class="calendar-arrow">&laquo;</span> </a></div></td>{/section}
        <td>
        <div class="calendar-date">
            <a href={concat("/ez/",$month.current.month|downcase)|ezurl} title="{$month.current.month}"><span class="calendar-month">{$month.month}</span></a>&nbsp;<a href={concat("/ez/",$month.current.year|downcase)|ezurl} title="{$month.current.year}"><span class="calendar-year">{$month.year}</span></a>
        </div>
        </td>
        {section show=is_array( $month.next )}<td><div class="calendar-next"><a href={concat("/ez/",$month.next.month|downcase)|ezurl} title="{$month.next.month}"><span class="calendar-arrow">&raquo;</span> </a></div></td>{/section}
    </tr>
    </table>
    </th>
</tr>

<tr class="calendar-day-names">
    {section show=$show_week}<th>&nbsp;</th>{/section}
        {section var=weekday loop=$month.weekdays}
            <th class="calendar-day-{$weekday.item.class|wash}">{$weekday.item.day|wash}</th>
        {/section}
</tr>
{section var=week loop=$month.weeks}
<tr class="calendar-days">
    {section show=$show_week}<td class="calendar-week">{$week.key}</td>{/section}
    {section var=day loop=$week.item}
        {section show=is_boolean( $day.item )}
            <td class="calendar-empty">&nbsp;</td>
        {/section}
        {section show=is_numeric( $day.item )}
            <td>{$day.item}</td>
        {/section}
        {section show=is_array( $day.item )}
            {let day_number=$day.item.day
                 day_class=cond(is_set($day.item.class), $day.item.class, true(), false() )}
            <td{section show=$day_class|count|gt( 0 )} class="calendar-day-{$day_class|wash}"{/section}><a href={concat("/ez/",$month.month|downcase,"_",$day_number)|ezurl}>{$day_number}</a></td>
            {/let}
        {/section}
    {/section}
</tr>
{/section}

</table>
</div>

{undef $month}

{undef $currentTime
       $year
       $month
       $day
       $timestamp
       $show_week}