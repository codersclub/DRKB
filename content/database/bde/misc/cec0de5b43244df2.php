<h1>Как заставить BDE сохранять в БД поле времени с сотыми долями секунды</h1>
<div class="date">01.01.2007</div>


<p>Если руками, то в BDE Administrator (BDE Configuration Utility). </p>

<p>Если при инсталляции твоей программы, то -</p>
<p>В пункте Make Registry Changes InstallShield'а создай ключ</p>

<p>HKEY_LOCAL_MACHINE\SOFTWARE\Borland\Database Engine\Settings\SYSTEM\FORMATS\TIME\MILSECONDS=TRUE</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
