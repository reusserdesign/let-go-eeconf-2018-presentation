<?php

/*
    Set array of colors for the chart
*/
$colors = array(
    '#004f98',
    '#599dd6',
    '#c3102f',
    '#ffb229',
    '#f76b00',
    '#939598',
    '#012c62',
    '#c3102f',
    '#f4901d',
    '#ffffff'
);

// Explode Data passed to the add-on
$data = explode(',' , $template_vars['chart_data']);

//Loot through exploded data to set the inital array as well as total variable
foreach ($data as $val) {
    list($label, $amount) = explode('||', $val);

    //Set initial values to array
    $temp['label'] = $label;
    $temp['amount'] = $amount;
    $temp['segment_percentage'] = 0;
    $temp['remaining_percentage'] = 0;
    array_push($chart_data, $temp);

    //Run up the total amount
    $total_amount += $temp['amount'];
}

//Add percentages to the array
foreach ($chart_data as $i => &$row) {
    $segment_percentage = "";
    $segment_percentage = (($row['amount'] / $total_amount) * 100);

    $row['segment_percentage'] = $full_percentage;
    $row['remaining_percentage'] = 100 - $full_percentage;
}


$segments = "";
$filled_offset = "";
$stroke_offset = "";

//Build out the chart segments
foreach ($chart_data as $i => &$row) {

    $segments .= '<circle class="donut-segment" cx="21" cy="21" r="15.91549430918954"
        fill="transparent" stroke-width="5"
        stroke="' . $colors[$i] . '"
        stroke-dasharray="' . $row["segment_percentage"] . ' ' .$row["remaining_percentage"] . '"
        stroke-dashoffset="' . $stroke_offset . '"></circle>';

    $filled_offset += $row["full_percentage"];
    $stroke_offset = (100 - $filled_offset);
}

//Stitch it all together
$html = '';

$html = '<svg width="100%" height="100%" viewBox="0 0 42 42" class="donut">
            <circle class="donut-ring" cx="21" cy="21" r="15.91549430918954"
                fill="transparent" stroke="#d2d3d4" stroke-width="5"></circle>';

$html .= $segments;

$html .= '</svg>';

//Return the HTML to the page it was called on
return $html;
?>