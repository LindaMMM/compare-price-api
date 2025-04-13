Installing Composer on
$output = shell_exec("alias php='/usr/local/php8.0/bin/php'");
echo "
<pre>$output</pre>";
echo "Composer";
$output = shell_exec('curl -sS https://getcomposer.org/installer | php');
echo "
<pre>$output</pre>";

$output = shell_exec('php composer.phar install');
echo "
<pre>$output</pre>";

echo "end";