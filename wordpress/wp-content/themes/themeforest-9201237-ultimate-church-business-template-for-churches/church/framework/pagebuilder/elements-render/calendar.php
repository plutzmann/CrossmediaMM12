<?php
/* ================================================================================== */
/*      Calendar Shortcode
/* ================================================================================== */

function waves_calendar($atts, $content){
    $atts = shortcode_atts(array(
        'size'  => 'col-md-12',
        'class' => '',
        'title' => '',
        'year'  => '2014',
        'month' => '10',
    ), $atts);
    $calendarURL=get_permalink();
    $year =$atts['year'];
    $month=$atts['month'];
    if(isset($_REQUEST['waves_calendar'])){
        $wavesCalendar=str_replace(' ','',$_REQUEST['waves_calendar']);
        if((strlen($wavesCalendar)===6||strlen($wavesCalendar)===5)&&is_numeric($wavesCalendar)){
            $year =intval(substr($wavesCalendar,0,4));
            $month=intval(substr($wavesCalendar,4,2));
        }
    }
    $prevMonth = intval($month)-1;
    $nextMonth = intval($month)+1;
    $nextYear = $prevYear = $year;
    if ($prevMonth < 1) {
        $prevMonth = 12;
        $prevYear--;
    }
    if ($nextMonth > 12) {
        $nextMonth = 1;
        $nextYear ++;
    }    
    
    $calendar  = '<table cellpadding="0" cellspacing="0" class="calendar">';
        /* table headings */
        $headings = array(__('Sunday','waves'),__('Monday','waves'),__('Tuesday','waves'),__('Wednesday','waves'),__('Thursday','waves'),__('Friday','waves'),__('Saturday','waves'));
        $calendar.= '<tr class="calendar-row">';
            $calendar.= '<td colspan="7" class="calendar-title">';
                $calendar.= '<a href="'.$calendarURL.'?waves_calendar='.$prevYear.$prevMonth.'" class="calendar-prev-month fa-angle-left fa"></a>';
                    $calendar.= date("F Y", mktime(0,0,0,$month,1,$year));
                $calendar.= '<a href="'.$calendarURL.'?waves_calendar='.$nextYear.$nextMonth.'" class="calendar-next-month fa-angle-right fa"></a>';
            $calendar.= '</td>';
        $calendar.= '</tr>';
        $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';
        /* days and weeks vars now ... */
        $running_day = date('w',mktime(0,0,0,$month,1,$year));
        $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
        $days_in_this_week = 1;
        $day_counter = 0;
        /* row for week one */
        $calendar.= '<tr class="calendar-row">';
        /* print "blank" days until the first of the current week */
        for($x = 0; $x < $running_day; $x++){
            $calendar.= '<td class="calendar-day-np"> </td>';
            $days_in_this_week++;
        }
        /* keep going with days.... */
        for($list_day = 1; $list_day <= $days_in_month; $list_day++){
            $calendar.= '<td class="calendar-day">';
                $calendar.= '<div class="day-number">'.$list_day.'</div>';
                $query = new WP_Query(array(
                    'post_type'=>'event',
                    'meta_key' => 'event_date',
                    'meta_query' => array(
                        array(
                            'key' => 'event_date',
                            'value' => str_pad($list_day, 2, "0", STR_PAD_LEFT).'-'.str_pad($month, 2, "0", STR_PAD_LEFT).'-'.$year,
                            'type' => 'whatever',
                            'compare' => 'like'
                        )
                    )
                ));
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $calendar.='<div class="calendar-event"><h4><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4></div>';
                }
                wp_reset_postdata();
            $calendar.= '</td>';
            if($running_day == 6){
                $calendar.= '</tr>';
                if(($day_counter+1) !== $days_in_month){
                    $calendar.= '<tr class="calendar-row">';
                }
                $running_day = -1;
                $days_in_this_week = 0;
            }
            $days_in_this_week++; $running_day++; $day_counter++;
        }

        /* finish the rest of the days in the week */
        if(1<$days_in_this_week&&$days_in_this_week<8){
            for($x = 1; $x <= (8 - $days_in_this_week); $x++){
                $calendar.= '<td class="calendar-day"><div class="day-number empty">'.$x.'</div></td>';
            }
        }

        /* final row */
        $calendar.= '</tr>';

        /* end the table */
    $calendar.= '</table>';
    
    
    $output  = waves_item($atts,'waves-calendar-container');
	$output .= $calendar;
    $output .= '</div>';
    return $output;
}
add_shortcode('tw_calendar', 'waves_calendar');