<?php
  date_default_timezone_set('Europe/London');
  set_time_limit(0);
  
  function processWeathermaps()
  {
    $time = date('[H:m:s]');
    echo "{$time} Processing weathermaps\r\n";
    $configs = glob('/configs/*.conf');
    foreach ($configs as $config) {
      processWeathermap(substr($config, 9, -5));
    }
  }
  
  function processWeathermap($file)
  {
    $time = date('[H:m:s]');
    echo "{$time} Processing {$file}\r\n";
    $path = "/output/{$file}";
    $archiveFileName = date('YmdHis') . "-{$file}.png");
    
    // Execute weathermap
    if (!file_exists($path)) {
      mkdir($path);
    }
    passthru("php /opt/network-weathermap/weathermap --config /configs/{$file}.conf --output {$path}/weathermap.png --htmloutput {$path}/index.html");
    
    // Copy weathermap to archive
    if (!file_exists($path . '/archive/')) {
      mkdir($path . '/archive');
    }
    copy($path . '/weathermap.png', $path . '/archive/' . $archiveFileName);
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
