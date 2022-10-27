<script>
const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
console.log(timezone);
alert(timezone);
</script>

<?php
session_start();
if(!isset($_SESSION['USERTIME'])){
	$_SESSION['USERTIME'] = "America/New_York";
}

$regions = array(
    'America' => DateTimeZone::AMERICA,
    'Asia' => DateTimeZone::ASIA,
    'Atlantic' => DateTimeZone::ATLANTIC,
    'Europe' => DateTimeZone::EUROPE,
    'Indian' => DateTimeZone::INDIAN,
    'Africa' => DateTimeZone::AFRICA,
    'Pacific' => DateTimeZone::PACIFIC,
    'Antarctica' => DateTimeZone::ANTARCTICA
);

$timezones = array();
foreach ($regions as $name => $mask)
{
    $zones = DateTimeZone::listIdentifiers($mask);
    foreach($zones as $timezone)
    {
		// Lets sample the time there right now
		$time = new DateTime(NULL, new DateTimeZone($timezone));

		// Us dumb Americans can't handle millitary time
		$ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';

		// Remove region name and add a sample time
		$timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm;
	}
}


// View


print '<label>Select Your Timezone</label><select id="timezone">';
foreach($timezones as $region => $list)
{
	print '<optgroup label="' . $region . '">' . "\n";
	foreach($list as $timezone => $name)
	{
		print '<option name="' . $timezone . '">' . $name . '</option>' . "\n";
	}
	print '<optgroup>' . "\n";
}
print '</select>';
?>