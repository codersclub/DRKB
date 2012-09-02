<h1>Добавление строк в Memo</h1>
<div class="date">01.01.2007</div>


<pre>
Memo1.Perform( WM_SETREDRAW, 0, 0 );
// ... здесь можно добавлять строки
Memo1.Perform( WM_SETREDRAW, 1, 0 );
Memo1.Refresh;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
