<h1>Ошибка: lock manager out of room</h1>
<div class="date">01.01.2007</div>



<p>Go to the interbase/bin directory (Windows) or /usr/interbase (Unix) and locate the configuration file isc_config. By default your configuration file will look like this:</p>

<p>#V4_LOCK_MEM_SIZE        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;98304</p>
<p>#ANY_LOCK_MEM_SIZE       &nbsp; &nbsp; &nbsp; &nbsp;98304</p>
<p>#V4_LOCK_SEM_COUNT       &nbsp; &nbsp; &nbsp; &nbsp;32</p>
<p>#ANY_LOCK_SEM_COUNT   &nbsp; &nbsp; &nbsp; &nbsp;32</p>
<p>#V4_LOCK_SIGNAL         &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;16</p>
<p>#ANY_LOCK_SIGNAL         &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;16</p>
<p>#V4_EVENT_MEM_SIZE   &nbsp; &nbsp; &nbsp; &nbsp;     &nbsp; &nbsp; &nbsp; &nbsp;32768</p>
<p>#ANY_EVENT_MEM_SIZE      &nbsp; &nbsp; &nbsp; &nbsp;32768</p>

<p>I increased the V4_LOCK_MEM_SIZE entry from 98304 to 198304 and things were fine then.</p>

<p>!!! Important !!!</p>

<p>By default all lines in the config file are commented out with the leading # sign. Make sure to remove the # sign in any line that you change - the default config file just shows the default parameters.</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
