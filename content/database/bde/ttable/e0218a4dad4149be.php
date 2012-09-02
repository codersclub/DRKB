<h1>Поиск по нескольким полям</h1>
<div class="date">01.01.2007</div>



<pre>
keyfields:='name;name_1;n_dom;n_kw';
keyvalues:=VarArrayOf([combobox1.Text, combobox2.Text, edit2.Text, edit3.text]);
if dmod.qrfiz.Locate(keyfields,keyvalues,[])=false then
  dmod.qrfiz.Locate('id',id1,[]);
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
