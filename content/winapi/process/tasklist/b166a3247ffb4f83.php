<h1>Как разрешить / запретить переключение между задачами?</h1>
<div class="date">01.01.2007</div>


<p>только для ALT+TAB и CTRL+ESC)</p>

<p>Это не совсем профессиональный способ, но он работает! Мы просто эмулируем запуск и остановку скринсейвера.</p>
<pre>
Procedure TaskSwitchingStatus( State : Boolean ); 
Var 
    OldSysParam : LongInt; 
Begin 
    SystemParametersInfo( SPI_SCREENSAVERRUNNING, Word( State ), @OldSysParam, 0 ); 
End;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

