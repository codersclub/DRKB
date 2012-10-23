<h1>Не сохраняются изменения в базе Paradox</h1>
<div class="date">01.01.2007</div>


<p>Где-нибудь при закрытии главной формы выполните нижеследующие куски кода:</p>
<p>при открытой таблице:</p>
<pre>
Table.FlushBuffers;
</pre>


<p>Для прочих:</p>
<pre>
Table.Open; 
Check(dbiSaveChanges(Table.Handle)); 
Table.Close;
</pre>

<p>Чтобы сбросить кэш, можно еще после этого сделать:</p>
<pre>
asm
  mov ah, $0D
  int $21
end; 
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
