<?php
  set_time_limit(0);
  
  function processWeathermaps()
  {
    $time = date('[H:m:s]');
    echo "{$time} Processing weathermaps\r\n";
    $configs = glob('/configs/*.conf');
    foreach ($configs as $config) {
      processWeathermap(substr(9, -5, $config));
    }
  }
  
  function processWeathermap($file)
  {
    $time = date('[H:m:s]');
    echo "{$time} Processing {$file}\r\n";
    $path = "/output/{$file}";
    $archiveFileName = date('YmdHis-{$file}.png');
    
    // Execute weathermap
    passthru("/usr/bin/php opt/network-weathermap/weathermap --config /configs/{$file}.conf --output {$path}/weathermap.png --htmloutput {$path}/index.html");
    
    // Copy weathermap to archive
    copy($path . '/weathermap.png', $path . '/archive/' . $archiveFilename);
  }

  while (true) {
    $start = time();
    processWeathermaps();
    $end = time();
    $toSleep = 60 - ($end - $start);
    if ($toSleep < 0) {
      $toSleep = 0;
    } elseif ($toSleep > 60) {
      $toSleep = 60;
    }
    sleep($toSleep);
  }
