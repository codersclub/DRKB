<h1>В основном help'е в Delphi не работает индекс по Win32</h1>
<div class="date">01.01.2007</div>


<p>- в /help/delphi3.cfg добавить строку типа</p>
<p> &nbsp; :index Win32=Win32.hlp</p>
<p> &nbsp; она должна быть добавлена перед строкой</p>
<p> &nbsp; :Link win32.hlp</p>
<p> &nbsp; - стереть delphi3.gid</p>
<p> &nbsp; - запустить Help и получать удовольствие</p>

<p> &nbsp; В delphi3.cnt тоже нужно строчку добавить:</p>
<p> &nbsp; :include win32.cnt</p>
<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>

