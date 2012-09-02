<h1>В каком порядке происходят события при создании и показе окна?</h1>
<div class="date">01.01.2007</div>


<p>При создании окна обработчики событий выполняются в следующем порядке:</p>

<p> &nbsp; &nbsp; &nbsp; &nbsp;OnCreate</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;OnShow</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;OnPaint</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;OnActivate</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;OnResize</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;OnPaint (снова)</p>

<p>Copyright © 1996 Epsylon Technologies</p>
<p>Взято из FAQ Epsylon Technologies (095)-913-5608; (095)-913-2934; (095)-535-5349</p>
